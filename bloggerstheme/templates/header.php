<header id="header" role="banner">
	<div class="container">
			<div class="ya-logo pull-left">
				
				<a href="<?php echo get_home_url(); ?>">	<img src="<?php echo ya_options()->getCpanelValue('sitelogo'); ?>" alt="<?php bloginfo('name'); ?>"> </a>
			
			</div>
 
        <div class="pull-right">
            <p>Companies need bloggers, viral Marketing? Bloggers looking for jobs</p>
            <a class="desktopButton" href="/post-a-job/">Post here for free</a>

        </div>


        <?php if ( has_nav_menu('primary_menu') ): ?>
			<!-- Primary navbar -->
			<nav id="access" class="primary-menu" role="navigation">
				<div <?php ya_navbar_class(); ?>>
					<div class="navbar-inner">
						<div class="container">
							<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
					    		<span class="icon-bar"></span>
					            <span class="icon-bar"></span>
					            <span class="icon-bar"></span>
					  		</button>
							<div class="nav-collapse collapse">
								
								<?php
									$menu_class = 'nav nav-pills';
		                        	if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
										$menu_class .= ' nav-mega';
									} else $menu_class .= ' nav-css';
	                        	?>
								<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>

							
									<form role="search" method="get" id="searchform" class="navbar-search" action="<?php echo home_url('/'); ?>">
										<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="span2 search-query" placeholder="<?php _e('Search', 'roots'); ?> <?php bloginfo('name'); ?>">
									</form>
							
							</div>
						</div>
					</div>
				</div>
			</nav>
			<!-- /Primary navbar -->
			<?php endif; ?>
	</div>


   
	
</header>
<div class="container">
<style>
.bloggers2 { width: 320px; height: 50px; }
@media(min-width: 500px) { .bloggers2 { width: 468px; height: 60px; } }
@media(min-width: 800px) { .bloggers2 { width: 728px; height: 90px; } }
</style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- bloggers2 -->
<ins class="adsbygoogle bloggers2"
     style="display:inline-block"
     data-ad-client="ca-pub-9293835185967403"
     data-ad-slot="8963837422"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

<?php if ( is_active_sidebar_YA('banner') ): ?>
<div class="banner" id="banner">
	<div class="container">
		<?php dynamic_sidebar('banner'); ?>
	</div>
</div>
<?php endif; ?>


