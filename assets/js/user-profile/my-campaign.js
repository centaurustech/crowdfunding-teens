jQuery(function ($) {
	$(document).ready(function() {

	    /* Sign Up Form */
	    $('.doDelete').on('click', function(e) {

			var href = $(this).attr('href');
			e.preventDefault();

			bootbox.confirm({
                title: 'Atenção!!!',
                message: 'Tem certeza de deletar esta campanha de presentes?',
                buttons: {
                    'cancel': {
                        label: 'Não',
                        className: 'btn-default'
                    },
                    'confirm': {
                        label: 'Sim',
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result) {
                    	window.location.href = href;
                    }
                }
            });

	    });

	});
});