/**
 * Created by upcesar May 11 2015.
 */

jQuery(function ($) {
	$(document).ready(function() {

	   /* Event for class Currency formatter */
	   $("#btnShowMore").click(function(e) {
	   		
	   		e.preventDefault();

	   		//Get the last element if any
	   		var iLastElement = $(".campaign-list").length;
	   		if(iLastElement >= 4){
	   			
	   			for (var i = 0; i < 4; i++) {
	   				var lastElement = ($(".campaign-list")[iLastElement - 1]);
	   				var currentElement = ($(".campaign-list")[i]);
	   				var divInitial = '<div class="col-md-3 campaign-list">';
	   				var divFinal = '</div>';
	   				$(lastElement).after(divInitial + $(currentElement).html() + divFinal);
	   			}

				/*
				// Scroll to last element smoothly.
				$('html, body').animate({
                    scrollTop: $("#lastCampaign").offset().top - 100
                }, 500);
	   			*/

	   		}

	   		$(this).blur();

	   		
	   		
	   });

	});
});