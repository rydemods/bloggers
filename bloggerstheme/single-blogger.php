<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
<?php $bloggername =  get_post_meta( $post->ID, 'blogger_name', true ); 
      $bloggerwebsite  =  get_post_meta( $post->ID, 'blogger_url', true ); 
      $bloggeremail = get_post_meta( $post->ID, 'blogger_email', true ); 
      $bloggercontact = get_post_meta( $post->ID, 'how_to_contact', true ); 

?>
        <?php if (!empty($bloggerwebsite)); { ?>
      <h4 class="text-center"> <a href="<?php echo $bloggerwebsite; ?>" rel="nofollow"><?php echo $bloggername; ?></a></h4>

        <?php } ?>
           <!--//<  <p class="text-center"> Is looking for a</p> -->

      <h2 class="entry-title text-center"><?php the_title(); ?></h2>
      
      <div class="meta">
      	<?php get_template_part('templates/entry-meta'); ?>
      </div>
    </header>
   <?php // get_social(); ?> 
    <div class="entry-content">
      
      <?php the_content(); ?>
      <div class="well">
      <h4>How to Contact:</h4> 
      <?php // echo apply_filters('the_content', $applyhow); ?>
      <?php echo $bloggercontact; ?>
      </div>
      
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'yatheme' ), 'after' => '</div>' ) ); ?>
    </div>
	<nav>
    	<ul class="pager">
      		<li class="previous"><?php previous_post_link( '%link', __( '<span class="icon-circle-arrow-left"></span> %title', 'framework' ), true );?></li>
      		<li class="next"><?php next_post_link( '%link', __( '%title <span class="icon-circle-arrow-right "></span>', 'framework' ), true ); ?></li>
    	</ul>
  	</nav>
  
  </article>
<?php endwhile; ?>
