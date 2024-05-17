<?php

add_action('elementor_pro/forms/validation/tel', function( $field, $record, $ajax_handler ) {
    global $country_prefix;
    // determine if internatinal
    $fv = $field['value'];
    if ($fv[0] == '+'){
        $found = false;
        for ($i = 4; $i > 0; $i--){ // search for longest matching string
            $prefix = substr($fv, 1, $i); // initial first $i charaters to look
            //error_log("elementor_pro/forms/validation/tel i= $i prefix= $prefix");

            if (array_key_exists($prefix, $country_prefix)){ // found
    // 1. find the code and remove it for additional validity check only
                $fv = substr($fv, $i+1); // look for the rest of the number
                $found = true;
                break;
            }
        }
        if (!$found) // expected international number
            return $ajax_handler->add_error( $field['id'], 'מספר עם קידומת +  אבל לא נמצא קוד מדינה תקין' );
       // error_log('elementor_pro/forms/validation/tel FOUND legit international phone PREFIX '. $field['value']);
    }
    // determine if Israeli
    // Match length  9 digits starting with 0 AS required by the client
    error_log('elementor_pro/forms/validation/tel field='. print_r($fv, true));
    if (!valid_phone_number($fv)){
        $ajax_handler->add_error( $field['id'], 'המספר יכיל 10 ספרות או 9 ללא 0 בהתחלה, במבנה: 0XX-XXX-XXXX' );
    } else 
        error_log('elementor_pro/forms/validation/tel FOUND legit international FULL phone # '. $field['value']);
    return ;
}, 10, 3 );

// check if phone number is valid
function valid_phone_number($str){
    //error_log("valid_phone_number BEFORE str= $str");

    $str = trim($str); // remove leading and trailing spaces
    $str = str_replace('-', '', $str);  // remove hyphens
    $str = str_replace(' ', '', $str);  // remove spaces
    $str = str_replace('.', '', $str);  // remove spaces
    //error_log("valid_phone_number AFTER str= $str");
    return !(preg_match( '/0[0-9]{9}/', $str ) !== 1 && preg_match( '/[1-9][0-9]{8}/', $str ) !== 1);
}
// Validate email is done by the browesr
add_action( 'elementor_pro/forms/validation', function ( $record, $ajax_handler ) {
	$fields = $record->get_field( [
    	'id' => 'email',
	] );
	
	if ( empty( $fields ) )
        return;
	
	$field = current( $fields );

	if (! empty($field['value']) && ! is_email( $field['value'] ) ) {
		$ajax_handler->add_error( $field['id'], 'כתובת אימייל לא תקינה' );
	}
}, 10, 2 );

