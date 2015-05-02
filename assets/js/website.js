/**
 * Created by rosaeliana on 15/01/15.
 */
$(document).ready(function() {
    var users_stations = '';

    $("#search-icon").click(function(e){
            e.preventDefault();
            if($(".bubble").hasClass('hide-search')){
                $(".bubble").removeClass('hide-search');
            }
            else{
            	$(".bubble").addClass('hide-search');
            }
    });
});

