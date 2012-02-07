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

  if (title.constructor != String) {
    throw new Error('title must be a string');
  }

  if (inputEl.tagName != 'INPUT') {
    throw new Error('inputEl must be an HTMLInputElement');
  }

  this.title   = title;
  this.inputEl = inputEl;
};

/**
 * @returns {HTMLLIElement}
 */
FR.Backend.SorterRow.prototype.render = function() {
  var li = document.createElement('li');

  li.className = 'ui-state-default';
  li.innerHTML = this.title;
  li.sorterRow = this;  // needed for binding

  // TODO: add arrow, close

  return li;
};

/**
 * @param {int} weight
 */
FR.Backend.SorterRow.prototype.setWeight = function(weight) {
  if (weight.constructor != Number) {
    throw new Error('weight must be a Number');
  }

  this.inputEl.value = weight;
};

/**
 * @returns {int}
 */
FR.Backend.SorterRow.prototype.getWeight = function() {
  return parseInt(this.inputEl.value);
};

/**
 * @param {string} url
 */
FR.Backend.SorterRow.prototype.setAjaxOnRemove = function(url) {
};

