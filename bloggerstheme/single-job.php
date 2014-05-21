<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
<?php $companyname =  get_post_meta( $post->ID, 'company_name', true ); 
      $website  =  get_post_meta( $post->ID, 'website', true ); 
      $email = get_post_meta( $post->ID, 'email', true ); 
      $applyhow = get_post_meta( $post->ID, 'how_apply', true ); 

?>
        <?php if (!empty($website)); { ?>
      <h4 class="text-center"> <a href="<?php echo $website; ?>" rel="nofollow"><?php echo $companyname; ?></a></h4>

        <?php } ?>
        <p class="text-center"> Is looking for a</p>

      <h2 class="entry-title text-center"><?php the_title(); ?></h2>
      
      <div class="meta">
      	<?php get_template_part('templates/entry-meta'); ?>
      </div>
    </header>
     <?php // get_social(); ?> 
    <div class="entry-content">
      
      
      
      <?php the_content(); ?>
      <div class="well">
      <h4>How to Apply:</h4>
      <!--//<?php echo apply_filters('the_content', $applyhow); ?> -->
      <?php echo $applyhow; ?>
      </div>
      
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'yatheme' ), 'after' => '</div>' ) ); ?>
    </div>
	<nav>
    	<ul class="pager">
      		<li class="previous"><?php previous_post_link( '%link', __( '<span class="icon-circle-arrow-left"></span> %title', 'framework' ), true );?></li>
      		<li class="next"><?php next_post_link( '%link', __( '%title <span class="icon-circle-arrow-right "></span>', 'framework' ), true ); ?></li>
    	</ul>
  	</nav>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
