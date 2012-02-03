/**
 * Represents a row in a Sorter
 *
 * @constructor
 * @param {string} title - The desired title for the item
 * @param {HTMLInputElement} inputEl - The weight input element to bind
 */
FR.Backend.SorterRow = function(title, inputEl) {
  /**
   * @type string
   */
  this.title;
  /**
   * @type HTMLInputElement
   */
  this.inputEl;

  this.title   = title;
  this.inputEl = inputEl;
};

/**
 * @returns {HTMLLIElement}
 */
FR.Backend.SorterRow.prototype.render = function() {
  var li = document.createElement('li');

  li.className = 'ui-state-default'; // TODO: test
  li.innerHTML = this.title; // TODO test
  li.sorterRow = this; // needed for binding

  // TODO: add arrow, close
  //
  return li;
};

/**
 * @param {int} weight
 */
FR.Backend.SorterRow.prototype.setWeight = function(weight) {
};

/**
 * @returns {int}
 */
FR.Backend.SorterRow.prototype.getWeight = function() {
};

/**
 * @param {int} weight
 */
FR.Backend.SorterRow.prototype.bindInput = function(v) {
};

/**
 * @param {string} url
 */
FR.Backend.SorterRow.prototype.setAjaxOnRemove = function(url) {
};

