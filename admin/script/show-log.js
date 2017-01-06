$(document).ready(function() {

    // ==========================================
    //               Info popup
    // ==========================================
    
    $("#loader").fadeOut(200, function() { infoPopup( message, icon ); });
    $("#popup_container").delay(200).fadeIn(500);
    
    $("button.cancel").click(function() {
        $("#page_fader, #popup_container").fadeOut(500);
        setTimeout(function() { location.href = "index.php"; }, 500);
        $(this).blur();
        return false;
    });

});