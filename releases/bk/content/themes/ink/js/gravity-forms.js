// code to trigger on AJAX form render
jQuery(document).on('gform_post_render', function() {
  if (jQuery('#gforms_confirmation_message').length) {
    emptyCart();
    outputCart();
  }
});
