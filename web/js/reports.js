x$.ready(function() {
  var libraryFilter = FR.$$('filter-library');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
  }

  var uList = x$('ul', libraryFilter)[0];

  if (uList) {
    FR.Reports.prepareLibraryFilter(uList);
  }

  var graph = new Bluff.Line('primary-graph-canvas', '500x400');
  graph.tooltips = true;
  graph.sort = false;
  graph.hide_dots = true;
  graph.labels = {};
  graph.theme_37signals();
  graph.data_from_table('primary-data');
  graph.draw();
});

