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
   * @type FR.Backend.Sorter
   */
  this.connection;
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

  if (id.constructor != String) {
    throw new Error('id must be a string');
  }

  this._init(id);
};

/**
 * @param {string} v
 */
FR.Backend.Sorter.prototype.setWeighted = function(isWeighted) {
  this.isWeighted = isWeighted;
};

/**
 * @param {FR.Backend.Sorter} connection
 */
FR.Backend.Sorter.prototype.setConnection = function(connection) {
  if (!(connection instanceof FR.Backend.Sorter)) {
    throw new Error('connection must be a FR.Backend.Sorter');
  }

  this.connection = connection;
};

/**
 * @param {FR.Backend.SorterRow} row
 */
FR.Backend.Sorter.prototype.pushRow = function(row) {
  if (!(row instanceof FR.Backend.SorterRow)) {
    throw new Error('row must be a FR.Backend.SorterRow');
  }

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

  var options = {};

  if (this.connection) {
    options.connectWith = '#' + this.connection.ul.id;
  }
  console.log(options);

  FR.$(this.ul).sortable(options);

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
};

/**
 * @private
 */
FR.Backend.Sorter.prototype._sort = function() {
  this.rows.sort(function(a, b) {
    return a.getWeight() - b.getWeight();
  });
};

