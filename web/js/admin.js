function clearAll( select_el )
{
  select_el.find('option:selected').attr('selected', false); 
}

function update_ip_reg_fields()
{
  var selected = $('#organization_ip_reg_method_id')
                 .find('option:selected').text();

  switch ( selected ) {
    case '':
      // hide all
      $('fieldset.organization-ip-notification').hide();
      break;

    case 'web admin':
    case 'web contact form':
      $('fieldset.organization-ip-notification').hide();
      $('#organization-ip-notification-web').show();
      break;

    case 'email':
    case 'phone':
      $('fieldset.organization-ip-notification').hide();
      $('#organization-ip-notification-contact').show();
      break;

    default:
      // show all
      $('fieldset.organization-ip-notification').show();
  }
}

$(document).ready(function(){
  $('#tab-container > ul').tabs();
  update_ip_reg_fields();

  $('#organization_ip_reg_method_id').change( function() {
    update_ip_reg_fields();
  });
});
