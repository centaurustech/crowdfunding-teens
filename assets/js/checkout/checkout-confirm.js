/**
 * Created by upcesar May 11 2015.
 */

jQuery(function ($) {
	$(document).ready(function() {

	    // Common Functions for checkout
	    jQuery.fn.extend({
	    	syncSignature:function(){
		    	if(!$("#chkHideContribName").is(":checked") && $(this).val().length > 0){
		   			$("#lblContribName").text($(this).val());

		   		}
		   		else{
					$("#lblContribName").text("Anônimo");
		   		}
	    	},
	    	syncAmount:function(){
		    	$(".contribAmount").autoNumeric('set', $(this).autoNumeric('get'));
	   			$("#inputValContribute").val($(this).autoNumeric('get'));
	    	}
	    });

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
	                    trigger: 'keyup',
	                    validators: {
	                        notEmpty: {
	                            message: 'Nome Presente não deve estar vazio'
	                        }
	                    }
	                },
	                inputCampDescription: {
	                    trigger: 'keyup',
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
	                    trigger: 'keyup',
	                    validators: {
	                        notEmpty: {
	                            message: 'Nome não deve estar vazio'
	                        }
	                    }
	                },
	                currency: {
	                    trigger: 'keyup',
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
	            
	            if(data.element.attr('id') === undefined){
	            	return;
	            }

	            var saveButton  = "#" + data.element.attr('id').replace("input", "save-");
	            if(data.element.attr('id') != 'inputContribute')
	            	$(saveButton).removeClass('disabled');


	            if($('.has-error').length > 0)
	            	$('.btn-save-all').addClass('disabled');
	            else
	            	$('.btn-save-all').removeClass('disabled');

        	})
	        .on('error.field.bv', function(e, data) {
	            
	            // Get the tooltip
	            var $parent = data.element.parents('.form-group');
	            var $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]');
	            // var title   = $icon.data('bs.tooltip').getTitle();
	            
	            if(data.element.attr('id') === undefined){
	            	return;
	            }

	            var saveButton  = "#" + data.element.attr('id').replace("input", "save-");

	            if(data.element.attr('id') != 'inputContribute')
	            	$(saveButton).addClass('disabled');

	            if($('.has-error').length > 0)
	            	$('.btn-save-all').addClass('disabled');
	            else
	            	$('.btn-save-all').removeClass('disabled');

	            // Move icon for addnew or Edit all fields. For individual field edit, keep as is.
	            if(data.element.attr('id') == 'inputCampDescription')
	            $icon.css('top','40px');

	            // Put red background if container background is blue (Hardcoded)
	            if(data.field == "currency"){

	            	var $msg = $parent.find('[data-bv-for="' + data.field + '"]');
	            	
	            	$msg.css('background-color','#a94442');
	            	$msg.css('color','#fff');
					
					if(data.element.attr('id') == 'inputCampPriceAmount' && $(".btn-save-all").is(':hidden'))
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

		/* Event for class Currency formatter */
	   $(".currency").keyup(function(e) {
	   		if($(this).hasClass('currency'))
	   			$('#form-campaign').bootstrapValidator('revalidateField', 'currency');
	   });

	   
	   $("#inputSignature").change(function(e) {
	   		$(this).syncSignature();
	   	
	   });

	   $("#inputSignature").keyup(function(e) {
	   		$(this).syncSignature();
	   	
	   });

	   $("#inputContribAmount").change(function(e) {
	   		
	   		$(this).syncAmount();
	   	
	   });

	   $("#inputContribAmount").keyup(function(e) {
	   		
	   		$(this).syncAmount();
	   	
	   });

	   $("#chkHideContribName").change(function(e) {
	   		if(!$("#chkHideContribName").is(":checked") && $("#inputSignature").val().length > 0){
	   			$("#lblContribName").text($("#inputSignature").val());
	   		}
	   		else{
				$("#lblContribName").text("Anônimo");
	   		}
	   });

	   $("#chkHideContribValue").change(function(e) {
	   		if($(this).is(":checked")){
	   			$("#lblShowAmount").hide();
	   		}
	   		else{

	   			$("#lblShowAmount").show();
	   		}
	   });

	   //Set value from hidden input when page is loaded.
	   $("#inputContribAmount").autoNumeric('set', $("#inputValContribute").val());
	   $(".contribAmount").autoNumeric('set', $("#inputValContribute").val());


	   $("#lblContribName").text($("#inputSignature").val().trim() !== '' ? $("#inputSignature").val() : 'Anônimo');

	});
});