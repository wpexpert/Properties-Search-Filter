<?php
$args               = array(
	'posts_per_page' => 30,
	'post_type'        => 'post',
	'orderby'        => 'date',
	'order'          => 'DESC',
);
?>
<div id="results-wrapper">
    <table id="results-table" class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Site Walk Through</th>
            <th>Deadline</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php

$from_date    = empty( $_GET['from_date'] ) ? '1-1-1' : $_GET['from_date'];
$to_date      = empty( $_GET['to_date'] ) ? '9999-09-09' : $_GET['to_date'];
$city         = $_GET['city_of_project'];
//$csi_division = json_decode( $_GET['csi_division'] );
$csi_division = $_GET['csi_division'] ;
$active_postings    = empty( $_GET['active_postings'] ) ? '1-1-1' : $_GET['active_postings'];


$user_id  = get_current_user_id();
$per_page = 10;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$posts_args = array(
    'post_type'   => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $per_page,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'paged'      => $paged,
    "s"			  => empty($_GET["search_input"]) ? '' : $_GET['search_input']
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

if( $active_postings != '1-1-1' )
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
if(empty($_GET['city_of_project'])  && !empty($_GET['csi_division'])) {
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

if(!empty($_GET['city_of_project'])  && empty($_GET['csi_division'])) {
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
if(!empty($_GET['city_of_project'])  && !empty($_GET['csi_division'])) {
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


$posts = new WP_Query( $posts_args );

        ?>
		<?php
		// The Loop
        while ( $posts->have_posts() ) {
            $posts->the_post();
			$favorites       = get_user_meta( $user_id, '_kotw_favorite_jobs', true );
			$favorites_array = json_decode( $favorites );
			$star_class      = 'non-favorite';
			$acf_description = get_field_object( 'description_of_project', $posts->ID )['value'];
			if ( null !== $favorites_array && is_array( $favorites_array ) ) {
				$star_class = in_array( $post->ID, $favorites_array ) ? 'favorite' : 'non-favorite';
			}
			if ( strlen( $acf_description ) > 100 ) {
				$acf_description = substr( $acf_description, 0, 100 ) . '...';
			}

			?>
            <tr data-post-id="<?php echo $posts->ID; ?>">
                <td class="post-title">
                     <a href="<?php echo get_permalink( $posts->ID ); ?>"><?php echo get_the_title($posts->ID); ?></a>
					<?php echo $acf_description; ?>
                </td>
            
                <td class="date"><?php echo get_field('site_walk_through_date',$posts->ID); ?></td>
                <td class="deadline"><?php echo get_field( 'bid_date', $posts->ID ); ?></td>
                <td class="favorite">
                    <a class="favorite-this" post-id="<?php echo $posts->ID; ?>" user-id="<?php echo $user_id; ?>"><i
                                class="<?php echo $star_class; ?> fas fa-star"></i></a>
                </td>
            </tr>
			<?php
		}
        ?>
        <div class="pagination-div">
            <?php 
                echo paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $posts->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
            ?>
        </div>
        <?php
        wp_reset_postdata();
        ?>

        </tbody>
        <tfoot>
        <tr>
            <th>Title</th>
            <th>Site Walk Through</th>
            <th>Deadline</th>
            <th></th>
        </tr>
        </tfoot>
    </table>

</div>

<!-- <script>
	let postsArgs = '<?php echo json_encode( $args ); ?>';
	kotwAjaxFunctions.functions.getPostsJson( 'results-table', postsArgs, '<?php echo $user_id; ?>' );
</script> -->