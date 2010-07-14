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

function getSubform( type, index )
{
  var id_fragment = is_new ? '' : '&id=' + object_id;

  return $.ajax({
    type: 'GET',
    url: subform_url + '?type=' + type + id_fragment + '&index=' + index,
    async: false
  }).responseText;
}

$(document).ready(function(){
  $('#tab-container > ul').tabs();
  update_ip_reg_fields();

  $('#organization_ip_reg_method_id').change( function() {
    update_ip_reg_fields();
  });

  // TODO: need to bind to the new delete link
  // FIXME: the first new input should not have an accompanying add link
  $('#email-container .input-link-add').click( function() {
    var subform = getSubform('ContactEmail', email_count);
    $("#email-container").append( subform );
    email_count++;

    return false;
  });

  $('#phone-container .input-link-add').click( function() {
    var subform = getSubform('ContactPhone', phone_count);
    $("#phone-container").append( subform );
    phone_count++;

    return false;
  });
});
