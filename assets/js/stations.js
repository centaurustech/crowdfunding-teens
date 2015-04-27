/**
 * Created by rosaeliana on 15/01/15.
 */
$(document).ready(function() {
    var users_stations = '';

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

    /* Validacion formulario de emisoras */
    $('#formStation')
        .bootstrapValidator({
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                stationname: {
                    validators: {
                        notEmpty: {
                            message: 'Emissora não deve estar vazio'
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

                    var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('stations'));
                    var newUrl = baseURL + 'dashboard/view/stations/';


                    if (flag == '1') {
                        bootbox.dialog({
                            message: cad,
                            title: "Emissoras",
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
                            title: "Emissoras",
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
    $('button#users_stations').click(function(ev) {
        ev.preventDefault();
        var url = $(this).attr("data-info");

        var userselected = $('#usersbystation').val();
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

                var arr = users_stations.split(',');

                if ($.inArray(current, arr) < 0) {
                    users_stations += current + ",";
                    $('#usersbystation').val(users_stations);
                }

                current_selected = users_stations;
            });

            if (current_selected == '') {
                users_stations = '';
            }

            var checkboxValues = users_stations.substring(0, users_stations.length-1);
            $('#usersbystation').val(checkboxValues);
            $('#myModalUser').modal('hide');
        });
    });

    /* Pagination */
    $(document).on("click", "#listStations .pagination a", function(e){
        e.preventDefault();

        var url = $(this).attr("href");

        $.ajax({
            url: url,
            success: function (data) {
                $('#listStations').html(data);
            }
        });

    });

    /* Buscador pagina principal */
    $(document).on("click", "#buttonSearchStation", function(e){
        e.preventDefault();

        var $form = $('#searchstation');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#listStations').html(data);
            }
        });
    });
});

