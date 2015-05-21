/**
 * Created by upcesar May 11 2015.
 */

jQuery(function ($) {
	$(document).ready(function() {

	    /* Form validation for campaign and campaign owner
	    *****************************
	    */
	    $('#form-campaigns')
	        .bootstrapValidator({
	        	//container: 'tooltip',
	            feedbackIcons: {
	                //valid: 'glyphicon glyphicon-ok',
	                valid: 'glyphicon',
	                invalid: 'glyphicon glyphicon-minus-sign',
	                validating: 'glyphicon glyphicon-refresh'
	            },
	            fields: {
	                inputCampName: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Nome Presente não deve estar vazio'
	                        }
	                    }
	                },
	                inputCampDescription: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Justificativa não deve estar vazio'
	                        },
	                        stringLength: {
		                        message: 'Deve justificar mais porque você quer o presente',
		                        min: 10
		                    }
	                    }
	                },
	                inputCampOwnerName: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Nome não deve estar vazio'
	                        }
	                    }
	                },
	                currency: {
	                    selector: ".currency",
	                    validators: {
	                        notEmpty: {
	                            message: 'Preço do presente não deve estar vazio'
	                        },
	                        // Custom validation due to use of autoNumeric.js Library
	                        callback: {
	                            message: 'Preço deve ser maior a zero',
	                            callback: function (value, validator, $field) {
	                                return $field.autoNumeric('get') > 0;
	                            }
	                        }
	                    }
	                }
	            }
	        })
	        .on('success.field.bv', function(e, data) {
	            var saveButton  = "#" + data.element.attr('id').replace("input", "save-");
	            if(data.element.attr('id') != 'inputContribute')
	            	$(saveButton).removeClass('disabled');

	            $(".btn-save-all").removeClass('disabled');

        	})
	        .on('error.field.bv', function(e, data) {
	            
	            // Get the tooltip
	            var $parent = data.element.parents('.form-group');
	            var $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]');
	            // var title   = $icon.data('bs.tooltip').getTitle();
	            
	            var saveButton  = "#" + data.element.attr('id').replace("input", "save-");

	            if(data.element.attr('id') != 'inputContribute')
	            	$(saveButton).addClass('disabled');

	            $(".btn-save-all").addClass('disabled');

	            // Put red background if container background is blue (Hardcoded)
	            if(data.field == "currency"){

	            	var $msg = $parent.find('[data-bv-for="' + data.field + '"]');
	            	
	            	$msg.css('background-color','#a94442');
	            	$msg.css('color','#fff');
					
					if(data.element.attr('id') == 'inputCampPriceAmount')
	            		$icon.css('right','77px');

	            }



	            // Destroy the old tooltip and create a new one positioned to the top
	            /*
	            $icon.tooltip('destroy').tooltip({
	                html: true,
	                placement: 'top',
	                title: title,
	                container: 'body',
	                trigger: 'hover focus manual',
	                delay: {
	                	"show": 500,
	                	"hide": 100
	                }
	            });
	        	*/

	        });

	    // Reset the Tooltip container form
	    $('#resetButton').on('click', function(e) {
	        var fields = $('#form-campaign').data('bootstrapValidator').getOptions().fields,
	            $parent, $icon;

	        for (var field in fields) {
	            $parent = $('[name="' + field + '"]').parents('.form-group');
	            $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + field + '"]');
	            $icon.tooltip('destroy');
	        }

	        // Then reset the form
	        $('#form-campaign').data('bootstrapValidator').resetForm(true);
	    });
		
		/* Form validation for campaign and campaign owner (END)
	    *****************************
	    */

		/* Currency format for campaign price and campaign contributions (END)
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


	   /* Event for class Currency formatter */
	   $(".currency").keyup(function(e) {
	   		if($(this).hasClass('currency'))
	   			$('#form-campaign').bootstrapValidator('revalidateField', 'currency');
	   });

	});
});