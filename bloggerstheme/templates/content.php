<?php //!is_front_page() && get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID();?>" <?php post_class(); ?>>
		<div class="entry">
			<?php if (get_the_post_thumbnail()){?>
			<div class="entry-thumb">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("medium")?></a>
			</div>
			<?php }?>
			<div class="entry-content">
				<div class="entry-title">
					<h3>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
					</h3>
				</div>
				<div class="entry-meta">
				<?php get_template_part('templates/entry-meta'); ?>
				</div>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'yatheme' ), 'after' => '</div>' ) ); ?>
				</div>
				<div class="entry-footer">
					<a class="btn btn-mini read-more" href="<?php the_permalink()?>"><i class="icon-circle-arrow-right"></i>Continue reading</a>
				
				</div>
			</div>
		</div>
	</div>
<?php endwhile; ?>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav>
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>
<?php //get_template_part('templates/pagination'); ?>
