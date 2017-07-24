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
		$(".books .about").addClass("highlight");
		$(".books .link").addClass("highlight");
	}else if(window.pageYOffset < (pageheight + pageheight)){
		$(".highlight").removeClass("highlight");
		$(".motivation .about").addClass("highlight");
		$(".motivation .link").addClass("highlight");
	}else if(window.pageYOffset < (pageheight + pageheight + pageheight)){
		$(".highlight").removeClass("highlight");
		$(".shit .about").addClass("highlight");
		$(".shit .link").addClass("highlight");
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