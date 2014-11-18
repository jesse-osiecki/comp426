//GLOBALS
//var now = new Date();
var then = new Date();
var can_send = false;
//DOM
$(document).ready(function () {

    var change_date = jQuery.Event( "change" );
    $("#date-0").attr("value", then);


    var update_date = function() {
        //DATE CHANGED
        var input_val = $( this ).val();
        var timestamp = Date.parse(input_val);
        if (isNaN(timestamp) == false) {
            window.then = new Date(timestamp);
            //alert(window.then);
        } else {
            alert("Your date is formatted incorrectly")
        }
    }

    var check_email = function () {
        //EMAIL changed
        var input_val = $(this).val();
        if(!validateEmail(input_val)){
            alert("Your email is formatted incorrectly");
        }
    }
    $("[type='email']").bind("change", check_email);
    $("[type='date']").bind("change", update_date);
});

function validateEmail($email) {
    //http://stackoverflow.com/questions/2507030/email-validation-using-jquery
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( $email ) ) {
        return false;
    } else {
        return true;
    }
}
