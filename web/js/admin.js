function clearAll( select_el )
{
  select_el.find('option:selected').attr('selected', false); 
}

function update_ip_reg_fields()
{
  var selected = $('#organization_ip_reg_method_id')
                 .find('option:selected').text();

  switch ( selected ) {
    case 'web admin':
    case 'web contact form':
      $('#organization-ip-notification-contact').hide();
      break;

    case 'auto email':
    case 'manual email':
    case 'phone':
      $('#organization-ip-notification-contact').show();
      break;

    default:
      // show all
      $('#organization-ip-notification-contact').show();
  }
}

$(document).ready(function(){
  $('#tab-container > ul').tabs();
  update_ip_reg_fields();

  $('#organization_ip_reg_method_id').change( function() {
    update_ip_reg_fields();
  });
});
