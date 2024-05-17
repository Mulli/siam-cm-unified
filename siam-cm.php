<?php
/**
 * Plugin Name: Siam Call Marker API
 * Description: Siam - Call Marker API, including: office (nana), application tests, siam-tours.com Elementor forms and phone number validation.
 * Version: 0.94
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
include_once  plugin_dir_path(__FILE__) . "inc/form-field-validation.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/send-request.php" ;
include_once  plugin_dir_path(__FILE__) . "inc/siam-tours-cm-new-forms.php" ;
add_action( 'elementor_pro/forms/new_record', 'handle_siam_tours_cm_new_forms', 10, 2 ); // new list & new mappings

function siam_scripts() {
    $ver = filemtime(plugin_dir_path(__FILE__) . '/js/siam-cm.js');
    wp_enqueue_script( 'siam-cm-js', plugin_dir_url(__FILE__) . 'js/siam-cm.js?'.$ver , array('jquery'), '0.6', true );
}

add_action( 'wp_enqueue_scripts', 'siam_scripts' );
/*
zapier home page: https://hooks.zapier.com/hooks/catch/14873499/3da7dvr/
zapier יעדים קטן: https://hooks.zapier.com/hooks/catch/14873499/3maxesu/
zapier משפחות: https://hooks.zapier.com/hooks/catch/14873499/3mo6c3d/
zapier צור קשר: https://hooks.zapier.com/hooks/catch/14873499/3motwz1/
zapier מזג אויר: https://hooks.zapier.com/hooks/catch/14873499/3mot97c/
zapier  מלונות בתאילנד תחתון: https://hooks.zapier.com/hooks/catch/14873499/3mo6r6h/
zapier  מלונות בתאילנד ראשון: https://hooks.zapier.com/hooks/catch/14873499/3mo631s/
zapier  קמפיין חול: https://hooks.zapier.com/hooks/catch/14873499/3ze85i2/
zapier יעדים מורחב: https://hooks.zapier.com/hooks/catch/14873499/3map5gx/
zapier תחתון ירח דבש: https://hooks.zapier.com/hooks/catch/14873499/3mo6njl/
zapier יעדים ראשון: https://hooks.zapier.com/hooks/catch/14873499/3moy32p/
zapier יעדים תחתון: no zapier!
zapier אטרקציה במתנה : https://hooks.zapier.com/hooks/catch/14873499/38jolpv/
zapier תחתון טיסות: https://hooks.zapier.com/hooks/catch/14873499/3mo6glf/
zapier אטרקציות תחתון: https://hooks.zapier.com/hooks/catch/14873499/3mo6kuj/
zapier שאלות נפוצות: https://hooks.zapier.com/hooks/catch/14873499/3moth88/
zapier בילויים ומסיבות: https://hooks.zapier.com/hooks/catch/14873499/3motujf/
*/