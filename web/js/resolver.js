$ = jQuery;  // Nevada template steals the $ variable

$(document).ready( function() {
  $('.description-full').hide();
  $('.description-short').show();
  
  $('a.show-more').click( function() {
    var $parent = $(this.parentNode);
    $parent.hide();
    $parent.siblings('.description-full').show();
    
    return false;
  });

  $('.form-subject :submit').hide();
  
  FR.$$('select-subject').onchange = function() {
    this.parentNode.submit();
  };
});

