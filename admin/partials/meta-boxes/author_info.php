<?php
global $post;
$first_name = get_post_meta( $post->ID, $this->prefix . '_author_first_name', true );
$last_name  = get_post_meta( $post->ID, $this->prefix . '_author_last_name', true );
?>
<style>
	#titlediv #title-prompt-text {
		display: none !important;
	}
</style>
<div class="authors_info-meta-box">
	<p class = "options-row">
		<label for = "<?php echo $this->prefix;?>_author_first_name">
			<?php echo __( 'First Name', 'MazenAuthors' );?>
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_author_first_name"
			name  = "<?php echo $this->prefix;?>_author_first_name"
			type  = "text"
			class = "name_field first"
			value = "<?php echo $first_name; ?>"
	</p>

	<p class = "options-row">
		<label for = "<?php echo $this->prefix;?>_author_last_name">
			<?php echo __( 'Last Name', 'MazenAuthors' );?>
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_author_last_name"
			name  = "<?php echo $this->prefix;?>_author_last_name"
			type  = "text"
			class = "name_field last"
			value = "<?php echo $last_name; ?>"
	</p>
</div>