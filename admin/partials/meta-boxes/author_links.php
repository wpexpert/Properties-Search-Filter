<?php
global $post;
$facebook  = get_post_meta( $post->ID, $this->prefix . '_author_facebook_url', true );
$linkedin  = get_post_meta( $post->ID, $this->prefix . '_author_linkedin_url', true );
?>
<div class="authors_info-meta-box">
	<p class = "options-row">
		<label for = "<?php echo $this->prefix;?>_author_facebook_url">
			<?php echo __( 'Facebook Url', 'MazenAuthors' );?>
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_author_facebook_url"
			name  = "<?php echo $this->prefix;?>_author_facebook_url"
			type  = "url"
			value = "<?php echo $facebook; ?>"
	</p>

	<p class = "options-row">
		<label for = "<?php echo $this->prefix;?>_author_last_name">
			<?php echo __( 'Linkedin Url', 'MazenAuthors' );?>
		</label>
		<input
			id    = "<?php echo $this->prefix;?>_author_linkedin_url"
			name  = "<?php echo $this->prefix;?>_author_linkedin_url"
			type  = "url"
			value = "<?php echo $linkedin; ?>"
	</p>
</div>