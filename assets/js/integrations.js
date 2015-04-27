/**
 * Created by rosaeliana on 30/01/15.
 */
$(document).ready(function() {
    $('#formIntegration')
        .bootstrapValidator({
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                client_id: {
                    validators: {
                        notEmpty: {
                            message: 'Client-ID não deve estar vazio'
                        }
                    }
                }
            }
        })
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
        })
        .on('success.form.bv', function(e) {
            e.preventDefault();

            var $form = $(this),
                validator = $form.data('bootstrapValidator');

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $form.serialize(),
                success: function(data) {
                    var msg = data;
                    var flag = msg.substr(1,1);
                    var cadaux = msg.substr(2);
                    var tamcad = cadaux.length;
                    var cad = cadaux.substr(0, tamcad-1);

                    var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('integrations'));
                    var newUrl = baseURL + 'dashboard/';

                    if (flag == '1') {
                        bootbox.dialog({
                            message: cad,
                            title: "Integração com API Imgur",
                            buttons: {
                                success: {
                                    label: "Fechar",
                                    className: "btn-success",
                                    callback: function() {
                                        $(location).attr('href', newUrl);
                                    }
                                }
                            }
                        });

                        $('#formStation').data('bootstrapValidator').resetForm(true);

                    } else if (flag == 0) {
                        bootbox.dialog({
                            message: cad,
                            title: "Integração com API Imgur",
                            buttons: {
                                success: {
                                    label: "Fechar",
                                    className: "btn-danger"
                                }
                            }
                        });
                    }
                }
            });
        });
        
        $('#validateCode').click(
        	function(){        		
				
				client_id = $('#client_id').val();
				var_url = $("#formIntegration").attr('action');
				var_url = var_url.replace('/save/', '');
				var_url = var_url + '/validate/' + client_id + "/";
				
								
				$.ajax({
	                url: var_url,
	                type: 'get',
	                success: function(data) {
	                    var objJSON = $.parseJSON(data);
	                    
	                    if(objJSON.success){
	                    	button_type = "btn-success";
	                    	str_message = objJSON.msg; 
	                    }
	                    else{
	                    	button_type = "btn-danger";
	                    	str_message = "Erro HTTP " + objJSON.status + ": " + objJSON.msg;
	                    }
	                    
	                    bootbox.dialog({
		                    message: str_message,
		                    title: "Integração com API Imgur",
		                    buttons: {
		                        success: {
		                            label: "Fechar",
		                            className: button_type
		                        }
		                    }
		                });         
	
	                    
	                }
	            });				
        		
        	}
        );

});