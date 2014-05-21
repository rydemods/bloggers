    <?php

     /*

Template Name:	profile Template

@name			bloggers profile list
@package		bloggers.com
@since			1.0.0
@author			Stevie Dean <stevie@seoulwebdesign.com>
@copyright		Copyright (c) 2014, bloggers.com
@link			http://www.seoulwebdesign.com

*/

?>

<?php 
   $profilecountry = get_post_meta( $post->ID, 'profile_country', true ); 
 ?>
      <h3 class="text-right"> <a href="http://www.bloggers.com/submit-profile/">Submit Profile</a> </h3>
  <ul class="tblHeader">
           <li>
           <span class="col3 area">Name</span>
           <span class="col3 areaDesc">Blog's Title</span>
           <span class="col3 areaCat last">Country</span>
            </li>
    </ul>

   <ul class="tblContent">
       
    <?php

 
   $my_query = new WP_Query( array(
    'post_type' => 'profile',
    'ignore_sticky_posts' => 1,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => '',
    
    'order' => 'ASC',

    ));

  

    if( $my_query->have_posts() ) :
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <li>
           <span class="col3 area"><?php $profilename = get_post_meta( $post->ID, 'profile_name', true );?> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $profilename; ?></a></span> 
             <span class="col3 areaDesc"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
          <span class="col3 areaCat">  <?php $profilecountry = get_post_meta( $post->ID, 'profile_country', true ); ?> <?php echo $profilecountry; ?> </span>
        </li>
    <?php endwhile;
    endif;
     wp_reset_postdata(); ?>
  </ul>

  

