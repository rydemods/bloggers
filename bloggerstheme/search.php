<section id="main">
	<div class="container-fluid">
		<?php 
		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs">', '</div>');
		}
		if (!is_front_page()) {
			get_template_part('templates/page', 'header');
		}
		?>
		
		<div class="page-content">
			<div class="row-fluid">
				<div class="span8">
					<div class="left-content">
						<?php if(have_posts()):?>

						
						<?php 
 while (have_posts()) : the_post(); ?>
						<div id="post-<?php the_ID();?>" <?php post_class(); ?>>
							<div class="entry-meta">
								<?php get_template_part('templates/entry-meta'); ?>
							</div>
							<div class="entry-content">
								<div class="entry-title">
									<h2>
										<a href="<?php the_permalink(); ?>
"><?php the_title(); ?> </a>
									</h2>
								
								</div>
								<div class="clearfix"></div>
								<figure>
									<?php the_post_thumbnail()?>
								</figure>
								<p>
									<?php the_excerpt(); ?>
								</p>
							</div>
						</div>
						<?php endwhile; ?>
						<!--Pagination-->
						<?php if ($wp_query->max_num_pages > 1) : ?>
						<?php global $paged;?>
						<div class="pagination nav-pag">
							<ul>
								<?php if (get_previous_posts_link()) : ?>
								<li class="pagination"><?php previous_posts_link(__('&lt; Prev ', 'roots')); ?>
								</li>
								<?php else: ?>
								<li class="disabled pagination"><a><?php _e('&lt; Prev', 'roots'); ?>
								</a></li>
								<?php endif; ?>

								<?php 
	      	if ($paged < 3){
	      		$i = 1;
	      	}
	      	elseif ($paged < $wp_query->max_num_pages - 2){
	      		$i = $paged -1 ;
	      	}
	      	else {
	      		$i = $wp_query->max_num_pages - 3;
	      	}
	      	 
	      	if ($wp_query->max_num_pages > $i + 3){
				$max = $i + 2;
			}
			else $max = $wp_query->max_num_pages;

			if ($paged == 3 && $wp_query->max_num_pages > 4) {?>
								<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
								<?php }
			if ($paged > 3 && $wp_query->max_num_pages > 4) {?>
								<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
								<li><a>...</a></li>
								<?php }
	      	for ($i; $i<= $max ; $i++){?>
								<?php if (($paged == $i) || ( $paged ==0 && $i==1)){?>
								<li class="disabled"><a><?php echo $i?> </a></li>
								<?php } else {?>
								<li><a href="<?php echo get_pagenum_link($i)?>"><?php echo $i?>
								</a></li>
								<?php }?>
								<?php }?>

								<?php if ($max < $wp_query->max_num_pages) {?>
								<li><a>...</a></li>
								<li><a
									href="<?php echo get_pagenum_link($wp_query->max_num_pages)?>"><?php echo $wp_query->max_num_pages?>
								</a></li>
								<?php }?>

								<?php if (get_next_posts_link()) : ?>
								<li class="pagination"><?php next_posts_link(__('Next &gt;', 'roots')); ?>
								</li>
								<?php else: ?>
								<li class="disabled pagination"><a><?php _e('Next &gt;', 'roots'); ?>
								</a></li>
								<?php endif; ?>
							</ul>
						</div>
						<?php endif; ?>
						<!--End Pagination-->
						<?php else : ?>
						<?php get_template_part('templates/no-results'); ?>
						<?php endif;?>
					</div>
				</div>
				<div class="span4">
					<?php 
					if (is_active_sidebar_YA('sidebar-primary')){
				dynamic_sidebar('sidebar-primary');
			}
			?>
				</div>
			</div>
		</div>
	</div>
</section>