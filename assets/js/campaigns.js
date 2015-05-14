/**
 * Created by upcesar May 11 2015.
 */

jQuery(function ($) {
	$(document).ready(function() {
	    
	    $('#form-campaign')
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
	                }
	            }
	        })
	        .on('success.field.bv', function(e, data) {
	            var saveButton  = "#" + data.field.replace("input", "save-");
	            $(saveButton).removeClass('disabled');
        	})
	        .on('error.field.bv', function(e, data) {
	            /*
	            // Get the tooltip
	            var $parent = data.element.parents('.form-group');
	            var $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]');
	            var title   = $icon.data('bs.tooltip').getTitle();
	            var saveButton  = "#" + data.field.replace("input", "save-");

	            $(saveButton).addClass('disabled');

	            // Destroy the old tooltip and create a new one positioned to the top
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
				var saveButton  = "#" + data.field.replace("input", "save-");

	            $(saveButton).addClass('disabled');
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



	});
});