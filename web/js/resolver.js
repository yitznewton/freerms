$ = jQuery;  // Nevada template steals the $ variable

var FRResolver = {
  refer: function( link, note ) {
    if ( ! link ) {
      return;
    }
    
    if ( note ) {
      // has referral note; should let the user see it
      return;
    }
    
    var link_instruction;
    
    if ( link_instruction = FR.$$('referral-link-instruction') ) {
      link_instruction.style.display = 'none';
    }
    
    if ( navigator.appName == "Microsoft Internet Explorer" ) {
      // hack to get IE to pass Referer URL
      link.click();
    }
    else {
      window.location = link.href;
    }
  }
};
>>>>>>> fe053e8e16f8d311dcb5ded5bef2fdf7e9bf9a65

$(document).ready( function() {
  FRResolver.refer( FR.$$('referral-link'), FR.$$('referral-note') );
  
  $('.description-full').hide();
  $('.description-short').show();
  
  $('a.show-more').click( function() {
    var $parent = $(this.parentNode);
    $parent.hide();
    $parent.siblings('.description-full').show();
    
    return false;
  });

  $('.form-subject :submit').hide();
  
  var select_subject;
  
  if ( select_subject = FR.$$('select-subject') ) {
    select_subject.onchange = function() {
      this.parentNode.submit();
    };
  }
});
