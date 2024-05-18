<?php
/**
 * Plugin Name: Siam Call Marker API
 * Description: Siam - Call Marker API, including: siam-tours.com Elementor forms and phone number validation, adding form pages for office (nana) and application tests, 
 * Version: 0.99
 * Author: Mulli Bahr
 * Author URI:      https://site2goal.co.il
 * Text Domain:     siam
 * Domain Path:     /languages
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	die('no direct access'); // Exit if accessed directly.
}

include_once  plugin_dir_path(__FILE__) . "inc/country-codes.php" ; // for international phone numbers
include_once  plugin_dir_path(__FILE__) . "inc/get-page-by-title.php" ; // elementor admin form page (nana form)
include_once  plugin_dir_path(__FILE__) . "inc/form-pages.php" ; // elementor admin form page (nana form)
include_once  plugin_dir_path(__FILE__) . "inc/form-field-validation.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/send-email.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/send-cm-request.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/display-online-response.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/siam-tours-cm-new-forms.php" ; 
include_once  plugin_dir_path(__FILE__) . "inc/siam-cm-admin.php" ; 

add_action( 'elementor_pro/forms/new_record', 'handle_siam_tours_cm_new_forms', 10, 2 ); // new list & new mappings

function siam_scripts() {
    $ver = filemtime(plugin_dir_path(__FILE__) . '/js/siam-cm.js');
    wp_enqueue_script( 'siam-cm-js', plugin_dir_url(__FILE__) . 'js/siam-cm.js?'.$ver , array('jquery'), '0.6', true );
}

add_action( 'wp_enqueue_scripts', 'siam_scripts' );

register_activation_hook(__FILE__, 'siam_cm_activate');
function siam_cm_activate(){
    // Path to the JSON file containing the Elementor template
    $nana_template_path = plugin_dir_path(__FILE__) . 'forms/nana.json'; // 'forms/nana.json';
    create_elementor_form_page('nana new', $nana_template_path);
    $apptests_template_path = plugin_dir_path(__FILE__) . 'forms/apptests.json'; // 'forms/nana.json';
    create_elementor_form_page('app tests', $apptests_template_path);
}
register_deactivation_hook(__FILE__, 'siam_cm_deactivate');
function siam_cm_deactivate(){
    delete_elementor_form_page('nana new');
    delete_elementor_form_page('app tests');
}

