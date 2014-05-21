    <?php

     /*

Template Name:	Home Template

@name			Ad list Home page
@package		bloggers.com
@since			1.0.0
@author			Stevie Dean <stevie@seoulwebdesign.com>
@copyright		Copyright (c) 2013, bloggers.com
@link			http://www.seoulwebdesign.com

*/

?>
      
  <ul class="tblHeader">
           <li>
           <span class="col3 area">Ad Type</span>
           <span class="col3 areaDesc">Title</span>
           <span class="col3 areaCat last">Category</span>
            </li>
    </ul>

   <ul class="tblContent">
       
    <?php


    //for a given post type, return all
$job_categories = array();
$job_terms = get_terms( 'job_category' );
foreach( $job_terms as $job_term) {
    $job_categories[] = $job_term->term_id;
}

$blog_categories = array();
$blog_terms = get_terms( 'blogger_category' );
foreach( $blog_terms as $blog_term) {
    $blog_categories[] = $blog_term->term_id;
}

$job_category_query = array( 'taxonomy' => 'job_category', 'field' => 'id', 'terms' => $job_categories );

$blog_category_query = array( 'taxonomy' => 'blogger_category', 'field' => 'id', 'terms' => $blog_categories );


$my_query = new WP_Query( array(
    'post_type' => array('job', 'blogger'),
    'ignore_sticky_posts' => 1,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'meta_value_num',
    'meta_key' => 'ispaid',
    'order' => 'ASC',
    'tax_query' => array(
        'relation' => 'OR',
        $job_category_query,
        $blog_category_query,
        )
    ));
    if( $my_query->have_posts() ) :
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <li>
           <span class="col3 area"><?php if (get_post_type( get_the_ID() ) == 'job') { ?> Help Wanted <?php } else echo 'Job Wanted'; ?></span> 
             <span class="col3 areaDesc"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
          <span class="col3 areaCat"> <?php echo custom_taxonomies_terms_links(); ?></span>
        </li>
    <?php endwhile;
    endif;
     wp_reset_postdata(); ?>
  </ul>

  

