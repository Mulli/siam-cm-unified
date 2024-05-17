// display the response from CM to client (e.g. admin) after submitting request to CM
// this si in addition to the response from WP that from submitted successfuly
jQuery(function($) {
  $( document ).on('submit_success', function(e, data) {
      console.log(data);
      //alert('submit submit_success: '+ data.data.app_tests)
      $('#cm-fail').remove();
      if (data.data.siam_cm_response !== undefined)
        $(e.target).append('<p id="cm-response" >'+ data.data.siam_cm_response +'</p>');
  });
});