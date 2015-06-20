/**
 * Created by upcesar on 05/01/15.
 */
$(document).ready(function() {

    /*
        When clink on Edit Link
     */

    jQuery.fn.extend({
            initEdit: function (editAll) {
                var formId = "#form-" + $(this).attr('id');
                var currentField = "#current-" + $(this).attr('id').replace('edit-','');
                var buttonSet = ".btn-" + $(this).attr('id');

                var inputField = "#input" + $(this).attr('id').replace('edit-','');
                $("#chooser-profile-picture").addClass('hide');
                $(".edit-area").addClass("hide");
                $("#campaignContribArea").addClass("hide");


                $(currentField).addClass("hide");
                $(formId).removeClass("hide");
                $(buttonSet).removeClass("hide");

                if($(inputField).is('input') | $(inputField).is('textarea')){
                    $(inputField).val($(currentField).text().trim());
                }

                // Set focus to current control when editing only this field.
                
                editAll = typeof editAll !== 'undefined' ? editAll : false;

                $(".contribution-log").addClass('contribution-log-add-edit');

                if(editAll === false){
                    $(inputField).select();
                    $(inputField).focus();
                    $(".edit-all-campaign-area").addClass("hide");
                }
            },
            saveEdit: function () {
                var currentField = "#" + $(this).attr('id').replace('save-','current-');
                var formId = "#" + currentField.replace('#current-','form-edit-');
                var formValidation = $(currentField).parents('form');
                var inputField = "#input" + $(this).attr('id').replace('save-','');

                var url = '';
                var controllerInput = $(inputField).data('controller');
                var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf( $('#controllername').val() ));

                url = baseURL + controllerInput + '/update-field/';

                //Disabling button and show Loading
                var loadingImg = baseURL + 'assets/img/img-loading.gif';
                var savingMsg = '<span id = "label-msg-saving"> ' +
                                    '<img src="'+loadingImg+'"> ' +
                                        'Salvando, aguarde...'+
                                '</span>';

                // Get value with or witout currency format, according class element.
                var fieldValue = $(inputField).hasClass('currency') ?
                                    $(inputField).autoNumeric('get') :
                                    $(inputField).val();


                $(inputField).after(savingMsg);

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        record_id : $(".pk_field").val(),
                        fieldName: $(inputField).data("db-field"),
                        value: fieldValue,
                    },
                    success: function(data) {
                        var json = $.parseJSON(data);
                        var msgType = json.result ? "label-success" : "label-danger";

                        var label = '<span id = "label-msg-save" class="label ' + msgType + ' centered" style="display:none">' + json.msg + '</span>';

                        if(json.result){

                            if($(inputField).hasClass('currency')){
                                $(currentField+">span").autoNumeric('set',json.new_value);
                            }
                            else{
                                $(currentField).html(json.new_value);
                            }

                            $(currentField).after(label);
                            $(currentField).cancelEdit();
                        }
                        else{
                            $(inputField).after(label);
                        }

                        $("#label-msg-save").fadeIn('fast');

                        $("#label-msg-save").fadeOut(1500, function() {
                            // Destroy the message in the DOM
                            $(this).remove();
                            $("#label-msg-saving").remove();
                        });

                    }
                });
            },
            cancelEdit: function () {
                var currentField = "#" + $(this).attr('id').replace('cancel-edit-','current-');
                var formId = "#" + currentField.replace('#current-','form-edit-');
                var formValidation = $(currentField).parents('form');
                var inputField = "#input" + $(this).attr('id').replace('cancel-edit-','');
                var buttonSet = ".btn-" + $(this).attr('id').replace('cancel-','');

                $(formValidation).data('bootstrapValidator').resetForm(true);
                $(formId).blur();
                $(formId).addClass("hide");
                $(".edit-area").removeClass("hide");
                $("#campaignContribArea").removeClass("hide");
                $(".edit-all-campaign-area").removeClass("hide");
                $(currentField).removeClass("hide");
                $("#boxCampaignFullPicture").removeClass('hide');
                $(buttonSet).addClass("hide");
                $(".file-selector").removeClass('hide');
                $(".file-selector").val('');
                $(".contribution-log").removeClass('contribution-log-add-edit');
                
                if($(inputField).is('img')){
                    $(inputField).attr("src","");
                }
            },
            
            previewImage:function(e, elementID){

                var preview = document.getElementById(elementID);
                var file    = document.getElementById($(this).attr('id')).files[0];
                var reader  = new FileReader();

                reader.onloadend = function () {
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                    $("#boxCampaignFullPicture").addClass('hide');
                } else {
                    preview.src = "";
                }

             },

            selectText: function (element) {
                var doc = document
                    , text = doc.getElementById(element)
                    , range, selection
                ;
                if (doc.body.createTextRange) {
                    range = document.body.createTextRange();
                    range.moveToElementText(text);
                    range.select();
                } else if (window.getSelection) {
                    selection = window.getSelection();
                    range = document.createRange();
                    range.selectNodeContents(text);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            },
            
            doAction:function(method){

                var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf( $('#controllername').val() ));
                var msgWarning = '';


                // Stop saving when error exists.
                if($('.has-error').length > 0){
                    return;
                }

                if(method.toLowerCase() =='edit' | method.toLowerCase() =='addnew'){
                    execAction = '/save/';
                    msgWarning = 'Salvar esta campanha de presentes?';
                }
                else{
                    execAction = '/delete/';
                    msgWarning = 'Tem certeza de deletar esta campanha de presentes?';
                }

                $("#form-campaigns").attr('action',baseURL+$('#controllername').val() + execAction);

                console.log($("#form-campaigns"));

                bootbox.confirm({
                    title: 'Alerta!!!',
                    message: msgWarning,
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

                            $("#form-campaigns").bootstrapValidator('destroy');
                            $("#hiddenCampPriceAmount").val($("#inputCampPriceAmount").autoNumeric('get'));
                            $("#form-campaigns").submit(); //Delete record

                        }
                        else{

                        }
                    }
                });

            }

    });

    $(document).on("click", ".link-edit-camp", function(ev){
        ev.preventDefault();
        $(this).initEdit();
        $(".camp-image-edit-area").addClass('hide');
    });

    $(document).on("click", ".btn-cancel-edit", function(ev){
        ev.preventDefault();
        $("#inputCampOwnerPhoto").attr('src', '');
        $(this).cancelEdit();
        $(".camp-image-edit-area").removeClass('hide');
    });

    $(document).on("click", ".btn-save", function(ev){
        ev.preventDefault();
        $(this).saveEdit();
    });

    /*
    $(document).on("click", ".btn-save-img", function(ev){
        ev.preventDefault();

        var formData2 = new FormData($("#imgUploadFullPicture")[0]);

        $("#imgUploadFullPicture").submit(function() {

            var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf( $('#controllername').val() ));
            var urlSaveImg = baseURL + $('#controllername').val() + "/save-img";

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    alert(data);
                }
            });

            return false;
        });
    });
    */


    

    /* Show profile picture from client machine before uploading */

    $("#edit-CampOwnerPhoto").change(function(e) {
         $(this).previewImage(e, "inputCampOwnerPhoto");
         $(this).initEdit();

    });

    $("#edit-CampaignFullPicture").change(function(e) {
         $(this).previewImage(e, "inputCampaignFullPicture");
         $(".contribution-log").addClass('contribution-log-add-edit');
         $(this).initEdit();
    });

    $("#select-short-url").click(function(e) {
        e.preventDefault();
        $(this).selectText("short-url-text");
    });

    $("#btnEditAllCampaign").click(function(e) {
        e.preventDefault();
        $(".edit-all-campaign-idle").addClass('hide');
        $(".edit-all-campaign-inprogress").removeClass('hide');
        $(".buttonset-field-campaign").addClass('hide');
        $("#inputCampPriceAmount").removeClass('camp-price-amount-inline');
        $("#CampPriceAmountGroup").addClass('camp-price-amount-block');
        $(".camp-image-edit-area").addClass('hide');

        //Shows all for editing
        $(".link-edit-camp").each(function(){
            $(this).initEdit(true);
        });
    });

    $("#cancel-edit-AllCampaign").click(function(e) {
        e.preventDefault();
        $(".edit-all-campaign-idle").removeClass('hide');
        $(".edit-all-campaign-inprogress").addClass('hide');
        $(".buttonset-field-campaign").removeClass('hide');
        $("#inputCampPriceAmount").addClass('camp-price-amount-inline');
        $("#CampPriceAmountGroup").removeClass('camp-price-amount-block');
        $(".camp-image-edit-area").removeClass('hide');

        //Cancel editing for all controls
        $(".btn-cancel-edit").each(function(){
            $(this).cancelEdit(true);
        });
    });

    $("#btnDelAllCampaign").click(function(e) {
        e.preventDefault();
        $(this).doAction('delete');
    });

    $("#saveAllCampaign").click(function(e) {
        e.preventDefault();
        $(this).doAction('edit');
    });

    $("#saveNewCampaign").click(function(e) {
        e.preventDefault();
        $("#form-campaigns").data('bootstrapValidator').validate();

        $(this).doAction('addnew');
    });

    /*  Currency format for campaign price and campaign contributions
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

    /*  Currency format for campaign price and campaign contributions (END)
        *****************************
    */



    

});

