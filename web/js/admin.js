function clearAll( select_el )
{
  select_el.find('option:selected').attr('selected', false); 
}

function updateIpRegFields()
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
  admin_tabset = $('#tab-container > ul').tabs();
  admin_tabs = $('#tab-container .ui-tabs-panel');

  for ( i = 0 ; i < admin_tabs.length ; i++ ) {
    if ( $(admin_tabs.get(i)).find('.ui-state-error').length ) {
      // an error is displayed in this tab
      admin_tabset.tabs( 'select', i );
      break;
    }
  }

  updateIpRegFields();

  $('#organization_ip_reg_method_id').change( function() {
    updateIpRegFields();
  });

  $('#email-container .input-link-add').click( function() {
    var subform = getSubform('ContactEmail', email_count);
    var new_input_id = $(':text', subform).get(0).id;

    $("#email-container").append( subform );

    // jQuery can't seem to keep track of the new div once it's appended
    subform = $('#'+new_input_id).parent();
    
    subform.find('.input-link-delete').click( function() {
      subform.remove();
    });

    email_count++;

    return false;
  });

  $('#phone-container .input-link-add').click( function() {
    var subform = getSubform('ContactPhone', phone_count);
    var new_input_id = $(':text', subform).get(0).id;

    $("#phone-container").append( subform );

    // jQuery can't seem to keep track of the new div once it's appended
    subform = $('#'+new_input_id).parent();

    subform.find('.input-link-delete').click( function() {
      subform.remove();
    });

    phone_count++;

    return false;
  });

  $('.input-link-delete').click( function() {
    return window.confirm('Are you sure? Make sure other changes are saved first!');
  });
});
