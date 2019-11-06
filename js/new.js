$(document).click(function(event) {
    if(!$(event.target).closest('#nav').length) {
        $(".active").removeClass("active");
    }
})

function menuDisplay(){
	$(".navigation").addClass("active");
}

$(document).ready(function () {
	$( "#nav" ).load("../share/menu.html");
});