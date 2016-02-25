<?php
namespace Casa\People\Meta;

function get_text_fields(){
	return array(
		'casa_people_position' => 'Position',
		'casa_people_email' => 'Email',
		'casa_people_twitter' => 'Twitter',
		'casa_people_tel' => 'External telephone',
		'casa_people_tel_internal' => 'Internal telephone',
	);
}

function setup_admin(){
	add_meta_box(
		'casa-people-details',             // html id for the metabox
		'Person Details',                  // title
		__NAMESPACE__.'\\details_metabox', // callback to print the html
		'person',                          // slug of relevant post-type
		'normal',                          // context (area of admin page)
		'high'                             // priority
	);
	add_meta_box(
		'casa-people-research-text',       // html id for the metabox
		'Secondary Text',                  // title
		__NAMESPACE__.'\\secondary_text_metabox', // callback to print the html
		'person',                          // slug of relevant post-type
		'normal',                          // context (area of admin page)
		'high'                             // priority
	);
}
add_action('add_meta_boxes_person',__NAMESPACE__.'\\setup_admin');

function details_metabox($post){
	wp_nonce_field( 'save_person_details', 'person_details' );

	foreach (get_text_fields() as $text_field => $label) {
		?>
		<div class="casa-meta-wrap">
			<label
				class="casa-meta-label"
				for="<?= $text_field ?>"><?= $label; ?></label>
			<input
				type="text"
				class="casa-meta-input"
				name="<?= $text_field ?>"
				id="<?= $text_field ?>"
				value="<?= get_post_meta($post->ID, $text_field, true); ?>">
		</div>
		<?php
	}

	$users = get_users(array( 'fields' => array( 'display_name', 'ID', 'user_login' )));
	$selected_user = get_post_meta($post->ID, 'casa_people_wp_user', true);
	?>
	<div class="casa-meta-wrap">
		<label
			class="casa-meta-label"
			for="casa_people_wp_user">Associated Blog User</label>
		<select
			class="casa-meta-input"
			name="casa_people_wp_user"
			id="casa_people_wp_user">
			<option value="">No user associated</option>
			<?php
			foreach ($users as $user):
				?>
				<option value="<?= $user->ID ?>" <?= ($user->ID == $selected_user)? 'selected="selected"' : '' ?> >
					<?= $user->display_name . ' (' . $user->user_login . ')' ?>
				</option>
				<?php
			endforeach;
			?>
		</select>
	</div>
	<?php
}

function secondary_text_metabox($post){
	wp_nonce_field( 'save_person_secondary_text', 'person_secondary_text' );
	$secondary_text =  get_post_meta($post->ID, 'casa_people_secondary_text' , true );
	wp_editor( $secondary_text, 'casa_people_secondary_text', $settings = array('textarea_name'=>'casa_people_secondary_text') );
}

function save_details($post_id){
	if (
		! isset( $_POST['person_details'] )
		|| ! wp_verify_nonce( $_POST['person_details'], 'save_person_details' )
		|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		|| ! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	foreach (get_text_fields() as $text_field => $label) {
		// Sanitize user input.
		$data = sanitize_text_field( $_POST[$text_field] );

		// Update the meta field in the database.
		update_post_meta( $post_id, $text_field, $data );
	}

	$data = intval($_POST['casa_people_wp_user']);
	if ($data == 0) $data = '';
	update_post_meta( $post_id, 'casa_people_wp_user', $data );
}
add_action( 'save_post_person', __NAMESPACE__.'\\save_details' );

function save_secondary_text($post_id){
	if (
		! isset( $_POST['person_secondary_text'] )
		|| ! wp_verify_nonce( $_POST['person_secondary_text'], 'save_person_secondary_text' )
		|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		|| ! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	$data = wp_filter_post_kses($_POST['casa_people_secondary_text']);
	update_post_meta($post_id, 'casa_people_secondary_text', $data );

}
add_action( 'save_post_person', __NAMESPACE__.'\\save_secondary_text' );