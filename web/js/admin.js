function FRSubjectSorter( id )
{
  this.ul           = document.createElement('ul');
  this.ul.id        = id;
  this.ul.className = 'sortable';
  this.items        = [];
}

FRSubjectSorter.prototype.add = function( title, weight_input_el ) {
  this.items.push({ title: title, weight_input_el: weight_input_el });
}

FRSubjectSorter.prototype.render = function() {
  var i;
  
  for ( i = 0; i < this.items.length; i++ ) {
    var li = document.createElement('li');

    li.className       = 'ui-state-default';
    li.innerHTML       = this.items[i].title;
    li.weight_input_el = this.items[i].weight_input_el;

    var span_arrow = document.createElement('span');
    span_arrow.className = 'ui-icon ui-icon-arrowthick-2-n-s';
    li.appendChild( span_arrow );

    this.ul.appendChild( li );
  }
}

FRSubjectSorter.prototype.bind = function() {
  var i;
  var li;
  
  for ( i = 0; i < this.ul.childNodes.length; i++ ) {
    if ( this.ul.childNodes[i].tagName != 'LI' ) {
      continue;
    }
    
    this.ul.childNodes[i].weight_input_el.value = -1;
  }
}

FRSubjectSorterFeatured.prototype = new FRSubjectSorter();

FRSubjectSorterFeatured.prototype.bind = function() {
  var i;
  var li;
  
  for ( i = 0; i < this.ul.childNodes.length; i++ ) {
    if ( this.ul.childNodes[i].tagName != 'LI' ) {
      continue;
    }
    
    this.ul.childNodes[i].weight_input_el.value = i;
  }
}

FRSubjectSorterFeatured.prototype.render = function() {
  this.sort();
  
  FRSubjectSorter.prototype.render.call( this );
}

FRSubjectSorterFeatured.prototype.sort = function() {
  this.items.sort( function(a, b) {
    return a.weight_input_el.value - b.weight_input_el.value;
  });
}

function FRSubjectSorterFeatured( id )
{
  FRSubjectSorter.prototype.constructor.call( this, id );
}

function freerms_admin_subject_sorter2( featured_sorter, nonfeatured_sorter )
{
  $('#admin-subject-databases tr').each( function() {
    var i;
    
    var $label = $('th label', this);
    
    if ( ! $label.length ) {
      throw new Error('Label not found');
    }

    var for_matches = $label.attr('for')
      .match(/db_subject_EResourceDbSubjectAssocs_(\d+)_featured_weight/);
      
    if ( ! for_matches ) {
      throw new Error('Could not match er_id');
    }
    
    var er_id = for_matches[1];
    
    var title_matches = $label.text().match(/Weight for (.+)/);
    
    if ( ! title_matches ) {
      throw new Error('Could not match title');
    }
    
    var title = title_matches[1];
    
    var weight_input_id = 'db_subject_EResourceDbSubjectAssocs_'
                          + er_id + '_featured_weight';
                        
    var weight_input_el = FR.$$( weight_input_id );
    
    if ( ! weight_input_el ) {
      throw new Error('Could not retrieve weight input for ' + er_id);
    }
    
    if ( weight_input_el.value == -1 ) {
      nonfeatured_sorter.add( title, weight_input_el );
    }
    else {
      featured_sorter.add( title, weight_input_el );
    }
  });
  
  featured_sorter.render();
  nonfeatured_sorter.render();
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
  
  var nonfeatured_sorter = new FRSubjectSorter( 'databases-nonfeatured' );
  var featured_sorter = new FRSubjectSorterFeatured( 'databases-featured' );
  
  freerms_admin_subject_sorter2( featured_sorter, nonfeatured_sorter );
  
  $('#admin-subject-databases').append( featured_sorter.ul )
                               .append( nonfeatured_sorter.ul )
                               .find('table').hide()
                               ;

  $(featured_sorter.ul).sortable({
    connectWith: ['#databases-nonfeatured'],
    placeholder: 'ui-state-highlight'
  });
  
  $(nonfeatured_sorter.ul).sortable({
    connectWith: ['#databases-featured'],
    placeholder: 'ui-state-highlight'
  });
  
  $('#admin-form-subject').submit( function() {
    featured_sorter.bind();
    nonfeatured_sorter.bind();
  });

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
