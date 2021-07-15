function deleteRow(btn) {
  var row = btn.parentNode.parentNode.parentNode;
  row.parentNode.removeChild(row);
}