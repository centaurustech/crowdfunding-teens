/**
 * Created by upcesar on 05/01/15.
 */
$(document).ready(function() {

    /*
        When clink on Edit Link
     */

    jQuery.fn.extend({
            initEdit: function () {
                var formId = "#form-" + $(this).attr('id');
                var currentField = "#current-" + $(this).attr('id').replace('edit-','');
                var buttonSet = ".btn-" + $(this).attr('id');

                var inputField = "#input" + $(this).attr('id').replace('edit-','');
                $("#chooser-profile-picture").addClass('hide');
                $(".edit-area").addClass("hide");
                $(currentField).addClass("hide");
                $(formId).removeClass("hide");
                $(buttonSet).removeClass("hide");

                if($(inputField).is('input') | $(inputField).is('textarea')){
                    $(inputField).val($(currentField).text().trim());
                }

                $(inputField).select();
                $(inputField).focus();

            },
            saveEdit: function () {
                var currentField = "#" + $(this).attr('id').replace('save-','current-');
                var formId = "#" + currentField.replace('#current-','form-edit-');
                var formValidation = $(currentField).parents('form');
                var inputField = "#input" + $(this).attr('id').replace('save-','');

                var url = '';
                var controllerInput = $(inputField).data('controller');
                var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf( $('#controllername').val() ));

                url = baseURL + controllerInput + '/save/';

                //Disabling button and show Loading
                var loadingImg = baseURL + 'assets/img/img-loading.gif';
                var savingMsg = '';
                savingMsg = '<span id = "label-msg-saving"> ' +
                                '<img src="'+loadingImg+'"> ' +
                                    'Salvando, aguarde...'+
                                '</span>';

                $(inputField).after(savingMsg);

                $.ajax({
                    url: url,
                    type: 'post',
                    data: { 
                        record_id : $(".pk_field").val(),
                        fieldName: $(inputField).data("db-field"),
                        value: $(inputField).val(),
                    },
                    success: function(data) {
                        var json = $.parseJSON(data);
                        var msgType = json.result ? "label-success" : "label-danger";

                        var label = '<span id = "label-msg-save" class="label ' + msgType + ' centered" style="display:none">' + json.msg + '</span>';
                        
                        if(json.result){
                            $(currentField).html(json.new_value);
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
                $(currentField).removeClass("hide");
                $(buttonSet).addClass("hide");
                $(".file-selector").removeClass('hide');
                $(".file-selector").val('');
                
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
            }

    });

    $(document).on("click", ".link-edit", function(ev){
        ev.preventDefault();
        $(this).initEdit();
    });

    $(document).on("click", ".btn-cancel-edit", function(ev){
        ev.preventDefault();
        $("#inputCampOwnerPhoto").attr('src', '');
        $(this).cancelEdit();
    });

    $(document).on("click", ".btn-save", function(ev){
        ev.preventDefault();
        $(this).saveEdit();
    });

    $(document).on("click", ".btn-save-img", function(ev){
        ev.preventDefault();

        var formData2 = new FormData($("#imgUploadFullPicture")[0]);

        $("#imgUploadFullPicture").submit(function() {
            
            var baseURL = document.URL.toLowerCase().substr(0,document.URL.indexOf( $('#controllername').val() ));
            var urlSaveImg = baseURL + $('#controllername').val() + "/save_img";

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


    

    /* Show profile picture from client machine before uploading */

    $("#edit-CampOwnerPhoto").change(function(e) {

         $(this).previewImage(e, "inputCampOwnerPhoto");
         $(this).initEdit();

    });

    $("#edit-CampaignFullPicture").change(function(e) {

         $(this).previewImage(e, "inputCampaignFullPicture");
         $(this).initEdit();

    });

    $("#select-short-url").click(function(e) {
        e.preventDefault();
        $(this).selectText("short-url-text");
    });


});

