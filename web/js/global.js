var FR = {
  firstLastExtension: {
    first: function() {
      return this;
    },
    last: function() {
    }
  },
  $$: function(id) {
    return document.getElementById( id );
  },
  slugify: function(string) {
    string = string.toLowerCase()
      .replace(/\W/g, ' ')
      .replace(/ +/g, '-')
      .replace(/^-|-$/g, '')
    
    return string;
  },
  trim: function(v) {
    return v.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
  }
};
