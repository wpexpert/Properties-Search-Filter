<?php
/*
Plugin Name: Search Filter & Display Properties
Plugin URI: #
Description: Search and Filter using AJAX.
Version: 1.0
Author: Irfan Ahmed
Author URI: #
License: GPL2
Text Domain: KotwSearch
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Globals */
global $csi_divisions;
/*$csi_divisions = array(
	'Division 01 — General Requirement',
	'Division 02 — Site Construction',
	'Division 03 — Concrete',
	'Division 04 — Masonry',
	'Division 05 — Metals',
	'Division 06 — Wood and Plastics',
	'Division 07 — Thermal and Moisture Protection',
	'Division 08 — Doors and Windows',
	'Division 09 — Finishes',
	'Division 10 — Specialties',
	'Division 11 — Equipment',
	'Division 12 — Furnishings',
	'Division 13 — Special Construction',
	'Division 14 — Conveying Systems',
	'Division 15 — Mechanical/Plumbing',
	'Division 16 — Electrical',
	'Division 17 — NONCONFORMING TO CSI SECTIONS',
); */

$csi_divisions = array(
	'div00' => 'Division 00 — Procurement and Contracting Requirements',
	'div01' => 'Division 01 — General Requirements',
	'div02' => 'Division 02 — Existing Conditions',
	'div03' => 'Division 03 — Concrete',
	'div04' => 'Division 04 — Masonry',
	'div05' => 'Division 05 — Metals',
	'div06' => 'Division 06 — Wood, Plastics, Composites',
	'div07' => 'Division 07 — Thermal and Moisture Protection',
	'div08' => 'Division 08 — Openings',
	'div09' => 'Division 09 — Finishes',
	'div10' => 'Division 10 — Specialties',
	'div11' => 'Division 11 — Equipment',
	'div12' => 'Division 12 — Furnishings',
	'div013' => 'Division 13 — Special Construction',
	'div14' => 'Division 14 — Conveying Equipment',
	'div15' => 'Division 21 — Fire Suppression',
	'div16' => 'Division 22 — Plumbing',
	'div17' => 'Division 23 — Heating, Ventilating, and Air Conditioning (HVAC)',
	'div18' => 'Division 25 — Integrated Automation',
	'div19' => 'Division 26 — Electrical',
	'div20' => 'Division 27 — Communications',
	'div21' => 'Division 28 — Electronic Safety and Security',
	'div22' => 'Division 31 — Earthwork',
	'div23' => 'Division 32 — Exterior Improvements',
	'div24' => 'Division 33 — Utilities',
	'div25' => 'Division 34 — Transportation',
	'div26' => 'Division 35 — Waterway and Marine Construction',
	'div27' => 'Division 40 — Process Integration',
	'div28' => 'Division 41 — Material Processing and Handling Equipment',
	'div29' => 'Division 42 — Process Heating, Cooling, and Drying Equipment',
	'div30' => 'Division 43 — Process Gas and Liquid Handling, Purification and Storage Equipment',
	'div31' => 'Division 44 — Pollution and Waste Control Equipment',
	'div32' => 'Division 45 — Industry-Specific Manufacturing Equipment',
	'div33' => 'Division 46 — Water and Wastewater Equipment',
	'div34' => 'Division 48 — Electrical Power Generation'
);



/** Init the plugin Imports */
require_once 'inc/class-init.php';
$laws_importer = new KotwSearchs_Init();
$laws_importer->main_imports();


/**
 * Registers activation and deactivation hooks
 */
register_activation_hook( __FILE__, array( 'KotwSearchs_Init', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'KotwSearchs_Init', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'KotwSearchs_Init', 'uninstall' ) );
