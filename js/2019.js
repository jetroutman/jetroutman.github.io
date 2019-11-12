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
});

function filterEntries(){
	//Filter the selected Experiences
	var filter = "";
	var selected = $(".filter-selected");
	for(var i = 0; i < selected.length; i++){
	    filter += selected[i].attributes['data-val'].value;
	}
}