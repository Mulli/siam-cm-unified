<?php

// handle sima-tours.com elementor form to send data to CallMarker
// 1. Get fields from form submission
// 2. send only non empty fields to CallMarker
// 3. get reply & display it on screen using elementor form response
// and JS code on page

function handle_siam_tours_cm_new_forms( $record, $handler ) {
    
	$form_name = $record->get_form_settings( 'form_name' );
    $raw_fields = $record->get( 'fields' );
    error_log('handle_siam_tours_cm_new_forms raw fields= '. print_r($raw_fields, true));
    
    $fields = [];
	foreach ( $raw_fields as $id => $field ) {
		$fields[ $id ] = $field['value'];
	}
    $url = 'https://app.callmarker.com/api/simple/customers' ; //$fields['url'];
    $token = '8b369b5a7f8a26bafc646c4334444e21' ; // $fields['token'];
    $campaign = '6776' ; // $fields['campaign'];
    $page_id = siam_get_submission_id(); // $fields['page_id']; // do we need it?

    if ( 'nana form' == $form_name ){
        return nana_form($record, $handler, $fields, $page_id);
    }

    if ( 'app tests' == $form_name ){
        return app_tests($record, $handler, $fields, $page_id);
    }
    
    if ( 'form 5' == $form_name || 'form 3' == $form_name){
        $arg = siam_forms($form_name, $token, $fields, $page_id);
        return siam_cm_send_request($url, $arg);
    }
    
    if ( 'דברו איתנו עמוד הבית' == $form_name ){
        $arg = talk2us_homepage($token, $campaign, $fields,$page_id, 'עמוד הבית - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס - עמוד צור קשר' == $form_name){
        $arg = contact_page($token, $campaign, $fields, 'צור קשר - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס קמפיין ישראלים בחול - אנגלית' == $form_name){
        $arg = english_campaign($token, $campaign, $fields, 'קמפיין אנגלית - אתר');
        return siam_cm_send_request($url, $arg);
    }
    return ;     
}

function siam_forms($type, $token, $fields, $page_id){
    $arg = array(
        'token' => $token, //$fields['token'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $fields['campaign'] ?? '6776',  // '9343' - Code Mulli for testing
        'source' =>  $fields['cm_source'],
        'crm_id' => 'WP-'.$page_id,
        // user fields
        'name' => $fields['name'],
        'number' => $fields['phone'],
        'custom_field_11040' =>  $fields['flyticket'],
        // Call Marker fields
        'reset' => 'true'
    );
    if ($type == 'form 5'){
        $arg['email'] =  $fields['email'] ?? 'no email field';
        $arg['note'] =  $fields['message'];
        $arg['custom_field_11039'] = $fields['category'];
        $arg['custom_field_7189'] =  $fields['passengers'];
    }
    // error_log("siam_forms type= $type fields= ". print_r($fields, true));
    return $arg;
}

function english_campaign($token, $campaign, $fields, $source){
    $arg = array(
        'token' => $token, //$fields['token'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $fields['campaign'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $fields['name'],
        'number' => $fields['phone'],
        'email' => $fields['email'] ?? 'no email field',
        'source' =>  $source, // $fields['source'] ??
        'reset' => 'true'
    );
    $fldmap = array(
        'start_date' => 'custom_field_11042', // start_date = field_eaccf07     
        'flyticket' => 'custom_field_11040', // flyticket = field_42f1784
        'passengers' => 'custom_field_7189' // passengers = field_7a06bb9
    );
    // set to $arg the values from $fields according to the mapping in $fldmap
    $arg = map_wp2cm_fields($fldmap, $fields, $arg);
    return $arg;
}

function contact_page($token, $campaign, $fields, $source){
    $arg = array(
        'token' => $token, //$fields['token'], 
        'campaign' => $campaign, // $fields['campaign'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $fields['name'],
        'number' => $fields['phone'],
        'email' => $fields['email'],
        'source' =>  $source, // $fields['source'] =
        'reset' => 'true'
    );
    $fldmap = array(  // map website form fields to CallMarker fields
        'start_date' => 'custom_field_11042', // start_date = field_eaccf07
        'end_date' => 'custom_field_11043', // end_date = field_d62435a
        'message' => 'note',
        'flyticket' => 'custom_field_11040', // flyticket = field_42f1784
        'passengers' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    // set to $arg the values from $fields according to the mapping in $fldmap
    $arg = map_wp2cm_fields($fldmap, $fields, $arg);
    
    return $arg;
}

function talk2us_homepage($token, $campaign, $fields, $page_id, $source){
    $arg = array(
        'token' => $token, //$fields['token'],
        'campaign' => $campaign, // $fields['campaign'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'crm_id' => 'WP-'.$page_id,
        'name' => $fields['name'],
        'number' => $fields['phone'],
        'email' => $fields['email'],
        'source' =>  $source, // $fields['source'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'category' => 'custom_field_11039',
        'start_date' => 'custom_field_11042', // start_date = field_eaccf07
        'end_date' => 'custom_field_11043', // end_date = field_d62435a
        'message' => 'note',
        'flyticket' => 'custom_field_11040', // flyticket = field_42f1784
        'passengers' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $fields, $arg);
    if (empty($fields['passengers']) ) // fill up passengers if empty
            $arg['custom_field_7189'] = 'לא ידוע';
    return $arg;
}

function nana_form($record, $handler, $fields, $page_id){
    
    $arg = array(
        'token' => $fields['token'], 
        'campaign' => $fields['campaign'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'crm_id' => 'WP-'.$page_id,
        'name' => $fields['name'],
        'number' => $fields['phone'],
        'email' => $fields['email'],
        'source' => $fields['source']??'',
        'reset' => 'true'// ,        'international' => 'true'
    );
    $fldmap = array(
        'category' => 'custom_field_11039',
        'start_date' => 'custom_field_11042',
        'end_date' => 'custom_field_11043',
        'message' => 'note',
        'flyticket' => 'custom_field_11040',
        'passengers' => 'custom_field_7189'
    );
    
    $arg = map_wp2cm_fields($fldmap, $fields, $arg);

    if (empty($fields['passengers']) ) // fill up passengers if empty
            $arg['custom_field_7189'] = 'לא ידוע';
    
    // handle country code
    $arg = process_country_code($fields, $arg);
    
    $res = siam_cm_send_request($fields['url'], $arg, 'online-response');
    display_online_cm_response($handler, $res, $fields, $arg, $page_id);
    return ;
}

function app_tests($record, $handler, $fields, $page_id){  
    $arg = array(
        'token' => $fields['token'], 
        'campaign' => '9343', // $fields['campaign'], // '6776' - CM קוד סיאם טורס  '9343' - Code Mulli for testing
        'crm_id' => 'APP-'.$page_id,
        'number' => $fields['phone'],
        'note' => $fields['message'],
        'source' => $fields['source']??'app tests' // , 'reset' => 'true'
    );
    if ($fields['international'] == 'כן')
        $arg['international'] = 'true';

    switch($fields['msg_type']){ // either or but not both!
        case 'order':   $arg['custom_field_11073'] = $fields['link']; break;
        case 'vouchers':$arg['custom_field_11074'] = $fields['link']; break;
        default: break; // ignore
    }
   
    $res = siam_cm_send_request($fields['url'], $arg, 'online-response');

    display_online_cm_response($handler, $res, $fields, $arg, $page_id);
    return ;
}

// handle CallMarker response and display it on screen online for nana form & app tests
function display_online_cm_response($handler, $res, $fields, $arg, $page_id, $type='nana'){
    if (isset($res['status']) && $res['status'] == 'success'){
        $str = ($type == 'nana') ?  $res['message'] : $fields['link'];
        $html_msg = '<span style="color:green"> ' . $str . ' [ ' . $page_id . ' , ' . $arg['number']. ' ]' . '</span>';
        siam_response_message($handler, $html_msg);
    } else {
        error_log('handle_nana_form CM return FAIL = ' . print_r($res, true) . '  arg='. print_r($arg, true));
        $cm_response = isset($res) ? $res['message'] : ' סיבה לא ידועה';
        siam_response_message($handler, '<span style="color:red" id="cm-fail">קול מרקר סירוב: ' . $cm_response . '</span>');
    }
    error_log('app_tests CM RESPONSE=' . print_r($res, true) . ' SENT ARG='. print_r($arg, true) . ' FORM FIELDS='. print_r($fields, true));
    return ;     
}
// make sure response tage 'siam_cm_response' is in sync with JS and displayed on screen
function siam_response_message($handler, $str){
    return $handler->add_response_data( 'siam_cm_response', $str);   
}