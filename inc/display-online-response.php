<?php

// handle CallMarker response and display it on screen online for nana form & app tests
// Called by admin forms and app tests
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
// make sure response tag 'siam_cm_response' is in sync with JS and displayed on screen
// using elementor form response
function siam_response_message($handler, $str){
    return $handler->add_response_data( 'siam_cm_response', $str);   
}