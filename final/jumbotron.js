
$(document).ready(function () {
    //update jumbotron
    //http://www.bootply.com/103783
    var jumboHeight = $('.jumbotron').outerHeight();
    function parallax(){
        var scrolled = $(window).scrollTop();
        $('.bg').css('height', ( (scrolled/jumboHeight) + 100) + '%');
    }
    $(window).scroll(function(e){
        parallax();
    });
});
