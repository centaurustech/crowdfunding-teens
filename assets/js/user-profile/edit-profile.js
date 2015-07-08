jQuery(function ($) {
	$(document).ready(function() {

	    /* Sign Up Form */
	    $('#inputDateOfBirth').on('dp.change dp.show', function(e) {
	        // Revalidate the date field
	        $('#frmSignUp').bootstrapValidator('revalidateField', 'inputDateOfBirth');
	    });

	    $('#frmSignUp')
	        .bootstrapValidator({
	            //container: 'tooltip',
	            feedbackIcons: {
	                //valid: 'glyphicon glyphicon-ok',
	                valid: 'glyphicon',
	                invalid: 'glyphicon glyphicon-remove',
	                validating: 'glyphicon glyphicon-refresh'
	            },
	            fields: {
	                inputFullName: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Nome Completo não deve estar vazio'
	                        }
	                    }
	                },
	                inputGender: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Deve selecionar um gênero'
	                        }
	                    }
	                },
	                inputDateOfBirth:{
	                	validators: {
	                        notEmpty: {
	                            message: 'Data de Nascimento não dever ter valor vazío'
	                        },
		                    date: {
		                        format: 'DD/MM/YYYY',
		                        message: 'Formato de data não é válido. Deve colocar valor no formato dd/mm/yyyy'
		                    }
	                    }
	                },
	                inputEmail: {
		                validators: {
		                    notEmpty: {
		                        message: 'O campo E-Mail é obrigatório'
		                    },
		                    emailAddress: {
		                        //message: 'The email address is not valid'
		                    }
		                }
            		},
	                inputUser: {
	                    validators: {
	                        notEmpty: {
	                            message: 'Usuário não deve estar vazio'
	                        }
	                    }
	                },
	                inputPassword: {
	                    validators: {
	                        identical: {
                        		field: 'inputConfirmPassword',
                        		message: 'Senha e confirmação de senha devem ter o mesmo valor'
                    		}
	                    }
	                },
	                inputConfirmPassword: {
	                    validators: {
	                        identical: {
                        		field: 'inputPassword',
                        		message: 'Senha e confirmação de senha devem ter o mesmo valor'
                    		}
	                    }
	                }
	            }
	        });
	        /*
	        .on('error.field.bv', function(e, data) {
	            // Get the tooltip

	            
	            var $parent = data.element.parents('.form-group'),
                $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]'),
                title   = $icon.data('bs.tooltip').getTitle();

	            // Destroy the old tooltip and create a new one positioned to the right
	            
	            $icon.tooltip('destroy').tooltip({
	                html: true,
	                placement: 'right',
	                title: title,
	                container: 'body'
	            });
	        	
	        	
	        });
	        */
	
	    // Reset the Tooltip container form
	    $('#resetSignUpButton').on('click', function(e) {
	        var fields = $('#frmSignUp').data('bootstrapValidator').getOptions().fields,
	            $parent, $icon;
	
	        for (var field in fields) {
	            $parent = $('[name="' + field + '"]').parents('.form-group');
	            $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + field + '"]');
	            $icon.tooltip('destroy');
	        }
	
	        // Then reset the form
	        $('#frmSignUp').data('bootstrapValidator').resetForm(true);
	    });


	});
});