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

function siam_send_mail($response){
    $to = 'mulli@site2goal.co.il';
    $l_id = siam_get_submission_id();
    $subject = "Lead #$l_id not added to CM: " . $response;
    
    //$headers = "MIME-Version: 1.0" . "\r\n";
    //$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers = array(
                    "From: info@st.siam.w2go.co.il",
                    "Reply-To: mulli@site2goal.co.il",
            //        "CC: yossi@siam-tours.com",
            //        "Bcc: yossi@siam-tours.com",
                );
    $message = 'Details: ' . print_r($response, true);

    // Send the email
    $sent = wp_mail( $to, $subject, $message, $headers );

    if( !$sent ) 
        error_log( 'siam_send_mail There was an error sending the email.'. print_r($response, true));
    return;
}
/*
function run( $record, $ajax_handler ) {
     global $wpdb;
     $table_name = $wpdb->prefix . 'e_submissions_values';
     $ID = $wpdb->get_var($wpdb->prepare("SELECT submission_id FROM $table_name ORDER BY submission_id DESC"));
     wp_mail('mail@example.com', 'Your Submission: ' . $ID, 'Example Message', 'headers');
     return;
}*/

// Register a function to run on the init hook
add_action( 'init', 'register_get_submission_id_shortcode' );

function register_get_submission_id_shortcode() {
    // Register the get submission id shortcode
    add_shortcode( 'get_submission_id', 'siam_get_submission_id' );
}

function siam_get_submission_id() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'e_submissions';

    // Get the highest value from the database table
    $sql = "SELECT MAX(ID) as max_id FROM $table_name;";
    $result = $wpdb->get_var( $sql );

    // Add 1 to the highest value and return it
    if ( $result )
        return  $result;

    return 'No results found';
}