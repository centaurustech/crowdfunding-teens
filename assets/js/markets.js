/**
 * Created by rosaeliana on 15/01/15.
 */
$(document).ready(function() {
    var users_markets = '';
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
                                className: "btn-success"
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

    /* Validacion formulario de mercados */
    $('#formMarket')
        .bootstrapValidator({
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                marketname: {
                    validators: {
                        notEmpty: {
                            message: 'Mercado não deve estar vazio'
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

                    var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('markets'));
                    var newUrl = baseURL + 'dashboard/view/markets/';

                    if (flag == '1') {
                        bootbox.dialog({
                            message: cad,
                            title: "Mercado",
                            buttons: {
                                success: {
                                    label: "Fechar",
                                    className: "btn-success",
                                    callback: function() {
                                        $(location).attr('href',newUrl);
                                    }
                                }
                            }
                        });

                        $('#formMarket').data('bootstrapValidator').resetForm(true);

                    } else if (flag == 0) {
                        bootbox.dialog({
                            message: cad,
                            title: "Mercado",
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

    /* Llamado de ventana con listado de usuarios */
    $('button#users_markets').click(function(ev) {
        ev.preventDefault();
        var url = $(this).attr("data-info");

        var userselected = $('#usersbymarket').val();
        var datauser = 'userselected=' + userselected;

        $.ajax({
            url: url,
            type: 'post',
            data: datauser,
            success: function (data) {
                $('#body_modal').html(data);
            }
        });

        $('#myModalUsers').modal({show:true});
    });

    /* Manejo de busqueda */
    $(document).on("click", "#search_user_modal", function(e){
        e.preventDefault();

        var $form = $('#searchusermodal');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#body_modal').html(data);
            }
        });
    });

    /* Se cierra la ventana y se envia al formulario principal los elementos seleccionados */
    $('#myModalUser').on('show.bs.modal', function () {
        $('a[id=save_usersPermissions]').click(function(ev) {
            ev.preventDefault();

            var current_selected = '';

            $('input[name="users[]"]:checked').each(function() {
                var current = $(this).val();

                var arr = users_markets.split(',');

                if ($.inArray(current, arr) < 0) {
                    users_markets += current + ",";
                    $('#usersbymarket').val(users_markets);
                }

                current_selected = users_markets;
            });

            if (current_selected == '') {
                users_markets = '';
            }

            var checkboxValues = users_markets.substring(0, users_markets.length-1);
            $('#usersbymarket').val(checkboxValues);
            $('#myModalUser').modal('hide');
        });
    });

    /* Pagination */
    $(document).on("click", "#listMarkets .pagination a", function(e){
        e.preventDefault();

        var url = $(this).attr("href");

        $.ajax({
            url: url,
            success: function (data) {
                $('#listMarkets').html(data);
            }
        });

    });

    /* Buscador pagina principal */
    $(document).on("click", "#buttonSearchMarket", function(e){
        e.preventDefault();

        var $form = $('#searchmarket');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#listMarkets').html(data);
            }
        });
    });
});

