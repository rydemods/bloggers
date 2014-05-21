<div class="meta-inner">
	<small>
		<span>Posted in </span><?php  echo custom_taxonomies_terms_links(); ?><span><?php the_date( get_option('date_format', 'F d,Y'), ' on '); ?></span>
		<p><?php the_tags(); ?></p>
	</small>
</div>
