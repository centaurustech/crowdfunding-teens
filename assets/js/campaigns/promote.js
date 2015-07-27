jQuery(function ($) {
	$(document).ready(function() {

	    /* Promote Campaign */

        var shareButtons = $(".share-buttons").clone(true);
        var shareMessage = $("#msgPromoteCampaign").val();

        var htmlShare = shareButtons.html()

        htmlShare = htmlShare.replace('short-url-text', 'short-url-text-modal');
        htmlShare = htmlShare.replace('link-get-short-url', 'link-get-short-url-modal');
        htmlShare = htmlShare.replace('short-link-ballon', 'short-link-ballon-modal');

        bootbox.dialog({
                title: "Espalha a voz sobre esta campanha",
                message: 
                    '<script src="http://localhost/projects/crowdfunding-teens/assets/js/share-social-media.js"></script>' +
                    '<div class="row">  ' +
                    '<div class="col-md-offset-1 col-md-11">  ' +
                    shareMessage +
                    '</div> ' +

                    '<div class="col-md-offset-1 col-md-11 share-buttons">  ' +
                    htmlShare +
                    '</div>'+
                    '</div>',
                buttons: {
                    success: {
                        label: "Compartilhar Depois",
                        className: "btn-info"
                    }
                }
            }
        );

	});
});
