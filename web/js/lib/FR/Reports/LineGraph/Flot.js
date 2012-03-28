/**
 * @constructor
 * @param {HTMLTableElement} table - The table to graph
 */
/**
 * @class
 */
FR.Reports.LineGraph.Flot = function(table) {
  FR.Reports.LineGraph.call(this, table);
};

FR.Reports.LineGraph.Flot.prototype = new FR.Reports.LineGraph();
FR.Reports.LineGraph.Flot.prototype.constructor = FR.Reports.LineGraph.Flot;

FR.Reports.LineGraph.Flot.prototype.render = function() {
  $.plot(this.target, this._getRows(), {
    series: {
      lines: { show: true },
      points: { show: false },
      hoverable: true
    },
    legend: {
      noColumns: 2
    },
    xaxis: { show: false },
    yaxis: {
      tickDecimals: 0,
      labelWidth: 8
    }
  });
};

/**
 * @returns {Array}
 */
FR.Reports.LineGraph.Flot.prototype._getRows = function() {
  var allData = [];

  // maintain color assignments even when hiding rows
  var colors = [
    'maroon', 'silver', 'blue', 'olive', 'red', 'teal', 'navy', 'purple',
    'gray', 'yellow', 'black'
  ];

  var colorIndex = -1;

  x$('tbody tr', this.table).each(function(tr) {
    var lineData = [];
    colorIndex++;

    if (tr.className.match(/\bsuppress\b/)) {
      return;
    }

    var cells = x$('td', tr);

    for (i = 0; i < cells.length; i++) {
      lineData.push([i, parseInt(cells[i].innerHTML)]);
    }

    // color assignments wrap around if more lines than available colors
    allData.push({ label: x$('th', tr)[0].innerHTML, data: lineData,
      color: colors[colorIndex % colors.length] });
  });

  var totalData = [];
  colorIndex++;

  var cells = x$('tfoot td', this.table);

  for (i = 0; i < cells.length; i++) {
    totalData.push([i, parseInt(FR.trim(cells[i].innerHTML))]);
  }

  allData.push({ label: 'TOTAL', data: totalData,
    color: colors[colorIndex % colors.length] });
  
  return allData;
};

