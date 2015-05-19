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
                var inputField = "#input" + $(this).attr('id').replace('edit-','');
                $("#chooser-profile-picture").addClass('hide');
                $(".edit-area").addClass("hide");
                $(currentField).addClass("hide");
                $(formId).removeClass("hide");

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

                var url = window.location.href.replace('/details/','/save/');

                $.ajax({
                    url: url,
                    type: 'post',
                    data: { 
                        record_id : $(".pk_field").val(),
                        fieldName: $(inputField).data("db-field"),
                        value: $(inputField).val() 
                    },
                    success: function(data) {
                        var json = $.parseJSON(data);
                        var msgType = json.result ? "label-success" : "label-danger";

                        var label = '<span id = "label-msg-save" class="label ' + msgType + ' centered" style="display:none">' + json.msg + '</span>';
                        
                        if(json.result){
                            $(currentField).html(json.new_value);
                            $(currentField).after(label);
                            $(".btn-cancel-edit").cancelEdit();
                        }
                        else{
                            $(inputField).after(label);
                        }

                        $("#label-msg-save").fadeIn('fast');

                        $("#label-msg-save").fadeOut(1500, function() {
                            // Destroy the message in the DOM
                            $(this).remove();
                            
                        });


                        

                    }
                });
            },
            cancelEdit: function () {
                var currentField = "#" + $(this).attr('id').replace('cancel-edit-','current-');
                var formId = "#" + currentField.replace('#current-','form-edit-');
                var formValidation = $(currentField).parents('form');
                var inputField = "#input" + $(this).attr('id').replace('cancel-edit-','');

                $(formValidation).data('bootstrapValidator').resetForm(true);
                $(formId).blur();
                $(formId).addClass("hide");
                $(".edit-area").removeClass("hide");
                $(currentField).removeClass("hide");
                $(".file-selector").removeClass('hide');
                $(".file-selector").val('');
                
                if($(inputField).is('img')){
                    $(inputField).attr("src","");
                }
            },
            
            previewImage:function(e, selector){

                for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                     var file = e.originalEvent.srcElement.files[i];
                     var reader = new FileReader();
                     reader.onloadend = function() {
                          $(selector).attr('src', reader.result);
                     }
                     reader.readAsDataURL(file);
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


    

    /* Show profile picture from client machine before uploading */

    $("#edit-CampOwnerPhoto").change(function(e) {

         $(this).previewImage(e, "#inputCampOwnerPhoto");
         $(this).initEdit();

    });

    $("#edit-CampaignFullPicture").change(function(e) {

         $(this).previewImage(e, "#inputCampaignFullPicture");
         $(this).initEdit();

    });

    $("#select-short-url").click(function(e) {
        e.preventDefault();
        $(this).selectText("short-url-text");
    });


});

