//GLOBALS
//var now = new Date();
var then = new Date();
var can_send = false;
//DOM


$(document).ready(function () {


    var change_date = jQuery.Event( "change" );
    $("#date-0").attr("value", then);

    //////////////////////
    //What to do when the user hits submit
    //$('#submit').click(function( event ) {
    //    event.preventDefault();
    //    //Post to the test.php page and get content which has been returned in json format (<?php echo json_encode(array("name"=>"John","time"=>"2pm")); ?>).
    //    var posting = $.post( "submit.php", { func: "getAttr" }, function() {
    //        //console.log( data.name ); // John
    //        console.log( then ); // time to send
    //    }, "json");
    //    alert("Submit");
    //});

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
        $.ajax(url_base + "/email.php",
                {type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: ajax_success_handler,
                    error: ajax_error_handler
                });
    };

    //function handler mapping
    $("[type='email']").bind("change", check_email);
    $("[type='date']").bind("change", update_date);
    $('#restform').on('submit', form_submit_handler);


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


