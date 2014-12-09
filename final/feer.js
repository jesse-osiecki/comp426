//GLOBALS
//var now = new Date();
var then = new Date();
var can_send = false;
var url_base = "https://jessejosiecki.com/comp426/final";
//DOM


$(document).ready(function () {


    var change_date = jQuery.Event( "change" );
    $("#date-0").attr("value", then);

    //UPDATE the date
    var update_date = function() {
        //DATE CHANGED
        var input_val = $( this ).val();
        var timestamp = Date.parse(input_val);
        if (isNaN(timestamp) == false) {
            window.then = new Date(timestamp);
            //alert(window.then);
        } else {
            alert("Bad date format");
        }
    }

    var check_email = function () {
        //EMAIL changed
        var input_val = $(this).val();
        if(!validateEmail(input_val)){
            alert("Bad email format");
        }
    }
    var ajax_success_handler = function(data, textStatus, jqXHR) {
        $('#returnstatus').html(jqXHR.status);
        $('#returntext').html(jqXHR.responseText);
    };

    var ajax_error_handler = function(jqXHR, textStatus, errorThown) {
        $('#returnstatus').html(jqXHR.status);
        $('#returntext').html(jqXHR.responseText);
    };
    var form_submit_handler = function (e) {
        e.preventDefault();
        console.log( $( this ).serialize() );
        var url = url_base + "/email.php";
        var postid = $('#postid').val();
        url = (postid) ? (url + "/" + postid) : url;
        $.ajax(url,
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: ajax_success_handler,
                    error: ajax_error_handler
                });
    };
    var get_handler = function (e) {
        e.preventDefault();
        console.log( $( this ).serialize() );   
        $.ajax(url_base + "/email.php/" + $('#getid').val(),
                {type: "GET",
                    dataType: "json",
                    success: ajax_success_handler,
                    error: ajax_error_handler
                });
    };
    var list_handler = function (e) {
        e.preventDefault();
        console.log( $( this ).serialize() );   
        $.ajax(url_base + "/email.php",
                {type: "GET",
                    dataType: "json",
                    success: ajax_success_handler,
                    error: ajax_error_handler
                });
    };
    var delete_handler = function (e) {
        e.preventDefault();
        console.log( $( this ).serialize() );   
        $.ajax(url_base + "/email.php/" + $('#getid').val(),
                {type: "GET",
                    dataType: "json",
                    data: "delete=true",
                    success: ajax_success_handler,
                    error: ajax_error_handler
                });
    };

    //function handler mapping
    $("[type='email']").bind("change", check_email);
    $("[type='date']").bind("change", update_date);
    $('#restform').on('submit', form_submit_handler); //SUBMIT EMAIL FOR CREATION

    $('#getform').on('submit', get_handler); //get email stuff
    $('#listform').on('submit', list_handler); //list email stuff
    $('#deleteform').on('submit', delete_handler); //delete email stuff


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


