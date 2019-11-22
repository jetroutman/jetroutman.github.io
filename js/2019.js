$(document).click(function(event) {
    if(!$(event.target).closest('#nav').length) {
        $(".active").removeClass("active");
    }
})

function menuDisplay(){
	$(".navigation").addClass("active");
}

$(document).ready(function () {
	//Adds on-click functionality to each filter option
	$(".filter-option").click(function(){
		if($(this).hasClass("filter-selected")){
			$(this).removeClass("filter-selected");
			$(this).attr("data-val");
		}else {
			$(this).addClass("filter-selected");
		}
		filterEntries();
	});

	$(".expand").click(function(){
		$(this).css("display", "none");
		$(this).parent().children(".collapse").css("display", "unset");
		$(this).parent().parent().parent().addClass("open-card");
	});

	$(".collapse").click(function(){
		$(this).css("display", "none");
		$(this).parent().children(".expand").css("display", "unset");
		$(this).parent().parent().parent().removeClass("open-card");
	});

	showDivs(slideIndex, "Walk-Thru");
});

function filterEntries(){
	//Filter the selected Experiences
	var filter = [];
	var selected = $(".filter-selected");
	for(var i = 0; i < selected.length; i++){
	    filter.push(selected[i].attributes['data-val'].value);
	}
	if (filter.length > 0) {
		var cards = $(".card-container label")
		for (var i = cards.length - 1; i >= 0; i--) {
			var str = cards[i].innerText.split(", ");
			if(filter.some(elem => str.indexOf(elem) > -1)){
				$($(".card-container")[i]).css("display", "unset");
			}else{
				$($(".card-container")[i]).css("display", "none");
			}
		}
	}else{
		var cards = $(".card-container label")
		for (var i = cards.length - 1; i >= 0; i--) {
			$($(".card-container")[i]).css("display", "unset");
		}
	}
}


// Pictures -- Walk-Thru
var slideIndex = 1;
function plusDivs(n, title) {
  showDivs(slideIndex += n, title);
}

function currentDiv(n, title) {
  showDivs(slideIndex = n, title);
}

function showDivs(n, title) {
  var i;
  var x = document.getElementsByClassName(title);
  var dots = document.getElementsByClassName(title + "-dots");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" pic-badge-fill", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " pic-badge-fill";
}