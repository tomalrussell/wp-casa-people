<?php
$post_id = get_the_id();
$position = get_post_meta($post_id, 'casa_people_position', true);
$email = get_post_meta($post_id, 'casa_people_email', true);
$tel = get_post_meta($post_id, 'casa_people_tel', true);
$tel_internal = get_post_meta($post_id, 'casa_people_tel_internal', true);
?>
<article <?php post_class(); ?>>
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<p><em class="position"><?= esc_html($position) ?></em></p>
	<p><a href="<?= the_permalink(); ?>">View profile</a> | <a href="mailto:<?= esc_attr($email); ?>">Send email</a></p>
	<p>Tel: <span class="tel"><?= esc_html($tel) ?></span> (internal <span class="internal"><?= esc_html($tel_internal); ?></span>)</p>
</article>
