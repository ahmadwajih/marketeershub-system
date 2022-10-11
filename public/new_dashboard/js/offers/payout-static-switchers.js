$("#static_payout_date_range").fadeOut("fast");
$("#static_payout_orders_range").fadeOut("fast");
$("#static_payout_countries").fadeOut("fast");

// CPS static static
$("#cps_static_payout_static").on("change", function () {
    enableThisAndDisableOthersPayoutStaticMethod("#cps_static_payout_static", "#static_payout_static")
});

// CPS static date range
$("#cps_static_payout_date_range").on("change", function () {
    enableThisAndDisableOthersPayoutStaticMethod("#cps_static_payout_date_range", "#static_payout_date_range")
});

// CPS static orders range
$("#cps_static_payout_orders_range").on("change", function () {
    enableThisAndDisableOthersPayoutStaticMethod("#cps_static_payout_orders_range", "#static_payout_orders_range")
});

// CPS static countries
$("#cps_static_payout_countries").on("change", function () {
    enableThisAndDisableOthersPayoutStaticMethod("#cps_static_payout_countries", "#static_payout_countries")
});

function enableThisAndDisableOthersPayoutStaticMethod(checkBoxId, formId) {
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
