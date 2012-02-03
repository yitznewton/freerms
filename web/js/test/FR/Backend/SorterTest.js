SorterTest = TestCase('SorterTest');

SorterTest.prototype.testConstructor_SetsUpUl = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertEquals('foo', sorter.ul.id); 
  assertEquals('sortable', sorter.ul.className); 
};

