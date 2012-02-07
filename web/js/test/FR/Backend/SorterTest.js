SorterTest = TestCase('SorterTest');

SorterTest.prototype.testConstructor_InvalidArg_ThrowsError = function() {
  assertException(function() {
    var sorter = new FR.Backend.Sorter(['jim']);
  });
};

SorterTest.prototype.testSetWeighted_Invalid_ThrowsError = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertException(function() {
    sorter.setWeighted('bar');
  });
};

SorterTest.prototype.testRender_ReturnsHTMLUListElement = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertTagName('UL', sorter.render());
};

SorterTest.prototype.testRender_ElementHasExpectedLiCount = function() {
  var sorter = new FR.Backend.Sorter('foo');

  sorter.pushRow(new FR.Backend.SorterRow(
    'xyz', document.createElement('input')));
  sorter.pushRow(new FR.Backend.SorterRow(
    'abs', document.createElement('input')));

  var ul = sorter.render();

  assertEquals(2, jQuery('li', ul).length);
};

SorterTest.prototype.testRender_ElementHasExpectedId = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertEquals('foo', sorter.render().id); 
};

SorterTest.prototype.testRender_ConnectionSet_HasExpectedConnection = function() {
  var sorterA = new FR.Backend.Sorter('foo');
  var sorterB = new FR.Backend.Sorter('bar');
  
  sorterA.setConnection(sorterB);

  sorterA.pushRow(new FR.Backend.SorterRow(
    'xyz', document.createElement('input')));
  sorterB.pushRow(new FR.Backend.SorterRow(
    'abs', document.createElement('input')));

  document.body.appendChild(sorterB.render());
  document.body.appendChild(sorterA.render());

  assertEquals('#bar', jQuery('#foo').sortable('option', 'connectWith'));
};

SorterTest.prototype.testPushRow_InvalidArg_ThrowsError = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertException(function() {
    sorter.pushRow('foo');
  });
};

SorterTest.prototype.testSetConnection_InvalidArg_ThrowsError = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertException(function() {
    sorter.setConnection('bar');
  });
};

