/**
 * Created by cesarurdaneta on 01/28/15.
 */
$(document).ready(function() {
	
	
	$('#datePicker')
	    .on('dp.change dp.show', function(e) {
	        // Revalidate the date field
	        $('#frmAlbum').bootstrapValidator('revalidateField', 'imgurcreationdate');
	    });

	
	
	$('#frmAlbum')
        .bootstrapValidator({
            excluded: ':disabled',
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                idstation: {
                    validators: {
                        notEmpty: {
                            message: 'Deve selecionar uma Emissora.'
                        }
                    }
                },
                idmarket: {
                    validators: {
                        notEmpty: {
                            message: 'Deve selecionar um Mercado / Setor.'
                        }
                    }
                },
                imguralbum: {
                    validators: {
                        notEmpty: {
                            message: 'Código Album Imgur não dever ter valor vazío'
                        }
                    }
                },
                imgurcreationdate:{
                	validators: {
                        notEmpty: {
                            message: 'Data Album Imgur não dever ter valor vazío'
                        },
	                    date: {
	                        format: 'DD/MM/YYYY',
	                        message: 'Formato de data não é válido. Deve colocar valor no formato dd/mm/yyyy'
	                    }
                    }
                }
            }
        })
        .find('[name="idstation"]')
            .selectpicker()
            .change(function(e) {
                // revalidate the station when it is changed
                $('#frmAlbum').bootstrapValidator('revalidateField', 'idstation');                
            })
            .end()
        .find('[name="idmarket"]')
            .selectpicker()
            .change(function(e) {
                // revalidate the market when it is changed
                $('#frmAlbum').bootstrapValidator('revalidateField', 'idmarket');
            })
            .end()
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
                    
                    var json = $.parseJSON(data);
                    var cad = json.msg;

                    var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf('albums_assoc'));
                    var newUrl = baseURL + 'dashboard/view/albums_assoc/';

                    if (json.result) {
                        bootbox.dialog({
                            message: cad,
                            title: "Associação de Album",
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

                        $('#frmAlbum').data('bootstrapValidator').resetForm(true);

                    } else {
                        bootbox.dialog({
                            message: cad,
                            title: "Associação de Album",
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

    /* Pagination */
    $(document).on("click", "#listAlbums .pagination a", function(e){
        e.preventDefault();

        var url = $(this).attr("href");

        $.ajax({
            url: url,
            success: function (data) {
                $('#listAlbums').html(data);
            }
        });

    });

    /* Buscador pagina principal */
    $(document).on("click", "#buttonSearchAlbum", function(e){
        e.preventDefault();

        var $form = $('#frmAlbumSearch');

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $form.serialize(),
            success: function (data) {
                $('#listAlbums').html(data);
            }
        });
    });
});


