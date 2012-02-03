/**
 * Represents a jQuery UI Sortable linked to an input
 *
 * @constructor
 * @param {string} id - The desired ID for the <ul>
 */
/**
 * @class
 */
FR.Backend.Sorter = function(id) {
  /**
   * @type HTMLUListElement
   */
  this.ul;
  /**
   * @type Array
   */
  this.connections = [];
  /**
   * @type bool
   */
  this.isWeighted; 
  /**
   * @type bool
   */
  this.isRendered = false;
  /**
   * @type Array
   */
  this.rows = [];
  /**
   * @type Array
   */
  this.rowsToRender = [];

  this._init(id);
};

/**
 * @param {string} v
 */
FR.Backend.Sorter.prototype.setWeighted = function(isWeighted) {
  this.isWeighted = isWeighted;
};

/**
 * @param {array} FR.Backend.Sorter[] connections
 */
FR.Backend.Sorter.prototype.setConnections = function(connections) {
  this.connections = connections;
};

/**
 * @param {FR.Backend.SorterRow} row
 */
FR.Backend.Sorter.prototype.pushRow = function(row) {
  this.rows.push(row);

  if (this.isRendered) {
    this.ul.appendChild(row.render());
  }
  // else {
  //   this.rowsToRender.push(row);
  // }
  
  return this.ul;
};

/**
 * @returns {HTMLUListElement}
 */
FR.Backend.Sorter.prototype.render = function() {
  if (this.isRendered) {
    throw new Error('Already rendered'); 
  }

  var rowCount = this.rows.length;

  for (var i = 0; i < rowCount; i++) {
    this.ul.appendChild(this.rows[i].render());
  }

  return this.ul;
};

FR.Backend.Sorter.prototype.bindInputs = function() {
  if (this.isWeighted) {
    this._sort();
  }

  var rowCount = this.rows.length;

  for (var i = 0; i < rowCount; i++) {
    var row = this.rows[i];
    this.isWeighted ? row.bindInput(i) : row.bindInput(-1);
  }
};

/**
 * @private
 * @param {string} id
 */
FR.Backend.Sorter.prototype._init = function(id) {
  this.ul           = document.createElement('ul');
  this.ul.id        = id;
  this.ul.className = 'sortable';
};

/**
 * @private
 */
FR.Backend.Sorter.prototype._sort = function() {
  this.rows.sort(function(a, b) {
    return a.getWeight() - b.getWeight();
  });
};

