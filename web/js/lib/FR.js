var FR = FR || {};

FR.$$ = function(id) {
  return document.getElementById( id );
};

FR.trim = function(v) {
  return v.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
};

