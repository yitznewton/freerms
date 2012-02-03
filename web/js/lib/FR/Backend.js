FR.Backend = {
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

