function customAlert(str, sev = 0, onRemove = function(e) {}) {


    combinedHeight = 0;
    let alertCount = 1;
    jQuery.each(jQuery(".customAlert"), function (a, b) {
        combinedHeight += jQuery(this)[0].offsetHeight;
        alertCount++;
    });

    switch (sev) {
        case 1:
            alert_type = '-success';

            bef = 'Success!';
            break;
        case 2:
            alert_type = '-warning';

            bef = 'Warning!';
            break;
        default:
            alert_type = '-danger';

            bef = 'Error!';
            break;
    }

    fromTopDe = combinedHeight + (alertCount * 15);
    addAlert = "<div id='customAlert_" + alertCount + "' class='customAlert alert alert" + alert_type + "' style='top:" + fromTopDe + "px;' role='alert'><strong>" + bef + "</strong> " + str + "<div class='fa fa-times customAlert_X' onclick='removeCustomAlert(" + alertCount + ")'></div></div>";
    jQuery('body').append(addAlert);

    setTimeout(function () {
        removeCustomAlert(alertCount, onRemove);
    }, 3000);
}

function removeCustomAlert(alertId, onRemove = function(e) {}) {

    if (jQuery("#customAlert_" + alertId).html() !== undefined) {

        jQuery.each(jQuery(".customAlert"), function (a, b) {
            getSplitId = jQuery(b).attr("id").split("customAlert_");

            if (alertId < getSplitId[1]) {
                newTop = parseInt(jQuery(b).css("top").slice(0, -2)) - jQuery("#customAlert_" + alertId)[0].offsetHeight - 15;
                jQuery(b).animate({
                    top: newTop
                });
            }
        });

        jQuery("#customAlert_" + alertId).fadeOut(function () {
            jQuery("#customAlert_" + alertId).remove();

            onRemove();
            //window[onRemove]();
        });
}
}
