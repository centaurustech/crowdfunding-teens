
jQuery(function ($) {
	
	$(document).ready(function(){
		
		$('.dropdown-toggle').dropdown();  // Menu dropdown
		
		$('#modalPermissions').on('show.bs.modal', function (event) {
		  
		  var button = $(event.relatedTarget); // Button that triggered the modal
		  var module = button.data('module'); // Extract info from data-* attributes
		  var module = button.data('module'); // Extract info from placeholder attributes
		  
		  
		  $("#modalTitle").text(button.text());
		  
		  // Meanwhile we use hardcoded values for populate markets and stations
		  // until AJAX callback function is ready.
		  
		  switch(module){
		  	case "market":
				textFilter = "Mercado";
				aData = { 
		  				market001: "Geral / Merchandising",
		  				market002: "Roupa / Acessórios", 
		  				market003: "Carros / Motos"
		  			};
		  			
		  		break;
		  	case "station":
		  		textFilter = "Emissora";
				aData = { 
		  				station001: "R7",
		  				station002: "Band", 
		  				station003: "Globo"
		  			};
		  			
		  		break;
		  	case "users":
		  		textFilter = "Login";
		  		aData = { 
		  				user001: "joaosilva - João Silva",
		  				user002: "agomes - Ana Gómes", 
		  				user003: "patriciaf - Patricia Freitas"
		  			};
		  			
		  		break;	  			  	
		  }
		
		$('#filterDataPerm').attr('placeholder', 'Filtrar ' + textFilter);
		$("#dataPopulated").html('');
		$.each(aData, function( code, description ) {
	  		$("#dataPopulated").append('<div class="checkbox"><label><input type="checkbox" id = '+ code + '> '+ description + '</label></div>');
	  		//alert( "Key: " + code + ", Value: " + description );
			});
				
		});
	
		$(".delete-operation").click(function(event){
			event.preventDefault();			
			}			
		);


        /*$('button[id=alterarsenha]').click(function(ev) {
            ev.preventDefault();

            var url_form = $('#frmLogin').attr('action');
            var method_form = $('#frmLogin').attr('method');

            $.ajax({
                url: url_form,
                type: method_form,
                data: $('#frmLogin').serialize(),
                success: function(data) {
                    var msg = data;
                    var flag = msg.substr(1,1);
                    var cadaux = msg.substr(2);
                    var tamcad = cadaux.length;
                    var cad = cadaux.substr(0, tamcad-1);

                    if (flag == '1') {
                        bootbox.dialog({
                            message: cad,
                            title: "Alteração de senha",
                            buttons: {
                                success: {
                                    label: "Cancelar",
                                    className: "btn-success"
                                }
                            }
                        });
                    } else {
                        bootbox.dialog({
                            message: cad,
                            title: "Alteração de senha",
                            buttons: {
                                success: {
                                    label: "Cancelar",
                                    className: "btn-error"
                                }
                            }
                        });
                    }
                }
            });
        });*/

        $('#frmRecover')
            .bootstrapValidator({
                container: 'tooltip',
                feedbackIcons: {
                    valid: 'glyphicon',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    inputEmail: {
                        validators: {
                            notEmpty: {
                                message: 'O campo E-Mail é obrigatório'
                            },
                            regexp: {
                                regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
                                message: 'O endereço de e-mail não é válido'
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

                /*var url_form = $('#frmRecover').attr('action');
                 var method_form = $('#frmRecover').attr('method');*/

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

                        if (flag == '1') {
                            bootbox.dialog({
                                message: cad,
                                title: "Alteração de senha",
                                buttons: {
                                    success: {
                                        label: "Fechar",
                                        className: "btn-success"
                                    }
                                }
                            });
                        } else {
                            bootbox.dialog({
                                message: cad,
                                title: "Alteração de senha",
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

        // Reset the Tooltip container form
        $('#resetButton').on('click', function(e) {
            var fields = $('#frmRecover').data('bootstrapValidator').getOptions().fields,
                $parent, $icon;

            for (var field in fields) {
                $parent = $('[name="' + field + '"]').parents('.form-group');
                $icon   = $parent.find('.form-control-feedback[data-bv-icon-for="' + field + '"]');
                $icon.tooltip('destroy');
            }

            // Then reset the form
            $('#frmRecover').data('bootstrapValidator').resetForm(true);
        });
	});		
});

