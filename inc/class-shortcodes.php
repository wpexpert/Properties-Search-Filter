<?php
/**
 * Class KotwSearchs_Shortcode
 */
if ( ! class_exists( 'KotwSearchs_Shortcode' ) ):
	class KotwSearchs_Shortcode extends KotwSearchs_Init {

		/**
		 * FederalLaws_Shortcodes constructor.
		 */
		public function __construct() {
			parent::__construct();

			/** Adding Shortcodes */

			// Chemastro Natal Chart.
			add_shortcode( 'kotw-search-filter', array( $this, 'search_filter' ) );
		}


		/** Callbacks */
		public function search_filter() {

			ob_start();
			$shortcode_dir = $this->plugin_path . '/front/partials/shortcodes/search-filter';
			include_once $this->plugin_path . '/front/partials/shortcodes/search-filter/search-filter.php';
			$html = ob_get_clean();

			return $html;
		}
	}

	new KotwSearchs_Shortcode();
endif;