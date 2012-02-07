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

  if (id.constructor != String) {
    throw new Error('id must be a string');
  }

  this._init(id);
};

/**
 * @param {bool} isWeighted
 */
FR.Backend.Sorter.prototype.setWeighted = function(isWeighted) {
  if (isWeighted.constructor != Boolean) {
    throw new Error('isWeighted must be Boolean');
  }

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
  
  return this.ul;
};

/**
 * @returns {HTMLUListElement}
 */
FR.Backend.Sorter.prototype.render = function() {
  if (this.isRendered) {
    throw new Error('Already rendered'); 
  }

  if (this.isWeighted) {
    this._sort();
  }

  var rowCount = this.rows.length;

  for (var i = 0; i < rowCount; i++) {
    this.ul.appendChild(this.rows[i].render());
  }

  var options = {placeholder: 'ui-state-highlight'};

  if (this.connection) {
    options.connectWith = '#' + this.connection.ul.id;
  }

  jQuery(this.ul).sortable(options);

  this.isRendered = true;

  return this.ul;
};

/**
 * Adjusts input values based on current order of SorterRows
 */
FR.Backend.Sorter.prototype.update = function() {
  // because of trans-sorter migration via connections, we need to work
  // directly with the LI elements
  var ulChildCount = this.ul.childNodes.length;

  for (var i = 0; i < ulChildCount; i++) {
    if (this.ul.childNodes[i].tagName != 'LI') {
      continue;
    }

    var liEl = this.ul.childNodes[i];

    this.isWeighted ? liEl.sorterRow.setWeight(i)
      : liEl.sorterRow.setWeight(-1);
  }
};

/**
 * @private
 * @param {string} id
 */
FR.Backend.Sorter.prototype._init = function(id) {
  this.ul    = document.createElement('ul');
  this.ul.id = id;
};

/**
 * @private
 */
FR.Backend.Sorter.prototype._sort = function() {
  this.rows.sort(function(a, b) {
    return a.getWeight() - b.getWeight();
  });
};

