$(document).ready( function() {
  $('.description-full').hide();
  $('.description-short').show();
  
  $('a.show-more').click( function() {
    var $parent = $(this.parentNode);
    $parent.hide();
    $parent.siblings('.description-full').show();
    
    return false;
  });
  
  $('.description-link').click( function(){
    $(this).parent().siblings( '.database-description-full' ).show();
    $(this).parent().hide();

    return false;
  });
});

