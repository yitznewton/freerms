(function( $ ){
  $.fn.appendSubjectInputs = function( er_id, subject_id, weight ) {
    if ( this[0].tagName != 'FORM' ) {
      throw 'Can only call appendSubjectInputs() on a form element';
    }

    if ( typeof weight == 'undefined' ) {
      weight = '-1';
    }

    var el_input;

    el_input       = document.createElement('input');
    el_input.type  = 'hidden';
    el_input.name  = 'db_subject[EResourceDbSubjectAssocs]['
                     + er_id + '][featured_weight]';
    el_input.value = weight;

    this.append( el_input );

    el_input       = document.createElement('input');
    el_input.type  = 'hidden';
    el_input.name  = 'db_subject[EResourceDbSubjectAssocs]['
                     + er_id + '][er_id]';
    el_input.value = er_id;

    this.append( el_input );

    el_input       = document.createElement('input');
    el_input.type  = 'hidden';
    el_input.name  = 'db_subject[EResourceDbSubjectAssocs]['
                     + subject_id + '][db_subject_id]';
    el_input.value = subject_id;

    this.append( el_input );
  };
})( jQuery );

function freerms_admin_subject_sorter()
{
  var databases  = document.getElementById('admin-subject-databases');

  if ( databases === null ) {
    return;
  }

  var $databases = $(databases);
  var $old_form_elements = $('table', databases);
  $old_form_elements.hide();

  var ul_featured = document.createElement('ul');
  ul_featured.id = 'databases-featured';
  ul_featured.className = 'sortable';

  var ul_nonfeatured = document.createElement('ul');
  ul_nonfeatured.id = 'databases-nonfeatured';
  ul_nonfeatured.className = 'sortable';

  var weighted_databases = [];

  $('tr', databases).each( function() {
    var database_id;

    $('input', this).each( function() {
      var database_id_ptn = /db_subject_EResourceDbSubjectAssocs_(\d+)_er_id/;
      var database_id_matches = this.id.match( database_id_ptn );

      if ( database_id_matches ) {
        database_id = database_id_matches[1];
        return false;  // break
      }
    });

    if ( database_id === null ) {
      throw 'Unexpected lack of database id';
    }

    var weight = -1;

    var label_matches = $('label', this).text().match(/Weight for (.+)$/);

    if ( label_matches === null ) {
      throw 'Could not find label for database ' + database_id;
    }

    var li = document.createElement('li');
    li.id = 'database-list-' + database_id;
    li.className = 'ui-state-default';
    li.innerHTML = label_matches[1];

    var url_replace = 'database/'+database_id+'/edit#subjects';
    var target_url = window.location.pathname
                     .replace(/subject.+$/, url_replace);

    li.onclick = function() {
      window.open( target_url );
    }

    var span_arrow = document.createElement('span');
    span_arrow.className = 'ui-icon ui-icon-arrowthick-2-n-s';

    li.appendChild( span_arrow );

    var weight_id = 'db_subject_EResourceDbSubjectAssocs_'
                    + database_id + '_featured_weight';

    var weight_el = document.getElementById( weight_id );

    if ( weight_el && weight_el.value != -1 ) {
      weight = weight_el.value;
      weighted_databases.push([ li, weight ]);
    }
    else {
      ul_nonfeatured.appendChild( li );
    }
  });

  weighted_databases.sort( function(a,b){return a[1] - b[1]} );

  for ( var i = 0; i < weighted_databases.length; i++ ) {
    ul_featured.appendChild( weighted_databases[i][0] );
  }

  $databases.append( '<h3>Featured</h3>' );
  databases.appendChild( ul_featured );
  $databases.append( '<h3>Non-featured</h3>' );
  databases.appendChild( ul_nonfeatured );

  $(ul_featured).sortable({
    connectWith: ['#databases-nonfeatured'],
    placeholder: 'ui-state-highlight'
  });

  $(ul_nonfeatured).sortable({
    connectWith: ['#databases-featured'],
    placeholder: 'ui-state-highlight'
  });

  $old_form_elements.remove();

  document.getElementById('admin-form-subject').onsubmit = function() {
    var subject_id  = document.getElementById('db_subject_id').value;
    var that   = this;
    var $this = $(this);

    var weight = 0;

    $('li', ul_featured).each( function() {
      var er_id_matches = this.id.match(/-(\d+)$/);

      if ( ! er_id_matches ) {
        throw 'Unexpected value: id';
      }

      var er_id = er_id_matches[1];

      $this.appendSubjectInputs( er_id, subject_id, weight++ );
    });

    $('li', ul_nonfeatured).each( function() {
      var er_id_matches = this.id.match(/-(\d+)$/);

      if ( ! er_id_matches ) {
        throw 'Unexpected value: id';
      }

      var er_id = er_id_matches[1];

      $this.appendSubjectInputs( er_id, subject_id, -1 );
    });

    return true;
  }
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
  var admin_tabset = $('#tab-container > ul').tabs({
    cookie: {}
  });

  var admin_tabs = $('#tab-container .ui-tabs-panel');

  for ( var i = 0 ; i < admin_tabs.length ; i++ ) {
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
    var subform = $('#'+new_input_id).parent();
    
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
    var subform = $('#'+new_input_id).parent();

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
