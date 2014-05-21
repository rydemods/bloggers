<form role="search" method="get" id="searchform" class="navbar-search pull-right" action="<?php echo home_url('/'); ?>">
	 <div class="input-append">
   <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="span2 search-query" placeholder="<?php _e('Search', 'roots'); ?> <?php bloginfo('name'); ?>">
  <button type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn">
   </div>
    <div class="input-prepend">
    <button type="submit" class="btn">Search</button>
    <input type="text" class="span2 search-query">
    </div>
</form>

   