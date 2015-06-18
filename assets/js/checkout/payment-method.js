/**
 * Created by upcesar May 11 2015.
 */

jQuery(function ($) {
	$(document).ready(function() {

	    /* Currency format for campaign price and campaign contributions
	    *****************************
	    */
	   $(".currency").autoNumeric();

	   $('.currency').autoNumeric('update', {
	   		aSep: '.', 
			wEmpty: '',
			aSign: "R$ ",
			aDec: ',',
			mDec: 2,
			vMin : 0
		});

		/* Currency format for campaign price and campaign contributions (END)
	    *****************************
	    */


	});
});