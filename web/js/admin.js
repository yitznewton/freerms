var FRAdmin = {
  rootUrl: function() {
    var url_matches = window.location.href.match(/^.+admin[^\.]*\.php/);
    
    if ( url_matches ) {
      return url_matches[0];
    }
    else {
      throw new Error( 'Could not parse URL' );
    }
  }
};

function FREResourceSorterRow( title, weight_input_el )
{
  this.ajaxOnRemove;
  this.erId;
  this.title;
  this.weightInputEl;
  
  this.title = title;
  this.weightInputEl = weight_input_el;
}

FREResourceSorterRow.prototype.getErId = function() {
  return this.erId;
}

FREResourceSorterRow.prototype.getWeight = function() {
  if ( this.weightInputEl ) {
    return this.weightInputEl.value;
  }
  else {
    throw new Error( 'Weight input not found' );
  }
}

FREResourceSorterRow.prototype.bind = function( index ) {
  this.weightInputEl.value = index;
}

FREResourceSorterRow.prototype.render = function() {
  var li   = document.createElement('li');

  li.className  = 'ui-state-default';
  li.innerHTML  = this.title;
  li.sorter_row = this;  // needed for binding

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
  }( span_close, li, this )

  li.appendChild( span_close );
  
  return li;
}

FREResourceSorterRow.prototype.setAjaxOnRemove = function( url ) {
  this.ajaxOnRemove = url;
}

FREResourceSorterRow.prototype.remove = function() {
  if ( this.ajaxOnRemove ) {
    $.ajax( FRAdmin.rootUrl() + this.ajaxOnRemove );
  }
          
  this.weightInputEl.parentNode.removeChild( this.weightInputEl );
}

FREResourceSorterRow.fromTR = function( tr, prefix ) {
  var $label = $('th label', tr);

  if ( ! $label.length ) {
    throw new Error( 'Label not found' );
  }

  var title_matches = $label.text().match(/Weight for (.+)/);

  if ( ! title_matches ) {
    throw new Error( 'Could not match title' );
  }

  var title = title_matches[1];
  
  var for_matches = $label.attr('for').match(/(\d+)_featured_weight/);

  if ( ! for_matches ) {
    throw new Error( 'Could not match er_id' );
  }

  var er_id = for_matches[1];

  var weight_input_id = prefix + '_' + er_id + '_featured_weight';
  
  var weight_input = FR.$$( weight_input_id );
  
  if ( ! weight_input ) {
    throw new Error( 'Could not retrieve weight input element' );
  }
  
  var obj  = new FREResourceSorterRow( title, weight_input );
  obj.erId = er_id;
  
  return obj;
}
  
function FREResourceSorter( id )
{
  this.id;
  this.ul;
  this.connections  = [];
  this.isWeighted   = true;
  this.isRendered   = false;
  this.rows         = [];
  this.rowsToRender = [];

  this.id = id;
  this.init();
}

FREResourceSorter.prototype.addRow = function( row ) {
  this.rows.push( row );
  
  if ( this.isRendered ) {
    this.ul.appendChild( row.render() );
  }
  else {
    this.rowsToRender.push( row );
  }
}

FREResourceSorter.prototype.init = function() {
  this.ul           = document.createElement('ul');
  this.ul.id        = this.id;
  this.ul.className = 'sortable';
}

FREResourceSorter.prototype.render = function() {
  if ( this.isRendered ) {
    throw new Error( 'Already rendered' );
  }
  
  if ( this.isWeighted ) {
    this.sortByWeight();
  }
  
  for ( var i = 0; i < this.rowsToRender.length; i++ ) {
    this.ul.appendChild( this.rowsToRender[i].render() );
  }
  
  this.isRendered   = true;
  this.rowsToRender = [];
  
  var $this_ul = $(this.ul);
  
  var sortable_options = {placeholder: 'ui-state-highlight'};
  
  if ( this.connections ) {
    sortable_options.connectWith = this.connections;
  }
  
  $this_ul.sortable( sortable_options );
  
  return $this_ul;
}

FREResourceSorter.prototype.setConnections = function( connections ) {
  this.connections = connections;
}

FREResourceSorter.prototype.setWeighted = function( value ) {
  this.isWeighted = value;
}

FREResourceSorter.prototype.bind = function() {
  for ( var i = 0; i < this.ul.childNodes.length; i++ ) {
    if ( this.ul.childNodes[i].tagName != 'LI' ) {
      continue;
    }
    
    var li = this.ul.childNodes[i];
    
    this.isWeighted ? li.sorter_row.bind( i ) : li.sorter_row.bind( -1 );
  }
}

FREResourceSorter.prototype.sortByWeight = function() {
  this.rowsToRender.sort( function(a, b) {
    return a.getWeight() - b.getWeight();
  });
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
    var nonfeatured_sorter = new FREResourceSorter( 'databases-nonfeatured' );
    var featured_sorter = new FREResourceSorter( 'databases-featured' );
    
    nonfeatured_sorter.setWeighted( false );
    
    var subject_id = FR.$$('db_subject_id').value;
    
    $('#admin-subject-databases tr').each( function() {
      var row = FREResourceSorterRow.fromTR(
        this, 'db_subject_EResourceDbSubjectAssocs' );

      var url = '/subject/ajax/remove/er_id/' + row.getErId()
                + '/subject_id/' + subject_id;

      row.setAjaxOnRemove( url );

      if ( row.getWeight() == -1 ) {
        nonfeatured_sorter.addRow( row );
      }
      else {
        featured_sorter.addRow( row );
      }
    });
    
    nonfeatured_sorter.setConnections( ['#databases-featured'] );
    featured_sorter.setConnections( ['#databases-nonfeatured'] );
    
//    var $ajax_input = $('<input type="text" class="admin-ajax-search" value="Add">');
//    
//    $ajax_input.focus( function() {
//      this.value = '';
//    }).autocomplete( FRAdmin.rootUrl() + '/database/ajax/search', {
//      
//    });
    
    var $subject_container = $('#admin-subject-databases');
    
    $subject_container
      .append( $('<h3>Featured databases</h3>') )
      .append( featured_sorter.render() )
      .append( $('<h3>Non-featured databases</h3>') )
      .append( nonfeatured_sorter.render() )
      //.append( $ajax_input )
      ;

    $('table', $subject_container).hide();

    FR.$$('admin-form-subject').onsubmit = function() {
      featured_sorter.bind();
      nonfeatured_sorter.bind();
    };
  }
  
  if ( FR.$$('admin-featured-databases') ) {
    var sorter = new FREResourceSorter( 'home-featured-databases' );

    $('#admin-featured-databases tr tr').each( function() {
      var row = FREResourceSorterRow.fromTR( this, 'EResources' );
      row.setAjaxOnRemove( '/database/ajax/unfeature/id/' + row.getErId() );
      sorter.addRow( row );
    });
    
    var $subject_container = $('#admin-featured-databases');
    
    sorter.render().appendTo( $subject_container );

    $('table', $subject_container).hide();

    FR.$$('admin-form-featured').onsubmit = function() {
      sorter.bind();
    };
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
