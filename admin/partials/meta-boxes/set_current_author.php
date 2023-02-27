<?php
global $post;
$wordpress_user_id = get_post_meta( $post->ID, $this->prefix . '_wordpress_user_id', true );
$wordpress_user    = get_post_meta( $post->ID, $this->prefix . '_wordpress_user', true );
$is_linked_to_user = get_post_meta( $post->ID, $this->prefix . '_is_linked_to_user', true );
?>
<div class="authors_info-meta-box" id = "set_current_wordpress_user">
	<p class = "options-row">
		<label for = "<?php echo $this->prefix;?>_is_linked_to_user">
			<?php echo __( 'Is linked to Existing User ?', 'MazenAuthors' );?>
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_is_linked_to_user"
			name  = "<?php echo $this->prefix;?>_is_linked_to_user"
			type  = "checkbox"
			class = "checkbox_field"
			<?php echo checked( 'on', $is_linked_to_user ); ?>
		/>
	</p>

	<?php
	$show_select = 'on' === $is_linked_to_user ? 'block' : 'none';
	?>
	<p class = "options-row" id = "select-user-wordpress" style = "display: <?php echo $show_select; ?>;">
		<label for = "<?php echo $this->prefix;?>_is_linked_to_user">
			<?php echo __( 'Choose User', 'MazenAuthors' );?> :
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_wordpress_user_id"
			name  = "<?php echo $this->prefix;?>_wordpress_user_id"
			type  = "number"
			class = "checkbox_field"
			value = "<?php echo $wordpress_user_id; ?>"
		/>
		<select name = "<?php echo $this->prefix . '_wordpress_user'; ?>" data-value = "<?php echo $wordpress_user; ?>">
			<option value = ""><?php echo __( 'Select User', 'MazenAuthors' );?></option>
			<?php
			$users = get_users();
			foreach ( $users as $user ) {
				?>
				<option value = "<?php echo $user->ID;?>"><?php echo $user->user_login; ?></option>
				<?php
			}
			?>
		</select>

	</p>
	<div class="ajax-results" style = "display: none;"></div>

</div>

<script>

</script>