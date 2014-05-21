<?php
 
/**
* Better Limit Submissions Per Time Period by User or IP
* http://gravitywiz.com/2012/05/12/limit-ip-to-one-submission-per-time-period
*/
 
class GWSubmissionLimit {
var $_args;
function __construct($args) {
$this->_args = wp_parse_args($args, array(
'form_id' => false,
'limit' => 1,
'time_period' => 30 * 60 * 24, // must be provided in seconds: 60 seconds in a minute, 60 minutes in an hour, 24 hours in a day
'limit_message' => __('Sorry, you have reached the submission limit for this form.'),
'limit_by' => 'ip' // also accepts "user_id"
));
$form_filter = $this->_args['form_id'] ? "_{$this->_args['form_id']}" : '';
add_filter("gform_pre_render{$form_filter}", array($this, 'pre_render'));
add_filter("gform_validation{$form_filter}", array($this, 'validate'));
}
function pre_render($form) {
if( !$this->is_limit_reached($form['id']) )
return $form;
$submission_info = rgar(GFFormDisplay::$submission, $form['id']);
// if no submission, hide form
// if submission and not valid, hide form
if(!$submission_info || !rgar($submission_info, 'is_valid')) {
add_filter('gform_get_form_filter', create_function('', "return '<div class=\"limit-message\">{$this->_args['limit_message']}</div>';") );
//add_filter('gform_get_form_filter', create_function('$form_string, $form', 'return $form["id"] == ' . $form['id'] . ' ? \'<div class=\"limit-message\">' . $this->_args['limit_message'] . '</div>\' : $form_string;'), 10, 2 );
}
return $form;
}
function validate($validation_result) {
if($this->is_limit_reached($validation_result['form']['id']))
$validation_result['is_valid'] = false;
return $validation_result;
}
public function is_limit_reached($form_id) {
global $wpdb;
$limit_by = is_array($this->_args['limit_by']) ? $this->_args['limit_by'] : array($this->_args['limit_by']);
$where = array();
foreach($limit_by as $limiter) {
switch($limiter) {
case 'user_id':
$where[] = $wpdb->prepare('created_by = %s', get_current_user_id());
break;
case 'embed_url':
$where[] = $wpdb->prepare('source_url = %s', RGFormsModel::get_current_page_url());
break;
default:
$where[] = $wpdb->prepare('ip = %s', RGFormsModel::get_ip());
}
}
$where[] = $wpdb->prepare('form_id = %d', $form_id);
$where[] = $wpdb->prepare('date_created BETWEEN DATE_SUB(utc_timestamp(), INTERVAL %d SECOND) AND utc_timestamp()', $this->_args['time_period']);
$where = implode(' AND ', $where);
$sql = "SELECT count(id)
FROM {$wpdb->prefix}rg_lead
WHERE $where";
$entry_count = $wpdb->get_var($sql);
return $entry_count >= $this->_args['limit'];
}
}
 
// standard usage
new GWSubmissionLimit(array(
'form_id' => 86,
'limit' => 2,
'limit_message' => 'Aha! You have been limited.'
));



// get taxonomies terms links
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
           foreach ( $terms as $term ) {
        $out[] =
          '  <a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a>\n";
      }
      
    }
  }

  return implode('', $out );
}





/**
* Better Pre-submission Confirmation
* http://gravitywiz.com/2012/08/04/better-pre-submission-confirmation/
*/
 
class GWPreviewConfirmation {
 
private static $lead;
 
function init() {
 
add_filter('gform_pre_render', array('GWPreviewConfirmation', 'replace_merge_tags'));
add_filter('gform_replace_merge_tags', array('GWPreviewConfirmation', 'product_summary_merge_tag'), 10, 3);
 
}
 
public static function replace_merge_tags($form) {
 
$current_page = isset(GFFormDisplay::$submission[$form['id']]) ? GFFormDisplay::$submission[$form['id']]['page_number'] : 1;
$fields = array();
 
// get all HTML fields on the current page
foreach($form['fields'] as &$field) {
 
// skip all fields on the first page
if(rgar($field, 'pageNumber') <= 1)
continue;
 
$default_value = rgar($field, 'defaultValue');
preg_match_all('/{.+}/', $default_value, $matches, PREG_SET_ORDER);
if(!empty($matches)) {
// if default value needs to be replaced but is not on current page, wait until on the current page to replace it
if(rgar($field, 'pageNumber') != $current_page) {
$field['defaultValue'] = '';
} else {
$field['defaultValue'] = self::preview_replace_variables($default_value, $form);
}
}
 
// only run 'content' filter for fields on the current page
if(rgar($field, 'pageNumber') != $current_page)
continue;
 
$html_content = rgar($field, 'content');
preg_match_all('/{.+}/', $html_content, $matches, PREG_SET_ORDER);
if(!empty($matches)) {
$field['content'] = self::preview_replace_variables($html_content, $form);
}
 
}
 
return $form;
}
 
/**
* Adds special support for file upload, post image and multi input merge tags.
*/
public static function preview_special_merge_tags($value, $input_id, $merge_tag, $field) {
// added to prevent overriding :noadmin filter (and other filters that remove fields)
if( !$value )
return $value;
$input_type = RGFormsModel::get_input_type($field);
$is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
$is_multi_input = is_array( rgar($field, 'inputs') );
$is_input = intval( $input_id ) != $input_id;
if( !$is_upload_field && !$is_multi_input )
return $value;
 
// if is individual input of multi-input field, return just that input value
if( $is_input )
return $value;
$form = RGFormsModel::get_form_meta($field['formId']);
$lead = self::create_lead($form);
$currency = GFCommon::get_currency();
 
if(is_array(rgar($field, 'inputs'))) {
$value = RGFormsModel::get_lead_field_value($lead, $field);
return GFCommon::get_lead_field_display($field, $value, $currency);
}
 
switch($input_type) {
case 'fileupload':
$value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
$value = self::preview_image_display($field, $form, $value);
break;
default:
$value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
$value = GFCommon::get_lead_field_display($field, $value, $currency);
break;
}
 
return $value;
}
 
public static function preview_image_value($input_name, $field, $form, $lead) {
 
$field_id = $field['id'];
$file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
$source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];
 
if(!$file_info)
return '';
 
switch(RGFormsModel::get_input_type($field)){
 
case "post_image":
list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
$value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
break;
 
case "fileupload" :
$value = $source;
break;
 
}
 
return $value;
}
 
public static function preview_image_display($field, $form, $value) {
 
// need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
$input_name = "input_" . str_replace('.', '_', $field['id']);
$file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
 
$file_path = $value;
if(!empty($file_path)){
$file_path = esc_attr(str_replace(" ", "%20", $file_path));
$value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
}
return $value;
 
}
 
/**
* Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
*/
public static function create_lead( $form ) {
if( empty( self::$lead ) ) {
self::$lead = RGFormsModel::create_lead( $form );
self::clear_field_value_cache( $form );
}
return self::$lead;
}
 
public static function preview_replace_variables($content, $form) {
 
$lead = self::create_lead($form);
 
// add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
// beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
// result in an infinite loop if not called first above
add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);
 
$content = GFCommon::replace_variables($content, $form, $lead, false, false, false);
 
// remove filter so this function is not applied after preview functionality is complete
remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));
 
return $content;
}
 
public static function product_summary_merge_tag($text, $form, $lead) {
 
if(empty($lead))
$lead = self::create_lead($form);
 
$remove = array("<tr bgcolor=\"#EAF2FA\">\n <td colspan=\"2\">\n <font style=\"font-family: sans-serif; font-size:12px;\"><strong>Order</strong></font>\n </td>\n </tr>\n <tr bgcolor=\"#FFFFFF\">\n <td width=\"20\">&nbsp;</td>\n <td>\n ", "\n </td>\n </tr>");
$product_summary = str_replace($remove, '', GFCommon::get_submitted_pricing_fields($form, $lead, 'html'));
 
return str_replace('{product_summary}', $product_summary, $text);
}
public static function clear_field_value_cache( $form ) {
if( ! class_exists( 'GFCache' ) )
return;
foreach( $form['fields'] as &$field ) {
if( GFFormsModel::get_input_type( $field ) == 'total' )
GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
}
}
 
}
 
GWPreviewConfirmation::init();


// set is paid to 1 
add_filter("gform_field_value_ispaid", "swd_populate_ispaid");
function swd_populate_ispaid( $value ){
return 1;
}

