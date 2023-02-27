<?php
/**
 * Class KotwSearchs_Enqueue_Scripts
 */

if( !class_exists( 'KotwSearchs_Enqueue_Scripts' ) ):
    class KotwSearchs_Enqueue_Scripts extends KotwSearchs_Init {


        /**
         * KotwSearchs_Enqueue_Scripts constructor.
         */
        public function __construct() {
            parent::__construct();

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
        }


        /**
         * admin_scripts
         */
        public function admin_scripts () {
            wp_enqueue_style( $this->prefix . '-admin',  $this->plugin_url . '/admin/sass/admin.css', [], time() );
            wp_enqueue_media();
            wp_enqueue_script( $this->prefix . '-admin', $this->plugin_url . '/admin/js/admin.min.js', [], time(), true );

            global $post;
            wp_localize_script( $this->prefix . '-admin',
                'KotwSearchsObject',
                array(
                    'post_type' => isset( $post ) ? $post->post_type : ''
                )
            );

        }


        /**
         * front_scripts
         */
        public function front_scripts () {
            // Styles.
        	wp_enqueue_style( $this->prefix . '-bootstrap',  'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', [], '' );
        	wp_enqueue_style( $this->prefix . '-datatables',  '//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css', [], '1.10.21' );
            wp_enqueue_style( $this->prefix . '-fontawesome',  'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], time() );
            wp_enqueue_style( $this->prefix . '-front',  $this->plugin_url . '/front/sass/front.css', [], time() );
            wp_enqueue_style( $this->prefix . '-main',  $this->plugin_url . '/front/sass/main.css', [], time() );


            // Scripts.
            wp_enqueue_script( $this->prefix . '-datatables', '//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', ['jquery'], '1.10.21', false );
            wp_enqueue_script( $this->prefix . '-datatables-moment', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js', ['jquery'], '1.10.21', false );
            wp_enqueue_script( $this->prefix . '-datatables-datetime-moment', '//cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js', ['jquery'], '1.10.21', false );
            wp_enqueue_script( $this->prefix . '-front-min', $this->plugin_url . '/front/js/front.min.js', [], time(), true );
            wp_enqueue_script( $this->prefix . '-front', $this->plugin_url . '/front/js/front.js', [], time(), true );
            wp_enqueue_script( $this->prefix . '-ajax-functions', $this->plugin_url . '/front/js/ajaxFunctions.js', ['jquery'], time(), false );
            wp_localize_script( $this->prefix . '-front',
                'KotwSearchsObject',
                array(
                    'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                )
            );
	        wp_localize_script( $this->prefix . '-ajax-functions',
		        'KotwSearchsObject',
		        array(
			        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
		        )
	        );

        }
    }

    new KotwSearchs_Enqueue_Scripts();
endif;
