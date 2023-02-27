<?php

$first_name = get_post_meta( $post->ID, $prefix . '_author_first_name', true );
$last_name  = get_post_meta( $post->ID, $prefix . '_author_last_name', true );

$facebook_url = get_post_meta( $post->ID, $prefix . '_author_facebook_url', true );
$linkedin_url = get_post_meta( $post->ID, $prefix . '_author_linkedin_url', true );

$author_bio     = get_post_meta( $post->ID, $prefix . '_author_bio', true );
$author_img     = get_post_meta( $post->ID, $prefix . '_author_bio', true );
$author_gallery = get_post_meta( $post->ID, $prefix . '_author_gallery', true );
?>

<div class = "mazenauthors-single-author-wrapper">
	<div class = "author-header">
		<div class="author-image">
			<?php echo get_the_post_thumbnail( $post, 'thumbnail' );?>
		</div>
		<div class="author-info">
			<div class="author-name">
				<h3><?php echo $first_name . ' ' . $last_name; ?></h3>
			</div>
			<div class="author-links">
				<a href = "<?php echo $facebook_url; ?>"><i class="fa fa-linkedin-square"></i></a>
				<a href = "<?php echo $linkedin_url; ?>"><i class="fa fa-facebook-f"></i></a>
			</div>
		</div>
	</div>

	<?php
	if( !empty( $author_bio ) ):
	?>
	<div class="author-bio">
		<h2 class="bio-header"><?php echo __( 'Author Bio', 'MazenAuthors' );?></h2>
		<?php echo htmlspecialchars_decode( $author_bio ); ?>
	</div>
	<?php endif;?>


	<?php
	if( !empty( $author_gallery ) ):
	?>
		<div class="author-gallery">
			<h3><?php echo __( 'Author Gallery', 'MazenAuthors' ); ?></h3>
			<?php
			$author_gallery_ids = explode( ',', $author_gallery );
			foreach ( $author_gallery_ids as $id ) {
				echo '<a href = "' . wp_get_attachment_url( $id ) . '">' . wp_get_attachment_image( $id, 'thumbnail' ) . '</a>';
			}
			?>
		</div>
	<?php endif; ?>


	<?php
	$is_linked_to_user = get_post_meta( $post->ID, $prefix . '_is_linked_to_user', true );
	if( 'on' === $is_linked_to_user ) {
		$linked_wordpress_user_id = get_post_meta( $post->ID, $prefix . '_wordpress_user_id', true );
		$posts = get_posts( array(
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'author'        => $linked_wordpress_user_id,
			'numberofposts' => -1
		) );
		?>
		<div class="author-posts">
				<h3><?php echo __( 'Author Posts', 'MazenAuthors' ); ?></h3>
				<ul>
					<?php
					foreach ( $posts as $post ) {
						?>
						<li><a href = "<?php echo get_permalink( $post ); ?>"><?php echo $post->post_title; ?></a></li>
						<?php
					}?>
				</ul>
		</div>
	<?php
	}
	?>

</div>

