<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
<?php $profilename =  get_post_meta( $post->ID, 'profile_name', true ); 
      $profilewebsite  =  get_post_meta( $post->ID, 'profile_blog_url', true ); 
      $profileemail = get_post_meta( $post->ID, 'profile_emial', true ); 
      $profilecountry = get_post_meta( $post->ID, 'profile_country', true ); 
      $blogdescription = get_post_meta( $post->ID, 'blog_description', true );

?>
        
      <h3 class="text-center"> <?php echo $profilename; ?></h3>
      <p class="text-center"> <?php echo $profilecountry; ?></p>

       
           <!--//<  <p class="text-center"> Is looking for a</p> -->

      <br />
      
      <div class="meta">
      	<?php get_template_part('templates/entry-meta'); ?>
      </div>
    </header>
    <?php get_social(); ?>
    <div class="entry-content">
      
      <?php the_content(); ?>
      <div class="well">
        <h4> <?php echo $profilename; ?>'s Blog</h4>
    
      <?php echo $blogdescription; ?>
      <p><a href="<?php echo $profilewebsite; ?>" rel="nofollow"><?php the_title(); ?></a></p>
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