<?php
while (have_posts()) :
	the_post();

	$post_id = get_the_id();
	$position = get_post_meta($post_id, 'casa_people_position', true);
	$email = get_post_meta($post_id, 'casa_people_email', true);
	$tel = get_post_meta($post_id, 'casa_people_tel', true);
	$tel_plain = str_replace("(0)","",$tel);
	$tel_plain = preg_replace("/[\s-]/","",$tel_plain);
	$tel_internal = get_post_meta($post_id, 'casa_people_tel_internal', true);
	$research_text = get_post_meta($post_id, 'casa_people_secondary_text', true);
	?>
	<article <?php post_class(); ?>>
		<header>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="row">
			<div class="col-1-4 entry-thumb">
				<?php
				if(has_post_thumbnail()) the_post_thumbnail('medium');
				?>
			</div>
			<div class="col-3-4">
				<ul class="ui-tabs-nav">
					<li><a href="#biography">Biography</a></li>
					<li><a href="#research">Research</a></li>
					<li><a href="#publications">Publications</a></li>
					<li><a href="#contact">Contact</a></li>
				</ul>
				<section id="biography" class="ui-tab">
					<h2 class="ui-tab-title">Biography</h2>
					<?php the_content(); ?>
				</section>
				<section id="research" class="ui-tab">
					<h2 class="ui-tab-title">Research</h2>
					<?= apply_filters('the_content', $research_text); ?>
				</section>
				<section id="publications" class="ui-tab">
					<h2 class="ui-tab-title">Publications</h2>
					<?php
					if(function_exists('cr_get_references')){
						$refs = cr_get_references();
					}
					if(!empty($refs)):
						?>
						<ul class="reference-list">
						<?= $refs; ?>
						</ul>
						<?php
					else:
						?>
						<p>(list publications)</p>
						<?php
					endif;
					?>
				</section>
				<section id="contact" class="ui-tab">
					<h2 class="ui-tab-title">Contact</h2>
					<p>Email: <a href="mailto:<?= esc_attr($email) ?>" target="_blank"><?= esc_html($email) ?></a></p>
					<p>Telephone: <a class="tel" href="tel:<?= esc_attr($tel_plain) ?>"><?= esc_html($tel) ?></a>
						(internal <span class="internal"><?= esc_html($tel_internal); ?></span>)</p>
				</section>
			</div>
		</div>
	</article>
<?php
endwhile;
?>
