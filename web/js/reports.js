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

  x$('#primary-data tbody tr').each(function(tr) {
    if (tr.className.match(/\bsuppress\b/)) {
      return;
    }

    var data = [];

    x$('td', tr).each(function(td) {
      data.push(td.innerHTML);
    });

    graph.data(x$('th', tr)[0].innerHTML, data);
  });

  var totalData = [];

  x$('#primary-data tfoot tr td').each(function(td) {
    totalData.push(td.innerHTML);
  });

  graph.data('Total', totalData);

  graph.theme_37signals();
  // graph.data_from_table('primary-data');
  graph.draw();
});

