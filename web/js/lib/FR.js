var FR = FR || {};

FR.$$ = function(id) {
  return document.getElementById( id );
};

FR.slugify = function(string) {
  string = string.toLowerCase()
    .replace(/\W/g, ' ')
    .replace(/ +/g, '-')
    .replace(/^-|-$/g, '')
  
  return string;
};

FR.trim = function(v) {
  return v.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
};

