$(document).ready(function () {
	Highlight();
	$(window).scroll(function () {
		Highlight();
	});
});

function Highlight(){
	var pageheight = window.innerHeight - 46;
	if (window.pageYOffset < pageheight){
		$(".highlight").removeClass("highlight");
		$(".first-panel").addClass("highlight");
	}else if(window.pageYOffset < (pageheight + pageheight)){
		$(".highlight").removeClass("highlight");
		$(".second-panel").addClass("highlight");
	}else if(window.pageYOffset < (pageheight + pageheight + pageheight)){
		$(".highlight").removeClass("highlight");
		$(".third-panel").addClass("highlight");
	}
}

function scroll(){
	var pageheight = window.innerHeight - 45;
	if (window.pageYOffset < pageheight){
		window.scrollTo(0, pageheight);
	}else if(window.pageYOffset < (pageheight + pageheight)){
		window.scrollTo(0, pageheight*2);
	}
}

$(document).ready(function (){
	menuSize();
	$(window).resize(function() {
		menuSize();
	});
});

function menuSize(){
	var pageWidth = window.innerWidth;
	if (pageWidth < 788){
		$(".mini-menubar").addClass("active");
		$(".menu").addClass("mini-menu");
	}else if (pageWidth > 787){
		$(".active").removeClass("active");
		$(".mini-menu"). removeClass("mini-menu");
	}
}

function menuDisplay(){
	$(".mini-menu").addClass("active");
}