function _id(name) {
    return document.getElementById(name);
}

function _class(name) {
    return document.getElementsByClassName(name);
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

$(document).ready(function () {
    $("#regiForm").on('submit', function () {
        var password = document.querySelector("#pWord").value;
        var confirmPassword = document.querySelector("#pWordConfirm").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.\n \nPassword must consist of 6 to 12 characters\nAt least 1 lower case letter\nAt least 1 uppercase letter\nAt least 1 number\nAt least one of following special characters ! @ # $ % ");
            return false;
        }
    });
});

/// Little bit of code to help me understand jquiry 
/// and visualise what is/was happening on submit

// $(document).ready(function (){
//     $('#regiForm').on('submit',function(){
//         $('#regiForm').css('background-color','red')
//         return false;
//     });
// });