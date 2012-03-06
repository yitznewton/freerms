SorterRowTest = TestCase('SorterRowTest');

SorterRowTest.prototype.testConstructor_InvalidTitle_ThrowsError = function() {
  var inputEl = document.createElement('input');

  assertException(function() {
    var row = new FR.Backend.SorterRow(['foo'], inputEl);
  });
};

SorterRowTest.prototype.testConstructor_InvalidInputEl_ThrowsError = function() {
  assertException(function() {
    var row = new FR.Backend.SorterRow('foo', 'bar');
  });
};

SorterRowTest.prototype.testRender_ReturnsLi = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertTagName('LI', row.render());
};

SorterRowTest.prototype.testRender_ExpectedClassName = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertClassName('ui-state-default', row.render());
};

SorterRowTest.prototype.testRender_ExpectedTitle = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertEquals('foo', jQuery(row.render()).text().substr(0,3));
};

SorterRowTest.prototype.testRemove_FiresOnRemove = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  var spanClose = document.createElement('span');
  spanClose.className = 'ui-icon ui-icon-close';

  var spy = sinon.spy();

  row.setOnRemove(spy);
  row.render({spanClose: spanClose});

  jQuery(spanClose).click();

  assertTrue(spy.called);
};

