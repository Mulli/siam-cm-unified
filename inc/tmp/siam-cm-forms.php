<?php

// handle elementor form to send data to CallMarker
// 1. Get fields from form submission
// 2. send only non empty fields to CallMarker
// 3. get reply & display it on screen using elementor form response
// and JS code on page

function handle_siam_cm_forms( $record, $handler ) {

	$form_name = $record->get_form_settings( 'form_name' );
    $raw_fields = $record->get( 'fields' );

    if ( 'mullitest' == $form_name ){
    
        $handler->add_response_data( 'mullitest', 'not operating yet, no message sent to CM' );
        return;
    }

    if ( 'nana form' == $form_name ){
        $arg = array(
            'token' => $raw_fields['token']['value'], // '6776' - CM ט - קוד סיאם טורס ב
            'campaign' => $raw_fields['campaign']['value'], // '6776' - CM ט - קוד סיאם טורס ב
                                                        // '9343' - Code Mulli for testing
            'name' => $raw_fields['name']['value'],
            'number' => $raw_fields['phone']['value'],
            'email' => $raw_fields['email']['value'],
            'source' => $raw_fields['source']['value']??'',
            'reset' => 'true'
        );
        $fldmap = array(
            'category' => 'custom_field_11039',
            'adults' => 'custom_field_11036',
            'children' => 'custom_field_11037',
            'start_date' => 'custom_field_11042',
            'end_date' => 'custom_field_11043',
            'message' => 'custom_field_11044',
            'flyticket' => 'custom_field_11040',
            'passengers' => 'custom_field_7189'
        );
        
        foreach ($fldmap as $key => $value){
            if (isset($raw_fields[$key]['value']) && !empty($raw_fields[$key]['value'])){
                $arg[$value] = $raw_fields[$key]['value'];
            }
        }
        $url = $raw_fields['url']['value'];
        if (empty($url)){
            $ajax_handler->add_error_message( 'No URL provided - message not sent' );
            return;
        }
        $res = siam_cm_send_request($url, $arg);
        if ($res['status'] == 'success'){
            $handler->add_response_data( 'nana_form', $res['response']['body']);
        } else {
            $handler->add_response_data( 'nana_form', 'fail' );
        }
        error_log('handle_nana_form ' . print_r($res, true));
    }
    return ;     
}



/* How to return to form page more complex data AFTER form submission & Webhook activation
    add_action( 'elementor_pro/forms/new_record', function( $record, $ajax_handler ) {
	// USUAL staff...
    // run webhook
    // THIS IS THE NEW STAFF
	$ajax_handler->data['output'] = 'INFORM_02 Output is: ' . $fields['email_field_id'];
});

// YOU MUST HAVE JS CODE ON PAGE TO DISPLAY THE OUTPUT
// THIS IS THE JS CODE
<script>
	//The event is submit_success so you can catch it for example:
	jQuery( document ).ready(function( $ ){
		$( document ).on('submit_success', function( event, response ){
			if ( response.data.output ) {
				alert( response.data.output  );
			}
            $(this).append('<div class="elementor-message elementor-message-success" role="alert"><p>Thank you for your message. It has been sent.</p></div>');
		});
	});
</script>
    */