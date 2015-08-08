jQuery(function ($) {
	$(document).ready(function() {

	    $('#formFilterContribReceived')
            .bootstrapValidator({
                //container: 'tooltip',
                feedbackIcons: {
                    //valid: 'glyphicon glyphicon-ok',
                    valid: 'glyphicon',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

                    inputContribDate:{
                        validators: {
                            date: {
                                format: 'DD/MM/YYYY',
                                message: 'Formato de data não é válido. Deve colocar valor no formato dd/mm/yyyy'
                            }
                        }
                    }
                }
            });

        $('#inputContribDate').on('dp.change dp.show', function(e) {
            // Revalidate the date field
            $('#formFilterContribReceived').bootstrapValidator('revalidateField', 'inputContribDate');
        });

        $("#formFilterContribReceived").submit(function(event) {
                
            $(".number_hidden").each(function(index, el) {
                if($(this).val() != "" && $(this).val() != " %" ){
                    hiddenID = "#" + $(this).attr('id') + "Val";
                    $(hiddenID).val($(this).autoNumeric('get'));
                }
            });

        });

        $(".btn-withdrawal").popover();


	});
});