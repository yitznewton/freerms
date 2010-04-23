$(document).ready( function() {
  $('.description-link').click( function(){
    $(this).parent().siblings( '.database-description-full' ).show();
    $(this).parent().hide();

    return false;
  });
});

