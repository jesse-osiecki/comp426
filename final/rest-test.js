$(document).ready(function () {
    $('#restform').on('submit', form_submit_handler);
});

var form_submit_handler = function (e) {
    e.preventDefault();
    $.ajax(url_base + "/email.php",
            {type: "POST",
                dataType: "json",
                data: $(this).serialize(),
                success: ajax_success_handler,
                error: ajax_error_handler,
            });
};

var ajax_success_handler = function(data, textStatus, jqXHR) {
    $('#returnstatus').html(jqXHR.status);
    $('#returntext').html(jqXHR.responseText);
};

var ajax_error_handler = function(jqXHR, textStatus, errorThown) {
    $('#returnstatus').html(jqXHR.status);
    $('#returntext').html(jqXHR.responseText);
}

