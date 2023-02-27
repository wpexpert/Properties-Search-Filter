<?php

class SearchKotw_Main {

	public function get_posts_array_json( $posts, $user_id ) {
		$posts_array = array();
		foreach ( $posts as $post ) {
			$favorites       = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
			$favorites_array = json_decode( $favorites );
			$star_class      = 'non-favorite';
			$acf_description = get_field_object( 'description_of_project', $post->ID )['value'];
			if ( null !== $favorites_array && is_array( $favorites_array ) ) {
				$star_class = in_array( $post->ID, $favorites_array ) ? 'favorite' : 'non-favorite';
			}
			if ( strlen( $acf_description ) > 100 ) {
				$acf_description = substr( $acf_description, 0, 100 ) . '...';
			}

			$post_title_html = '<a href="' . get_permalink( $post ) . '">' . $post->post_title . '</a>' . $acf_description;
			$favorite_html   = '<a class="favorite-this" post-id="' . $post->ID . '" user-id = "' . $user_id . '"><i class="' . $star_class . ' fas fa-star"></i></a>';

			$deadline = get_field( 'bid_date', $post->ID );
			$posts_array[] = array(
				'post_id'    => $post->ID,
				'post_title' => $post_title_html,
				'date'       => get_post_time( get_option( 'date_format' ), false, $post, true ),
				'deadline'   =>  $deadline ? $deadline : '-',
				'favorite'   => $favorite_html,
			);
		}

		return json_encode( $posts_array, JSON_UNESCAPED_SLASHES );
	}

	public function output_posts( $posts, $user_id ) {
		?>
        <tr class="filteration-heading" data-user-id="<?php echo $user_id; ?>">
            <th data-id="title">Title</th>
            <th data-id="date">Date</th>
            <th data-id="bid-date" colspan="2">Bid Date</th>
        </tr>
		<?php
		foreach ( $posts as $post ) {
			$favorites       = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
			$favorites_array = json_decode( $favorites );
			$star_class      = 'non-favorite';
			$acf_description = get_field_object( 'description_of_project', $post->ID )['value'];
			if ( null !== $favorites_array && is_array( $favorites_array ) ) {
				$star_class = in_array( $post->ID, $favorites_array ) ? 'favorite' : 'non-favorite';
			}
			if ( strlen( $acf_description ) > 100 ) {
				$acf_description = substr( $acf_description, 0, 100 ) . '...';
			}

			?>
            <tr data-post-id="<?php echo $post->ID; ?>">
                <td class="post-title">
                     <a href="<?php echo get_permalink( $post ); ?>"><?php echo $post->post_title; ?></a>
					<?php echo $acf_description; ?>
                </td>
                <!--                            <td class="description">-->
				<?php //echo $acf_description; ?><!--</td>-->
                <td class="date"><?php echo get_the_date(); ?></td>
                <td class="deadline"><?php echo get_field( 'bid_date', $post->ID ); ?></td>
                <td class="favorite">
                    <a class="favorite-this" post-id="<?php echo $post->ID; ?>" user-id="<?php echo $user_id; ?>"><i
                                class="<?php echo $star_class; ?> fas fa-star"></i></a>
                </td>
            </tr>
			<?php
		}
	}
}