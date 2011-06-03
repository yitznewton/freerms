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

  FR.$$('db-subject-select').onchange = function() {
    var url = window.location.protocol + '//'
            + window.location.host
            + window.location.pathname + '?subject=' + this.value;
          
    window.location.href = url;
  };
});

