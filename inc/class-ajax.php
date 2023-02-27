<?php


class KotwSearchs_Ajax extends KotwSearchs_Init {

	/**
	 * KotwSearchs_Ajax constructor.
	 */
	public function __construct() {
		parent::__construct();


		add_action( 'wp_ajax_nopriv_kotw_get_posts_json_array', array( $this, 'kotw_get_posts_json_array' ) );
		add_action( 'wp_ajax_kotw_get_posts_json_array', array( $this, 'kotw_get_posts_json_array' ) );


		add_action( 'wp_ajax_nopriv_kotw_get_posts_per_page', array( $this, 'kotw_get_posts_per_page' ) );
		add_action( 'wp_ajax_kotw_get_posts_per_page', array( $this, 'kotw_get_posts_per_page' ) );

		add_action( 'wp_ajax_nopriv_add_to_favorites', array( $this, 'add_to_favorites' ) );
		add_action( 'wp_ajax_add_to_favorites', array( $this, 'add_to_favorites' ) );

		add_action( 'wp_ajax_nopriv_remove_from_favorites', array( $this, 'remove_from_favorites' ) );
		add_action( 'wp_ajax_remove_from_favorites', array( $this, 'remove_from_favorites' ) );

		add_action( 'wp_ajax_nopriv_kotw_search_function', array( $this, 'kotw_search_function' ) );
		add_action( 'wp_ajax_kotw_search_function', array( $this, 'kotw_search_function' ) );

		add_action( 'wp_ajax_nopriv_kotw_get_posts_per_page_filtererd', array(
			$this,
			'kotw_get_posts_per_page_filtererd'
		) );
		add_action( 'wp_ajax_kotw_get_posts_per_page_filtererd', array( $this, 'kotw_get_posts_per_page_filtererd' ) );
	}

	public function kotw_get_posts_json_array() {

		$posts_args    = $_POST['postsArgs'];
		$posts         = get_posts( $posts_args );
 		$userID        = $_POST['userID'];
		$search_filter = new SearchKotw_Main();
		echo $search_filter->get_posts_array_json( $posts, $userID );
		wp_die();
	}

	public function kotw_get_posts_per_page() {

		$user_id  = get_current_user_id();
		$per_page = $_POST['perPage'];
		$posts    = get_posts(
			array(
				'post_type'   => 'post',
				'post_status' => 'publish',
				'numberposts' => $per_page
			)
		);
		$this->output_posts( $posts, $user_id );
		wp_die();
	}

	public function add_to_favorites() {

		$post_id = $_POST['postID'];
		$user_id = $_POST['userID'];

		$favorites       = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
		$favorites_array = json_decode( $favorites );
		if ( is_array( $favorites_array ) ) {
			if ( ! in_array( $post_id, $favorites_array ) ) {
				$favorites_array[] = $post_id;
			}
		} else {
			$favorites_array   = [];
			$favorites_array[] = $post_id;
		}

		update_user_meta( $user_id, '_kotw_favorite_jobs', json_encode( $favorites_array ) );

		echo $favorites = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
		wp_die();
	}

	public function remove_from_favorites() {
		$post_id = $_POST['postID'];
		$user_id = $_POST['userID'];

		$favorites       = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
		$favorites_array = json_decode( $favorites );
		if ( is_array( $favorites_array ) ) {
			if ( in_array( $post_id, $favorites_array ) ) {
				$favorites_array = array_diff( $favorites_array, array( 0 => $post_id ) );
			}
		}
		update_user_meta( $user_id, '_kotw_favorite_jobs', json_encode( $favorites_array ) );

		echo $favorites = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
		wp_die();
	}


	/** Search Function */
	public function kotw_search_function() {
		$query = new WP_Query(
			array(
				'post_type' => 'post',
				's'         => $_REQUEST['search']
			)
		);
		$search_filter = new SearchKotw_Main();
		echo $search_filter->get_posts_array_json( $query->posts, $_REQUEST['userID'] );
		wp_die();
	}

	/*** Filteration functions ***/
	public function kotw_get_posts_per_page_filtererd() {
		$from_date    = empty( $_POST['from_date'] ) ? '1-1-1' : $_POST['from_date'];
		$to_date      = empty( $_POST['to_date'] ) ? '9999-09-09' : $_POST['to_date'];
		$city         = $_POST['city'];
		//$csi_division = json_decode( $_POST['csi_division'] );
		$csi_division = $_POST['csi_division'] ;
		$active_postings    = empty( $_POST['active_postings'] ) ? '1-1-1' : $_POST['active_postings'];
		

		$user_id  = get_current_user_id();
		$per_page = $_POST['perPage'];

		$posts_args = array(
			'post_type'   => 'post',
			'post_status' => 'publish',
			'numberposts' => $per_page,
			'orderby'     => 'date',
			'order'       => 'DESC',
			"s"			  => empty($_POST["search_input"]) ? '' : $_POST['search_input']
		);

if(!empty( $from_date) && !empty($to_date )) {
		$posts_args['meta_query'] = array(
			array(
				'key'     => 'bid_date',
				'value'   => array( $from_date, $to_date ),
				'compare' => 'BETWEEN',
				'type'    => 'DATE'
			)
		);
}

		if( $active_postings == 'true' )
	 {
				$today = date('Ymd');
				$posts_args['meta_query'] = array(
					array(
						'key'     => 'bid_date',
						'compare' => '>=',
						'value' => $today,
						'type' => 'DATE'
					)
				);
		}

	//$checkboxes = explode()
	if(empty($_POST['city'])  && !empty($_POST['csi_division'])) {
		$relation = 'OR';
		$posts_args['tax_query'] = array(
			'relation' => $relation,
			array(
				'taxonomy' => 'csidiv',
				'field'    => 'term_id',
				'terms'    => $csi_division,
			),
			array(
				'taxonomy' => 'city',
				'field'    => 'term_id',
				'terms'    => $city,
			),
		);
	}

	if(!empty($_POST['city'])  && empty($_POST['csi_division'])) {
		$relation = 'OR';
		$posts_args['tax_query'] = array(
			'relation' => $relation,
			array(
				'taxonomy' => 'csidiv',
				'field'    => 'term_id',
				'terms'    => $csi_division,
			),
			array(
				'taxonomy' => 'city',
				'field'    => 'term_id',
				'terms'    => $city,
			),
		);
	}
	if(!empty($_POST['city'])  && !empty($_POST['csi_division'])) {
		$relation = 'AND';
		$posts_args['tax_query'] = array(
			'relation' => $relation,
			array(
				'taxonomy' => 'csidiv',
				'field'    => 'term_id',
				'terms'    => $csi_division,
			),
			array(
				'taxonomy' => 'city',
				'field'    => 'term_id',
				'terms'    => $city,
			),
		);
	}
	



		// if ( ! empty( $city ) ) {
		// 	$posts_args['tax_query'] = array(
		// 		array(
		// 			'taxonomy' => 'city',
		// 			'field'    => 'term_id',
		// 			'terms'    => $city,
		// 		),
		// 	);
		// }
		

		$posts = get_posts( $posts_args );
		$this->output_posts( $posts, $user_id );

		wp_die();
	}


	public function output_posts( $posts, $user_id ) {
		$search_filter_main = new SearchKotw_Main();
		$search_filter_main->output_posts( $posts, $user_id );
	}


}

new KotwSearchs_Ajax();