/**
 * Created by upcesar July 15 2015.
 * Script for sharing content on social media
 */

jQuery(function ($) {
	$(document).ready(function() {

	    jQuery.fn.extend({
	    	loadPopUp: function (){
	    		var winHandler = this.data('social-media'),
	    			width  = 575,
		        	height = 400,
		        	url = this.attr('href'),
		        	left   = ($(window).width()  - width)  / 2,
		        	top    = ($(window).height() - height) / 2,
		        	opts   = 'status=1' +
		                 	 ',width='  + width  +
		                 	 ',height=' + height +
		                 	 ',top='    + top    +
		                 	 ',left='   + left;

	    	var finalURL = this.setSocialMediaURL(url, winHandler);

	    	var myWindow = window.open(finalURL, winHandler, opts);

	    	//myWindow.document.write($(this));

	    	return false;

	    	},
	    	setSocialMediaURL: function (url, winHandler){
	    		
	    		var param = "";

	    		switch(winHandler) {
	    			case 'facebook':
	    				param = "?app_id="+this.data('app-id') +
	    						"&u="+encodeURIComponent(this.data('url'));

	    				break;
	    			case 'google-plus':
	    				param = "?url="+encodeURIComponent('http://tinyurl.com/oqyehgs'); //this.data('url'));
	    				break;
	    			case 'twitter':
	    				param = "?original_referer="+encodeURIComponent(url) +
	    						"&text="+this.data('text') +
	    						"&url="+encodeURIComponent(this.data('url'));
	    				break;
	    			default :
	    				break;
	    		}

	    		return url + param;

	    	}
	    });

	    $('.share_popup').click(function(event) {

	    	event.preventDefault();

	    	$(this).loadPopUp();

		    return false;
		});


	});
});