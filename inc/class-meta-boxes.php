<?php
/**
 * Class KotwSearchs_Meta_Boxes
 */
if( !class_exists( 'KotwSearchs_Meta_Boxes' ) ):
class KotwSearchs_Meta_Boxes extends KotwSearchs_Init {

	/**
	 * KotwSearchs_Meta_Boxes constructor.
	 */
	public function __construct() {
		parent::__construct();

		// Hooks.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes_author' ) );

		// Filters
		//add_filter( 'wp_insert_post_data', array( $this, 'update_permalink_author_post_type' ), 50, 2 );
	}

	public function add_meta_boxes () {
		add_meta_box(
			$this->prefix . '-author_info',
			'Author Info',
			array( $this, 'KotwSearchs_author_info_callback' ),
			'authors',
			'normal'
		);

		add_meta_box(
			$this->prefix . '-author_bio',
			'Author Bio',
			array( $this, 'KotwSearchs_author_bio_callback' ),
			'authors',
			'normal'
		);

		add_meta_box(
			$this->prefix . '-author_links',
			'Author Links',
			array( $this, 'KotwSearchs_author_links_callback' ),
			'authors',
			'normal'
		);


		add_meta_box(
			$this->prefix . '-set_current_author',
			'Link Current Author to a wordpress user',
			array( $this, 'KotwSearchs_set_current_author_callback' ),
			'authors',
			'normal'
		);

		add_meta_box(
			$this->prefix . '-author_gallery',
			'Author Gallery',
			array( $this, 'KotwSearchs_author_gallery_callback' ),
			'authors',
			'normal'
		);


	}


	// Callbacks.
	public function KotwSearchs_author_info_callback () {
		include $this->plugin_path . '/admin/partials/meta-boxes/author_info.php';
	}

	public function KotwSearchs_author_bio_callback ( $post ) {
		$author_bio = get_post_meta( $post->ID, $this->prefix . '_author_bio', true );
		wp_editor( htmlspecialchars_decode( $author_bio ), $this->prefix . '_author_bio' );
	}

	public function KotwSearchs_author_links_callback ( $post ) {
		include $this->plugin_path . '/admin/partials/meta-boxes/author_links.php';
	}

	public function KotwSearchs_set_current_author_callback ( $post ) {
		include $this->plugin_path . '/admin/partials/meta-boxes/set_current_author.php';
	}

	public function KotwSearchs_author_gallery_callback ( $post ) {
		include $this->plugin_path . '/admin/partials/meta-boxes/author_gallery.php';
	}



	/**
     * 	save_meta_boxes_author
     *  Saves the author meta boxes fields.
     */
	public function save_meta_boxes_author ( $post_id ) {
		if ( 'authors' !== get_post_type( $post_id ) ) return;


		// Saving text inputs.
		$meta_text_values = [
			$this->prefix . '_author_first_name',
			$this->prefix . '_author_last_name',
			$this->prefix . '_wordpress_user_id',
			$this->prefix . '_wordpress_user',
			$this->prefix . '_author_gallery',

		];
		foreach ( $meta_text_values as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				$meta_value = sanitize_text_field( $_POST[$meta] );
				update_post_meta( $post_id, $meta, $meta_value );
			}
		}

		// Saving Bio Field.
		if( isset( $_POST[$this->prefix . '_author_bio'] ) ) {
			$author_bio = htmlspecialchars( $_POST[$this->prefix . '_author_bio'] );
			update_post_meta( $post_id, $this->prefix . '_author_bio', $author_bio );
		}

		// Saving URL inputs.
		$meta_non_text_values = [
			$this->prefix . '_author_facebook_url',
			$this->prefix . '_author_linkedin_url',
		];
		foreach ( $meta_non_text_values as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				$meta_value = esc_url_raw( $_POST[$meta] );
				update_post_meta( $post_id, $meta, $meta_value );
			}
		}


		// Saving CheckBox inputs.
		$meta_checkbox_inputs = [
			$this->prefix . '_is_linked_to_user'
		];
		foreach ( $meta_checkbox_inputs as $meta ) {
			if ( isset( $_POST[$meta] ) ) {
				update_post_meta( $post_id, $meta, 'on' );
			} else {
				update_post_meta( $post_id, $meta, '' );
			}
		}


        $first_name = get_post_meta( $post_id, $this->prefix . '_author_first_name', true );
        $last_name  = get_post_meta( $post_id, $this->prefix . '_author_last_name', true );

        // unhook this function to prevent infinite looping
        remove_action( 'save_post', array( $this, 'save_meta_boxes_author' ), 10 );
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => sanitize_title( $first_name . '-' . $last_name )
        ) );
        // re-hook this function
        add_action( 'save_post', array( $this, 'save_meta_boxes_author' ), 10, 1 );
	}


    /**
     *  update_permalink_author_post_type
     *  Updates the permalink each time the first and last name of the author change.
     * @param $data
     * @param $postarr
     * @return
     */
	public function update_permalink_author_post_type ( $data, $postarr ) {
	    if ( 'authors' !== $data['post_type'] ) return $data; // Exit if not 'author' post type.


        $post_id    = $postarr["ID"];
        $first_name = get_post_meta( $post_id, $this->prefix . '_author_first_name', true );
        $last_name  = get_post_meta( $post_id, $this->prefix . '_author_last_name', true );

        $data['post_name'] = sanitize_title( $first_name . '-' . $last_name );
        return $data;
    }

}

new KotwSearchs_Meta_Boxes();
endif;