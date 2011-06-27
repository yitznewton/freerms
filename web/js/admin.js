function FRSubjectRow( tr, prefix )
{
  this.er_id;
  this.title;
  this.sorter;
  this.ajax_on_remove;
  
  this.tr     = tr;
  this.prefix = prefix;
  
  var $label = $('th label', tr);

  if ( ! $label.length ) {
    throw new Error('Label not found');
  }

  var for_matches = $label.attr('for').match(/(\d+)_featured_weight/);

  if ( ! for_matches ) {
    throw new Error('Could not match er_id');
  }

  this.er_id = for_matches[1];

  var title_matches = $label.text().match(/Weight for (.+)/);

  if ( ! title_matches ) {
    throw new Error('Could not match title');
  }

  this.title = title_matches[1];
  
  this.init();
}

FRSubjectRow.prototype.isFeatured = function() {
  var weight_input_el = this._getWeightInputEl();

  if ( ! weight_input_el ) {
    throw new Error('Could not retrieve weight input for ' + er_id);
  }
    
  return ( weight_input_el.value != -1 );
}

FRSubjectRow.prototype.setSorter = function( sorter ) {
  this.sorter = sorter;
}

FRSubjectRow.prototype.setAjaxOnRemove = function( url ) {
  this.ajax_on_remove = url;
}

FRSubjectRow.prototype._getWeightInputEl = function() {
  var weight_input_id = this.prefix + '_' + this.er_id + '_featured_weight';

  return FR.$$( weight_input_id );
}

FRSubjectRow.prototype.init = function() {
  this.weight_input_el = this._getWeightInputEl();
}

FRSubjectRow.prototype.remove = function() {
  if ( this.ajax_on_remove ) {
    $.ajax( this.ajax_on_remove );
  }
          
  this.weight_input_el.parentNode.removeChild( this.weight_input_el );
}
  
function FRSubjectSorter( id )
{
  this.ul           = document.createElement('ul');
  this.ul.id        = id;
  this.ul.className = 'sortable';
  this.items        = [];
  this.connections  = [];
}

FRSubjectSorter.prototype.add = function( item ) {
  this.items.push( item );
}

FRSubjectSorter.prototype.getSubjectId = function() {
  return this.subject_id;
}

FRSubjectSorter.prototype.render = function() {
  var i;
  
  for ( i = 0; i < this.items.length; i++ ) {
    var li   = document.createElement('li');
    var row  = this.items[i];

    li.className       = 'ui-state-default';
    li.innerHTML       = row.title;
    li.weight_input_el = row.weight_input_el;

    var span_arrow = document.createElement('span');
    span_arrow.className = 'ui-icon ui-icon-arrowthick-2-n-s';
    li.appendChild( span_arrow );
    
    var span_close = document.createElement('span');
    span_close.className = 'ui-icon ui-icon-close';
    
    span_close.onclick = function( s, li, row ) {
      return function() {
        row.remove();
        
        $(li).fadeOut( 400, function() {
          this.parentNode.removeChild( this );
        });
      }
    }(span_close, li, row)
    
    li.appendChild( span_close );

    this.ul.appendChild( li );
  }
  
  var $this_ul = $(this.ul);
  
  $this_ul.sortable({
    connectWith: this.connections,
    placeholder: 'ui-state-highlight'
  });
  
  return $this_ul;
}

FRSubjectSorter.prototype.setConnections = function( connections ) {
  this.connections = connections;
}

FRSubjectSorter.prototype.bind = function() {
  var i;
  var li;
  
  for ( i = 0; i < this.ul.childNodes.length; i++ ) {
    if ( this.ul.childNodes[i].tagName != 'LI' ) {
      continue;
    }
    
    var value_to_bind = (this instanceof FRSubjectSorterFeatured) ? i : -1;
    
    this.ul.childNodes[i].weight_input_el.value = value_to_bind;
  }
}

FRSubjectSorterFeatured.prototype = new FRSubjectSorter();

FRSubjectSorterFeatured.prototype.render = function() {
  this.sort();
  
  return FRSubjectSorter.prototype.render.call( this );
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
  
  if ( FR.$$('admin-subject-databases') ) {
    var nonfeatured_sorter = new FRSubjectSorter( 'databases-nonfeatured' );
    var featured_sorter = new FRSubjectSorterFeatured( 'databases-featured' );
    
    var subject_id = FR.$$('db_subject_id').value;
    
    $('#admin-subject-databases tr').each( function() {
      var row = new FRSubjectRow( this, 'db_subject_EResourceDbSubjectAssocs' );

      // FIXME: get base url from PHP
      var admin_root = '/admin_dev.php';  //FIXME get from PHP
      var url = '/subject/ajax/remove/er_id/' + row.er_id + '/subject_id/'
                + subject_id;
      row.setAjaxOnRemove( admin_root + url );

      if ( row.isFeatured() ) {
        row.setSorter( featured_sorter );
        featured_sorter.add( row );
      }
      else {
        row.setSorter( nonfeatured_sorter );
        nonfeatured_sorter.add( row );
      }
    });
    
    nonfeatured_sorter.setConnections( ['#databases-featured'] );
    featured_sorter.setConnections( ['#databases-nonfeatured'] );
    
    var $subject_container = $('#admin-subject-databases');
    
    featured_sorter.render().appendTo( $subject_container );
    nonfeatured_sorter.render().appendTo( $subject_container );

    $('table', $subject_container).hide();

    $('#admin-form-subject').submit( function() {
      featured_sorter.bind();
      nonfeatured_sorter.bind();
    });
  }
  
  if ( FR.$$('admin-featured-databases') ) {
    var sorter = new FRSubjectSorterFeatured( 'home-featured-databases' );

    $('#admin-featured-databases tr tr').each( function() {
      var row = new FRSubjectRow( this, 'EResources' );
      
      // FIXME: admin root
      var url = '/admin.php/database/ajax/unfeature/id/' + row.er_id;
      
      row.setAjaxOnRemove( url );
      
      sorter.add( row );
    });
    
    var $subject_container = $('#admin-featured-databases');
    
    sorter.render().appendTo( $subject_container );

    $('table', $subject_container).hide();

    $('#admin-form-featured').submit( function() {
      sorter.bind();
    });
  }

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
  
  // db_subject auto-slugger
  var subject_label = FR.$$('db_subject_label');
  var subject_slug  = FR.$$('db_subject_slug');
  
  if ( subject_label && subject_slug ) {
    var subject_label_init_value;
    
    subject_label.onfocus = function() {
      subject_label_init_value = this.value;
    }
    
    subject_label.onblur = function() {
      if ( this.value != subject_label_init_value ) {
        subject_slug.value = FR.slugify( this.value );
      }
    }
  }

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
