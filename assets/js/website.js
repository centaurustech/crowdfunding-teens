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
            cancelEdit: function () {
                var currentField = "#" + $(this).attr('id').replace('cancel-edit-','current-');
                var formId = "#" + currentField.replace('#current-','form-edit-');
                $(formId).blur();
                $(formId).addClass("hide");
                $(".edit-area").removeClass("hide");
                $(currentField).removeClass("hide");
                $("#chooser-profile-picture").removeClass('hide');
                $("#edit-camp-owner-photo").val('');
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
        $("#edit-CampOwnerPhoto").val('');
        $("#inputCampOwnerPhoto").attr('src', '');
        $(this).cancelEdit();
    });


    /* Show profile picture from client machine before uploading */

    
    $("#edit-CampOwnerPhoto").change(function(e) {

         for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
             var file = e.originalEvent.srcElement.files[i];
             var reader = new FileReader();
             reader.onloadend = function() {
                  $("#inputCampOwnerPhoto").attr('src', reader.result);
             }
             reader.readAsDataURL(file);
         }

         $(this).initEdit();

     });
    

    $("#select-short-url").click(function(e) {
        e.preventDefault();
        $(this).selectText("short-url-text");
    });


});

