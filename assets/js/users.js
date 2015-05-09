/**
 * Created by rosaeliana on 15/01/15.
 */
$(document).ready(function() {
    var users_stations = '';
    var users_markets = '';

    /* Botones modulo Users */
    $('button#btn_user_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_user').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_user').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_user_read').removeClass("btn btn-success");
            $('button#btn_user_read').addClass("btn btn-default");
            $('button#btn_user_access').removeClass("btn btn-success");
            $('button#btn_user_access').addClass("btn btn-default");
        } else {
            $('#permissions_user').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_user_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_user').val();

        if (valueRead != 1) {
            $('#permissions_user').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_user_deny').removeClass("btn btn-success");
            $('button#btn_user_deny').addClass("btn btn-default");
            $('button#btn_user_access').removeClass("btn btn-success");
            $('button#btn_user_access').addClass("btn btn-default");
        } else {
            $('#permissions_user').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_user_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_user').val();

        if (valueAccess != 2) {
            $('#permissions_user').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_user_read').removeClass("btn btn-success");
            $('button#btn_user_read').addClass("btn btn-default");
            $('button#btn_user_deny').removeClass("btn btn-success");
            $('button#btn_user_deny').addClass("btn btn-default");
        } else {
            $('#permissions_user').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    /* Botones modulo Emisoras */
    $('button#btn_radio_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_radio').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_radio').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_radio_read').removeClass("btn btn-success");
            $('button#btn_radio_read').addClass("btn btn-default");
            $('button#btn_radio_access').removeClass("btn btn-success");
            $('button#btn_radio_access').addClass("btn btn-default");
        } else {
            $('#permissions_radio').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_radio_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_radio').val();

        if (valueRead != 1) {
            $('#permissions_radio').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_radio_deny').removeClass("btn btn-success");
            $('button#btn_radio_deny').addClass("btn btn-default");
            $('button#btn_radio_access').removeClass("btn btn-success");
            $('button#btn_radio_access').addClass("btn btn-default");
        } else {
            $('#permissions_radio').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_radio_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_radio').val();

        if (valueAccess != 2) {
            $('#permissions_radio').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_radio_deny').removeClass("btn btn-success");
            $('button#btn_radio_deny').addClass("btn btn-default");
            $('button#btn_radio_read').removeClass("btn btn-success");
            $('button#btn_radio_read').addClass("btn btn-default");
        } else {
            $('#permissions_radio').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    /* Botones modulo Mercado */
    $('button#btn_market_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_market').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_market').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_market_read').removeClass("btn btn-success");
            $('button#btn_market_read').addClass("btn btn-default");
            $('button#btn_market_access').removeClass("btn btn-success");
            $('button#btn_market_access').addClass("btn btn-default");
        } else {
            $('#permissions_market').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_market_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_market').val();

        if (valueRead != 1) {
            $('#permissions_market').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_market_deny').removeClass("btn btn-success");
            $('button#btn_market_deny').addClass("btn btn-default");
            $('button#btn_market_access').removeClass("btn btn-success");
            $('button#btn_market_access').addClass("btn btn-default");
        } else {
            $('#permissions_market').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_market_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_market').val();

        if (valueAccess != 2) {
            $('#permissions_market').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_market_deny').removeClass("btn btn-success");
            $('button#btn_market_deny').addClass("btn btn-default");
            $('button#btn_market_read').removeClass("btn btn-success");
            $('button#btn_market_read').addClass("btn btn-default");
        } else {
            $('#permissions_market').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    /* Botones modulo Asociar Album */
    $('button#btn_album_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_album').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_album').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_album_read').removeClass("btn btn-success");
            $('button#btn_album_read').addClass("btn btn-default");
            $('button#btn_album_access').removeClass("btn btn-success");
            $('button#btn_album_access').addClass("btn btn-default");
        } else {
            $('#permissions_album').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_album_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_album').val();

        if (valueRead != 1) {
            $('#permissions_album').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_album_deny').removeClass("btn btn-success");
            $('button#btn_album_deny').addClass("btn btn-default");
            $('button#btn_album_access').removeClass("btn btn-success");
            $('button#btn_album_access').addClass("btn btn-default");
        } else {
            $('#permissions_album').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_album_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_album').val();

        if (valueAccess != 2) {
            $('#permissions_album').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_album_deny').removeClass("btn btn-success");
            $('button#btn_album_deny').addClass("btn btn-default");
            $('button#btn_album_read').removeClass("btn btn-success");
            $('button#btn_album_read').addClass("btn btn-default");
        } else {
            $('#permissions_album').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    /* Botones modulo Consulta album con imagen */
    $('button#btn_albumimg_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_albumimg').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_albumimg').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_albumimg_read').removeClass("btn btn-success");
            $('button#btn_albumimg_read').addClass("btn btn-default");
            $('button#btn_albumimg_access').removeClass("btn btn-success");
            $('button#btn_albumimg_access').addClass("btn btn-default");
        } else {
            $('#permissions_albumimg').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_albumimg_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_albumimg').val();

        if (valueRead != 1) {
            $('#permissions_albumimg').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_albumimg_deny').removeClass("btn btn-success");
            $('button#btn_albumimg_deny').addClass("btn btn-default");
            $('button#btn_albumimg_access').removeClass("btn btn-success");
            $('button#btn_albumimg_access').addClass("btn btn-default");
        } else {
            $('#permissions_albumimg').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_albumimg_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_albumimg').val();

        if (valueAccess != 2) {
            $('#permissions_albumimg').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_albumimg_deny').removeClass("btn btn-success");
            $('button#btn_albumimg_deny').addClass("btn btn-default");
            $('button#btn_albumimg_read').removeClass("btn btn-success");
            $('button#btn_albumimg_read').addClass("btn btn-default");
        } else {
            $('#permissions_albumimg').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    /* Botones modulo Integraciones */
    $('button#btn_integration_deny').click(function(ev) {
        ev.preventDefault();

        var valueDeny = $('#permissions_integration').val();

        if (valueDeny != 0 || valueDeny == '') {
            $('#permissions_integration').val(0);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_integration_read').removeClass("btn btn-success");
            $('button#btn_integration_read').addClass("btn btn-default");
            $('button#btn_integration_access').removeClass("btn btn-success");
            $('button#btn_integration_access').addClass("btn btn-default");
        } else {
            $('#permissions_integration').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_integration_read').click(function(ev) {
        ev.preventDefault();

        var valueRead = $('#permissions_integration').val();

        if (valueRead != 1) {
            $('#permissions_integration').val(1);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_integration_deny').removeClass("btn btn-success");
            $('button#btn_integration_deny').addClass("btn btn-default");
            $('button#btn_integration_access').removeClass("btn btn-success");
            $('button#btn_integration_access').addClass("btn btn-default");
        } else {
            $('#permissions_integration').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_integration_access').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_integration').val();

        if (valueAccess != 2) {
            $('#permissions_integration').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_integration_deny').removeClass("btn btn-success");
            $('button#btn_integration_deny').addClass("btn btn-default");
            $('button#btn_integration_read').removeClass("btn btn-success");
            $('button#btn_integration_read').addClass("btn btn-default");
        } else {
            $('#permissions_integration').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $(document).on("click", "#linkdelete", function(ev){
        ev.preventDefault();
        var url = $(this).attr("data-info");

        bootbox.confirm({
            title: 'Alerta!!!',
            message: 'Tem certeza de deletar o registro selecionado?',
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
                    $.ajax({
                        url: url,
                        success: function(data) {
                            bootbox.dialog({
                                message: data,
                                title: "Deletar",
                                buttons: {
                                    success: {
                                        label: "Fechar",
                                        className: "btn-success",
                                        callback: function(){
                                        	location.reload();
                                        	return;
                                        }
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });
    });

    $('modalDelete').on('show.bs.modal', function (event) {
        $('button#deleteuser').click(function(ev) {
            alert("aqui2");
        });
    });

    $('button#deleteuser').click(function(ev) {
        ev.preventDefault();

        var valueAccess = $('#permissions_integration').val();

        if (valueAccess != 2) {
            $('#permissions_integration').val(2);
            $(this).removeClass("btn btn-default");
            $(this).addClass("btn btn-success");

            $('button#btn_integration_deny').removeClass("btn btn-success");
            $('button#btn_integration_deny').addClass("btn btn-default");
            $('button#btn_integration_read').removeClass("btn btn-success");
            $('button#btn_integration_read').addClass("btn btn-default");
        } else {
            $('#permissions_integration').val('');
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-default");
        }
    });

    $('button#btn_save_permissions').click(function(ev) {
        ev.preventDefault();

        var $form = $('#formPermissions');

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
                        title: "Permissões e Acessos",
                        buttons: {
                            success: {
                                label: "Fechar",
                                className: "btn-success",
                                callback: function() {
										var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('users'));
				                    	var newUrl = baseURL + 'dashboard/view/users/';                        
				                    	$(location).attr('href', newUrl);
                        				return;
                  					}
                            }
                        }
                    });
                } else if (flag == 0) {
                    bootbox.dialog({
                        message: cad,
                        title: "Permissões e Acessos",
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

    /* Validacion formulario de usuarios */
    $('#formUser')
        .bootstrapValidator({
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                userLogin: {
                    validators: {
                        notEmpty: {
                            message: 'Usuário não deve estar vazio'
                        }
                    }
                },
                userFirtsName: {
                    validators: {
                        notEmpty: {
                            message: 'Nome não deve estar vazio'
                        }
                    }
                },
                userLastName: {
                    validators: {
                        notEmpty: {
                            message: 'Sobrenome não deve estar vazio'
                        }
                    }
                },
                userEMail: {
                    validators: {
                        notEmpty: {
                            message: 'O campo E-Mail é obrigatório'
                        },
                        regexp: {
                            regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
                            message: 'O endereço de e-mail não é válido'
                        }
                    }
                },
                userPassword: {
                    enabled: (document.URL.toLowerCase().indexOf('/create/') >= 0),
                    validators: {
                        notEmpty: {
                            message: 'Senha não deve estar vazio'
                        },
                        identical: {
                            field: 'userCOnfirmPassword',
                            message: 'Senha e confirmação de senha devem ter o mesmo valor'
                        }
                    }
                },
                userCOnfirmPassword: {
                    enabled: (document.URL.toLowerCase().indexOf('/create/') >= 0),
                    validators: {
                        notEmpty: {
                            message: 'Confirmação de Senha não deve estar vazio'
                        },
                        identical: {
                            field: 'userPassword',
                            message: 'Senha e confirmação de senha devem ter o mesmo valor'
                        }
                    }
                }
            }
        })
        // Enable the password/confirm password validators if the password is not empty
        .on('keyup', '[name="userPassword"]', function() {
	            var isEmpty = $(this).val() == '';
	            var isNew = (document.URL.toLowerCase().indexOf('/create/') >= 0); 

	            // URL create means CRUD for creating record.
	            // Therefore password validation should be enabled	            	            
	            if(isNew){
	            	isEmpty = false;
	            }
	            
	            
            	$('#formUser')
                    .bootstrapValidator('enableFieldValidators', 'userPassword', !isEmpty)
                    .bootstrapValidator('enableFieldValidators', 'userCOnfirmPassword', !isEmpty);
            
            
            	// Revalidate the field when user start typing in the password field
	            if ($(this).val().length == 1 || isNew) {
	                $('#formUser').bootstrapValidator('validateField', 'userPassword')
	                                .bootstrapValidator('validateField', 'userCOnfirmPassword');
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
                    
                    if (flag == '1') {
                        
                        bootbox.dialog({
                            message: cad,
                            title: "Usuários",
                            buttons: {
                                success: {
                                    label: "Fechar",
                                    className: "btn-success",
                                    callback: function() {
										var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('users'));
				                    	var newUrl = baseURL + 'dashboard/view/users/';                        
				                    	$(location).attr('href', newUrl);
                        				return;
                  					}
                                }
                            }
                        });

                        //$('#formUser').data('bootstrapValidator').resetForm(true);

                    } else if (flag == 0) {
                        bootbox.dialog({
                            message: cad,
                            title: "Usuários",
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


    /* asignacion de permisos para usuarios */

    /* Llamado de ventana con listado de mercados */
    $('button#users_markets').click(function(ev) {
        ev.preventDefault();
        var url = $(this).attr("data-info");

        var marketselected = $('#marketsbyuser').val();

        if (marketselected == '') {
            marketselected = users_markets;
        }

        var datamarket = 'marketselected=' + marketselected;

        $.ajax({
            url: url,
            type: 'post',
            data: datamarket,
            success: function (data) {
                $('#body_modalmarket').html(data);
            }
        });

        /*$('#modalMarkets').modal({show:true});*/
    });

    /* Llamado de ventana con listado de emisoras */
    $('button#users_stations').click(function(ev) {
        ev.preventDefault();
        var url = $(this).attr("data-info");

        var stationselected = $('#stationsbyuser').val();

        if (stationselected == '') {
            stationselected = users_stations;
        }

        var datastation = 'stationselected=' + stationselected;

        $.ajax({
            url: url,
            type: 'post',
            data: datastation,
            success: function (data) {
                $('#body_modalstation').html(data);
            }
        });

        $('#modalStations').modal({show:true});
    });

    /* Manejo de busqueda */
    $(document).on("click", "#search_market_modal", function(e){
        e.preventDefault();

        var $form = $('#searchmarketmodal');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#body_modalmarket').html(data);
            }
        });
    });

    /* Manejo de busqueda */
    $(document).on("click", "#search_station_modal", function(e){
        e.preventDefault();

        var $form = $('#searchstationmodal');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#body_modalstation').html(data);
            }
        });
    });

    /* Se cierra la ventana y se envia al formulario principal los elementos seleccionados */
    $('#modalMarket').on('show.bs.modal', function () {
        $('a[id=save_marketsPermissions]').click(function(ev) {
            ev.preventDefault();

            var current_selected = '';

            $('input[name="markets[]"]:checked').each(function() {
                var current = $(this).val();

                var arr = users_markets.split(',');

                if ($.inArray(current, arr) < 0) {
                    users_markets += current + ",";
                    $('#marketsbyuser').val(users_markets);
                }

                current_selected = users_markets;
            });

            if (current_selected == '') {
                users_markets = '';
            }

            var checkboxValues = users_markets.substring(0, users_markets.length-1);
            $('#marketsbyuser').val(checkboxValues);
            $('#modalMarket').modal('hide');
        });
    });

    /* Se cierra la ventana y se envia al formulario principal los elementos seleccionados */
    $('#modalStation').on('show.bs.modal', function () {
        $('a[id=save_stationsPermissions]').click(function(ev) {
            ev.preventDefault();

            var current_selected = '';

            $('input[name="stations[]"]:checked').each(function() {
                var current = $(this).val();

                var arr = users_stations.split(',');

                if ($.inArray(current, arr) < 0) {
                    users_stations += current + ",";
                    $('#stationsbyuser').val(users_stations);
                }

                current_selected = users_stations;
            });

            if (current_selected == '') {
                users_stations = '';
            }

            var checkboxValues = users_stations.substring(0, users_stations.length-1);
            $('#stationsbyuser').val(checkboxValues);
            $('#modalStation').modal('hide');
        });
    });

    /* Pagination */
    $(document).on("click", "#listUsers .pagination a", function(e){
        e.preventDefault();

        var url = $(this).attr("href");

        $.ajax({
            url: url,
            success: function (data) {
                $('#listUsers').html(data);
            }
        });

    });

    /* Buscador pagina principal */
    $(document).on("click", "#buttonSearchUser", function(e){
        e.preventDefault();

        var $form = $('#searchuser');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#listUsers').html(data);
            }
        });
    });

});

