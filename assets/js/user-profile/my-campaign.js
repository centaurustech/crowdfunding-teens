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


        $('#formFilterCamp')
            .bootstrapValidator({
                //container: 'tooltip',
                feedbackIcons: {
                    //valid: 'glyphicon glyphicon-ok',
                    valid: 'glyphicon',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

                    inputCreationDate:{
                        validators: {
                            date: {
                                format: 'DD/MM/YYYY',
                                message: 'Formato de data não é válido. Deve colocar valor no formato dd/mm/yyyy'
                            }
                        }
                    }
                }
            });

        $('#inputCreationDate').on('dp.change dp.show', function(e) {
            // Revalidate the date field
            $('#formFilterCamp').bootstrapValidator('revalidateField', 'inputCreationDate');
        });

        $("#formFilterCamp").submit(function(event) {
                
            $(".number_hidden").each(function(index, el) {
                if($(this).val() != "" && $(this).val() != " %" ){
                    hiddenID = "#" + $(this).attr('id') + "Val";
                    $(hiddenID).val($(this).autoNumeric('get'));
                }
            });

        });

        $('#inputCompleted').autoNumeric('init', {
            aSep: '.', 
            wEmpty: '',
            aSign: " %",
            pSign: 's',
            aDec: ',',
            mDec: 2,
            vMin : 0
        });

        

	});
});