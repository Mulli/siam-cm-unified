<?php

// handle sima-tours.com elementor form to send data to CallMarker
// 1. Get fields from form submission
// 2. send only non empty fields to CallMarker
// 3. get reply & display it on screen using elementor form response
// and JS code on page

function handle_siam_tours_cm_forms( $record, $handler ) {

	$form_name = $record->get_form_settings( 'form_name' );
    $raw_fields = $record->get( 'fields' );
    $url = 'https://app.callmarker.com/api/simple/customers' ; //$raw_fields['url']['value'];
    $token = '8b369b5a7f8a26bafc646c4334444e21' ; // $raw_fields['token']['value'];
    $campaign = '6776' ; // $raw_fields['campaign']['value'];

    if ( 'nana form' == $form_name ){
        return nana_form($record, $handler, $raw_fields);
    }
    if ( 'דברו איתנו עמוד הבית' == $form_name ){
        $arg = talk2us_homepage($token, $campaign, $raw_fields, 'עמוד הבית - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - ירח דבש' == $form_name){
        $arg = honey_month($token, $campaign, $raw_fields, 'ירח דבש - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - משפחות' == $form_name){
        $arg = family_bottom($token, $campaign, $raw_fields, 'משפחות - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס - עמוד צור קשר' == $form_name){
        $arg = contact_page($token, $campaign, $raw_fields, 'צור קשר - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - מזג אוויר' == $form_name){
        $arg = whether_page($token, $campaign, $raw_fields, 'מזג אויר - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס יעדים - קטן' == $form_name){
        $arg = location_small($token, $campaign, $raw_fields, 'יעדים קטן - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס ראשון - יעדים' == $form_name){
        $arg = location_first($token, $campaign, $raw_fields, 'יעדים ראשון - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - מלונות' == $form_name){
        $arg = hotels_bottom($token, $campaign, $raw_fields, 'מלונות - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס ראשון - מלונות בתאילנד' == $form_name){
        $arg = hotels_thailand($token, $campaign, $raw_fields, 'מלונות בתאילנד - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס קמפיין ישראלים בחול - אנגלית' == $form_name){
        $arg = english_campaign($token, $campaign, $raw_fields, 'קמפיין אנגלית - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס יעדים - מורחב' == $form_name){
        $arg = locations_large($token, $campaign, $raw_fields, 'יעדים מורחב - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - יעדים' == $form_name){
        $arg = locations_bottom($token, $campaign, $raw_fields, 'יעדים תחתון - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס קמפיין אטרקציה במתנה' == $form_name){
        $arg = attraction_present($token, $campaign, $raw_fields, 'אטרקציה במתנה - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - טיסות' == $form_name){
        $arg = flights_bottom($token, $campaign, $raw_fields, 'טיסות תחתון - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - אטרקציות' == $form_name){
        $arg = attraction_bottom($token, $campaign, $raw_fields, 'אטרקציות תחתון - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - שאלות נפוצות' == $form_name){
        $arg = faq_bottom($token, $campaign, $raw_fields, 'שאלות נפוצות - אתר');
        return siam_cm_send_request($url, $arg);
    }
    if ('טופס תחתון - בילויים ומסיבות' == $form_name){
        $arg = fun_parties($token, $campaign, $raw_fields, 'בילויים ומסיבות - אתר');
        return siam_cm_send_request($url, $arg);
    }
    return ;     
}
function fun_parties($token, $campaign, $raw_fields, $source){
    return attraction_bottom($token, $campaign, $raw_fields, $source);
}

function faq_bottom($token, $campaign, $raw_fields, $source){
    return attraction_bottom($token, $campaign, $raw_fields, $source);
}

function attraction_bottom($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
         'message' => 'custom_field_11044',
         'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
        //'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function flights_bottom($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] ??
        'reset' => 'true'
    );
    $fldmap = array(
         'message' => 'custom_field_11044',
         'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
        //'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function attraction_present($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_fac3177']['value'],
        'email' => $raw_fields['field_13ea098']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] ??
        'reset' => 'true'
    );
    $fldmap = array(
        'field_cf36a81' => 'custom_field_11042', // start_date = field_eaccf07

        'field_e77050a' => 'custom_field_11040', // flyticket = field_42f1784
        'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function locations_bottom($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] ??
        'reset' => 'true'
    );
    $fldmap = array(
         'message' => 'custom_field_11044',
         'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
        //'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function locations_large($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] ??
        'reset' => 'true'
    );
    $fldmap = array(
        'field_cf36a81' => 'custom_field_11042', // start_date = field_eaccf07
       // 'field_d62435a' => 'custom_field_11043', // end_date = field_d62435a
         'message' => 'custom_field_11044',
         'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
        //'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function english_campaign($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_fac3177']['value'],
        'email' => $raw_fields['field_13ea098']['value'] ?? 'no email field',
        'source' =>  $source, // $raw_fields['source']['value'] ??
        'reset' => 'true'
    );
    $fldmap = array(
        'field_cf36a81' => 'custom_field_11042', // start_date = field_eaccf07
      
        'field_e77050a' => 'custom_field_11040', // flyticket = field_42f1784
        'field_7bdced9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function hotels_thailand($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        //'email' => $raw_fields['field_6d3b03a']['value'] ?? 'no email field',
        'source' => $source, //  $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
      //  'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function hotels_bottom($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'],
        'source' => $source, // $raw_fields['source']['value'] = 
        'reset' => 'true'
    );
    $fldmap = array(
      
         'message' => 'custom_field_11044',
         'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
      //  'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function location_first($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], // '6776' - CM קוד סיאם טורס ב
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'],
        'source' => $source, // $raw_fields['source']['value'] = 
        'reset' => 'true'
    );
    $fldmap = array(

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
      //  'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}
function location_small($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], 
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'],
        'source' =>  $source, // $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
      //  'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function whether_page($token, $campaign, $raw_fields, $source){
    return honey_month($token, $campaign, $raw_fields, $source);
}

function contact_page($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], 
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_338b7fc']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'],
        'source' =>  $source, // $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'field_eaccf07' => 'custom_field_11042', // start_date = field_eaccf07
        'field_d62435a' => 'custom_field_11043', // end_date = field_d62435a
        'message' => 'custom_field_11044',
                'message' => 'note',
        'field_42f1784' => 'custom_field_11040', // flyticket = field_42f1784
        'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    
    return $arg;
}
function family_bottom($token, $campaign, $raw_fields, $source){
    return honey_month($token, $campaign, $raw_fields, $source);
}

function honey_month($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'], 
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_ea318f3']['value'],
        'email' => $raw_fields['field_6d3b03a']['value'],
        'source' =>  $source, // $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'message' => 'custom_field_11044',
                'message' => 'note',

        'field_e83c0fa' => 'custom_field_11040', // flyticket = field_42f1784
      //  'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function talk2us_homepage($token, $campaign, $raw_fields, $source){
    $arg = array(
        'token' => $token, //$raw_fields['token']['value'],
        'campaign' => $campaign, // $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['field_338b7fc']['value'],
        'email' => $raw_fields['email']['value'],
        'source' =>  $source, // $raw_fields['source']['value'] =
        'reset' => 'true'
    );
    $fldmap = array(
        'category' => 'custom_field_11039',
        'adults' => 'custom_field_11036',
        'children' => 'custom_field_11037',
        'field_eaccf07' => 'custom_field_11042', // start_date = field_eaccf07
        'field_d62435a' => 'custom_field_11043', // end_date = field_d62435a
        'message' => 'custom_field_11044',
                'message' => 'note',

        'field_42f1784' => 'custom_field_11040', // flyticket = field_42f1784
        'field_7a06bb9' => 'custom_field_7189' // passengers = field_7a06bb9
    );

    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);
    return $arg;
}

function nana_form($record, $handler, $raw_fields){
    
    $arg = array(
        'token' => $raw_fields['token']['value'], 
        'campaign' => $raw_fields['campaign']['value'], // '6776' - CM קוד סיאם טורס ב
                                                    // '9343' - Code Mulli for testing
        'name' => $raw_fields['name']['value'],
        'number' => $raw_fields['phone']['value'],
        'email' => $raw_fields['email']['value'],
        'source' => $raw_fields['source']['value']??'',
        'reset' => 'true',
        'international' => 'true'
    );
    $fldmap = array(
        'category' => 'custom_field_11039',
        //'adults' => 'custom_field_11036',
        //'children' => 'custom_field_11037',
        'start_date' => 'custom_field_11042',
        'end_date' => 'custom_field_11043',
        'message' => 'custom_field_11044',
        'message' => 'note',
        'flyticket' => 'custom_field_11040',
        'passengers' => 'custom_field_7189'
    );
    
    $arg = map_wp2cm_fields($fldmap, $raw_fields, $arg);

    if (empty($raw_fields['passengers']['value']) ) // fill up passengers if empty
            $arg['custom_field_7189'] = 'לא ידוע';
    if (!empty($raw_fields['countrycode']['value']) ){ // get country code value
            $v = str_replace('+', '', trim($raw_fields['countrycode']['value']));
            $arg['number'] = '+' . $v . $raw_fields['phone']['value'];
    }

    $url = $raw_fields['url']['value'];
    if (empty($url)){
        $ajax_handler->add_error_message( 'No URL provided - message not sent' );
        return;
    }
    $res = siam_cm_send_request($url, $arg);
    static $first;
    $count;
    if (!isset($first)){
            $first = 'done';
            $count =0;
    }
    if ($res['status'] == 'success'){
        if (isset($first)){
            $count += 1;
            $handler->add_response_data( 'nana_form', $count . ' : ' . $res['response']['body']);
        } else
            $handler->add_response_data( 'nana_form', $res['response']['body']);
    } else {
        error_log('handle_nana_form CM return FAIL = ' . print_r($res, true) . '  arg='. print_r($arg, true));
        $handler->add_response_data( 'nana_form', 'fail' );
    }
    error_log('handle_nana_form ' . print_r($res, true) . '  arg='. print_r($arg, true) . ' raw fields='. print_r($raw_fields, true));

    return ;     
}