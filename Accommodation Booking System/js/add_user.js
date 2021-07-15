function _id(name) {
  return document.getElementById(name);
}

function changeStatus() {
  var status = _id("UserTypeSelect")
  if (status.value == "Client") {
      _id("ABN").style.display = "none";
      _id("ABN-label").style.display = "none";
      _id("ABN").removeAttribute("required");
  }else{
      _id("ABN").style.display = "block";
      _id("ABN-label").style.display = "block";
      _id("ABN").setAttribute("required", "required");
  }
}