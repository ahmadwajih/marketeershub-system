$("#old_new_payout_date_range").fadeOut("fast");
$("#old_new_payout_orders_range").fadeOut("fast");
$("#old_new_payout_countries").fadeOut("fast");

// CPS old_new static
$("#cps_old_new_payout_static").on("change", function () {
    enableThisAndDisableOthersPayoutOldNewMethod("#cps_old_new_payout_static", "#old_new_payout_static")
});

// CPS old_new date range
$("#cps_old_new_payout_date_range").on("change", function () {
    enableThisAndDisableOthersPayoutOldNewMethod("#cps_old_new_payout_date_range", "#old_new_payout_date_range")
});

// CPS old_new orders range
$("#cps_old_new_payout_orders_range").on("change", function () {
    enableThisAndDisableOthersPayoutOldNewMethod("#cps_old_new_payout_orders_range", "#old_new_payout_orders_range")
});

// CPS old_new countries
$("#cps_old_new_payout_countries").on("change", function () {
    enableThisAndDisableOthersPayoutOldNewMethod("#cps_old_new_payout_countries", "#old_new_payout_countries")
});

function enableThisAndDisableOthersPayoutOldNewMethod(checkBoxId, formId) {
    if ($(checkBoxId).val() == "on") {
        $(checkBoxId).val("off");
        $(checkBoxId).prop("checked", false);
        $(formId).fadeOut("slow");

    }else if ($(checkBoxId).val() == "off") {
        $(checkBoxId).val("on");
        $(checkBoxId).prop("checked", true);
        $(formId).fadeIn("slow");

    }
}
