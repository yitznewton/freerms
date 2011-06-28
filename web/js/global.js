var FR = {
  $$: function( id ) {
    return document.getElementById( id );
  },
  slugify: function( string ) {
    string = string.toLowerCase()
      .replace(/\W/g, ' ')
      .replace(/ +/g, '-')
      .replace(/^-|-$/g, '')
    
    return string;
  }
};
