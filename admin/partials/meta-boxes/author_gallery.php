<?php
global $post;
$author_gallery = get_post_meta( $post->ID, $this->prefix . '_author_gallery', true );
?>
<style>
	.image-uploader
</style>
<div class="authors_info-meta-box" id="authors_gallery">

	<?php
	?>
	<input
		id    = "<?php echo $this->prefix;?>_author_gallery"
		name  = "<?php echo $this->prefix;?>_author_gallery"
		type  = "hidden"
		class = "gallery-list"
		value = "<?php echo $author_gallery; ?>" />

	<p class = "options-row images-gallery-buttons">
		<a class="button-primary add-images"><?php echo __( 'Add Image(s)', 'MazenAuthors' ); ?></a>
		<a class="button-secondary reset-images"><?php echo __( 'Reset Image(s)', 'MazenAuthors' ); ?></a>
	</p>

	<p class = "options-row images-gallery">
		<?php
		$author_gallery_ids = explode( ',', $author_gallery );
		foreach ( $author_gallery_ids as $id ) {
			echo '<a href = "' . wp_get_attachment_url( $id ) . '">' . wp_get_attachment_image( $id, 'thumbnail' ) . '</a>';
		}
		?>
	</p>

</div>