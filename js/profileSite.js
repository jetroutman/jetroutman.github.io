$(document).click(function(event) {
    if(!$(event.target).closest('#nav').length) {
        $(".active").removeClass("active");
    }
})

function menuDisplay(){
	$(".navigation").addClass("active");
}

$(document).ready(function () {
	windowWidth();
	$(window).resize(function () {
		windowWidth();
	});
});

function windowWidth(){
	if ($(window).width() < 788){
		$(".container-fluid").addClass("mini-body");
		$(".navigation").addClass("mini-nav");
	}else{
		$(".mini-body").removeClass("mini-body");
		$(".mini-nav").removeClass("mini-nav")
	}
}