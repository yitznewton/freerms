x$.ready(function() {
  var libraryFilter = FR.$$('filter-library');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
  }

  var uList = x$('ul', libraryFilter)[0];

  if (uList) {
    FR.Reports.prepareLibraryFilter(uList);
  }

  var graph = new FR.Reports.LineGraph.Bluff(FR.$$('primary-data'));
  graph.render(FR.$$('primary-graph-canvas'));
});

