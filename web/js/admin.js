function freerms_admin_subject_sorter()
{
  var subjects  = document.getElementById('subjects');
  var $subjects = $(subjects);

  $subjects.children().hide();

  var ul_featured = document.createElement('ul');
  ul_featured.id = 'subjects-featured';
  ul_featured.className = 'sortable';

  var ul_nonfeatured = document.createElement('ul');
  ul_nonfeatured.id = 'subjects-nonfeatured';
  ul_nonfeatured.className = 'sortable';

  var ul_disabled = document.createElement('ul');
  ul_disabled.id = 'subjects-disabled';
  ul_disabled.className = 'sortable';

  var weighted_subjects = [];

  $('ul.checkbox_list input', subjects).each( function() {
    var subject_id;
    var id_matches = this.id.match(/_(\d+)$/);

    var weight = -1;

    if ( id_matches ) {
      subject_id = id_matches[1];
    }
    else {
      throw 'Unexpected lack of subject id';
    }

    var li = document.createElement('li');
    li.id = 'subject-list-' + subject_id;
    li.className = 'ui-state-default';
    li.innerHTML = $(this).siblings('label').text();

    var span_arrow = document.createElement('span');
    span_arrow.className = 'ui-icon ui-icon-arrowthick-2-n-s';

    li.appendChild( span_arrow );

    var weight_id = 'e_resource_EResourceDbSubjectAssocs_'
                    + subject_id + '_featured_weight';

    var weight_el = document.getElementById( weight_id );

    if ( weight_el && weight_el.value != -1 ) {
      weight = weight_el.value;
      weighted_subjects.push([ li, weight ]);
    }
    else if ( this.checked ) {
      ul_nonfeatured.appendChild( li );
    }
    else {
      ul_disabled.appendChild( li );
    }
  });

  weighted_subjects.sort( function(a,b){ return a[1] - b[1] } );

  for ( var i = 0; i < weighted_subjects.length; i++ ) {
    ul_featured.appendChild( weighted_subjects[i][0] );
  }

  $('ul.checkbox_list', subjects).remove();

  $subjects.append( '<h3>Featured</h3>' );
  subjects.appendChild( ul_featured );
  $subjects.append( '<h3>Non-featured</h3>' );
  subjects.appendChild( ul_nonfeatured );
  $subjects.append( '<h3>Disabled</h3>' );
  subjects.appendChild( ul_disabled );

  $(ul_featured).sortable({
    connectWith: ['#subjects-nonfeatured', '#subjects-disabled'],
    placeholder: 'ui-state-highlight'
  });

  $(ul_nonfeatured).sortable({
    connectWith: ['#subjects-featured', '#subjects-disabled'],
    placeholder: 'ui-state-highlight'
  });

  $(ul_disabled).sortable({
    connectWith: ['#subjects-featured', '#subjects-nonfeatured'],
    placeholder: 'ui-state-highlight'
  });

  document.getElementById('admin-form-database').onsubmit = function() {
    var er_id  = document.getElementById('e_resource_id').value;
    var that   = this;

    var weight = 0;

    $('li', ul_featured).each( function() {
      var subject_id_matches = this.id.match(/-(\d+)$/);

      if ( ! subject_id_matches ) {
        throw 'Unexpected value: id';
      }

      var subject_id = subject_id_matches[1];

      freerms_admin_subject_inputs( that, er_id, subject_id, weight++ );
    });

    $('li', ul_nonfeatured).each( function() {
      var subject_id_matches = this.id.match(/-(\d+)$/);

      if ( ! subject_id_matches ) {
        throw 'Unexpected value: id';
      }

      var subject_id = subject_id_matches[1];

      freerms_admin_subject_inputs( that, er_id, subject_id, -1 );
    });

    return true;
  }
}

function freerms_admin_subject_inputs( form, er_id, subject_id, weight )
{
  if ( typeof weight == 'undefined' ) {
    weight = '-1';
  }

  var el_input;

  el_input       = document.createElement('input');
  el_input.type  = 'hidden';
  el_input.name  = 'e_resource[e_resource_db_subject_assoc_list][]';
  el_input.value = subject_id;

  form.appendChild( el_input );

  el_input       = document.createElement('input');
  el_input.type  = 'hidden';
  el_input.name  = 'e_resource[EResourceDbSubjectAssocs]['
                   + subject_id + '][featured_weight]';
  el_input.value = weight;

  form.appendChild( el_input );

  el_input       = document.createElement('input');
  el_input.type  = 'hidden';
  el_input.name  = 'e_resource[EResourceDbSubjectAssocs]['
                   + subject_id + '][er_id]';
  el_input.value = er_id;

  form.appendChild( el_input );

  el_input       = document.createElement('input');
  el_input.type  = 'hidden';
  el_input.name  = 'e_resource[EResourceDbSubjectAssocs]['
                   + subject_id + '][db_subject_id]';
  el_input.value = subject_id;

  form.appendChild( el_input );
}

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
  freerms_admin_subject_sorter();

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
