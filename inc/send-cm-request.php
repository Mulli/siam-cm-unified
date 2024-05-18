<?php

function siam_cm_send_request($url, $arg, $online_response=''){
    if (empty($url)){
        $ajax_handler->add_error_message( 'No URL provided - message not sent' );
        return;
    }
    $response = wp_remote_post( $url, array(
        'method'      => 'POST',
        'timeout'     => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'body'        => $arg,
        'cookies'     => array()
        )
    );
    
    if ( is_wp_error( $response ) ) {
        $error_message = $response->get_error_message();
        error_log('WP fail send status= '. print_r($response, true));
        return ['status' => 'fail', 'message' => "Something went wrong: $error_message"];
    }
    if ($response['body'] != 'Customer has been added successfully') {// send email to yossi
        error_log('CM DENIED status= '. print_r($response, true));
        siam_send_mail($response['body']); // return ['status' => 'success', 'response' => $response];
        return ['status' => 'fail', 'message' => "סירוב קול מרקר: ". $response['body']];
    }
    if ($online_response == 'online-response')
        return ['status' => 'success', 'message' => "מעולה! ליד חדש בקול מרקר"];
    return; // ignore response for most cases
}
// map wordpress key to call marker expected key
function map_wp2cm_fields($fldmap, $fields, $arg){
    foreach ($fldmap as $wp_key => $cm_key){
        if (isset($fields[$wp_key]) && !empty($fields[$wp_key])){
            $arg[$cm_key] = $fields[$wp_key];
        }
    }
    return $arg;
}
