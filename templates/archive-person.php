<?php
get_template_part('templates/page', 'header');

if (!have_posts()) :
	?>
	<p class="alert alert-warning">
		<?php _e('Sorry, no results were found.', 'mechanicity'); ?>
	</p>
	<?php
	get_search_form();
endif;

while (have_posts()) :
	the_post();
	include WP_CASA_PEOPLE_DIR . '/templates/content-person.php';
endwhile;

the_posts_navigation();