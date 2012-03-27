/**
 * @constructor
 * @param {HTMLDListElement} dlist - The dl to graph
 */
/**
 * @class
 */
FR.Reports.PieChart = function(dlist) {
  /** 
   * @type {HTMLElement}
   */
  this.target;
  /**
   * @type {string}
   */
  this.title;
  /**
   * @type {Bluff.Pie}
   */
  this.bluff;
  /**
   * @type {string}
   */
  this.size = '500x300';
  /**
   * @type {HTMLDListElement}
   */
  this.dlist = dlist;
};

/**
 * @param {HTMLElement} target
 */
FR.Reports.PieChart.prototype.setTarget = function(target) {
  this.target = target;
};

/**
 * @param {string} title
 */
FR.Reports.PieChart.prototype.setTitle = function(title) {
  this.title = title;
};

FR.Reports.PieChart.prototype.render = function() {
  if (!this.bluff) {
    this.bluff = new Bluff.Pie(this.target.id, this.size);

    this.bluff.theme_37signals();
    this.bluff.tooltips = true;

    this.bluff.replace_colors([
      'maroon', 'silver', 'blue', 'olive', 'red', 'teal', 'navy', 'purple',
      'gray', 'yellow', 'black'
    ]);
  }

  this.bluff.title = this.title;

  var dtCollection = x$('dt', this.dlist);
  var ddCollection = x$('dd', this.dlist);

  for (i = 0; i < dtCollection.length; i++) {
    this.bluff.data(
      dtCollection[i].innerHTML,
      parseFloat(ddCollection[i].innerHTML.replace(/[^\d\.]/g, ''))
    );
  }

  this.bluff.draw();
};

