$("#static_revenue_date_range").fadeOut("fast");
$("#static_revenue_orders_range").fadeOut("fast");
$("#static_revenue_countries").fadeOut("fast");

// CPS static static
$("#cps_static_revenue_static").on("change", function () {
    enableThisAndDisableOthersForRevenueStaticMethod("#cps_static_revenue_static", "#static_revenue_static");
});

// CPS static date range
$("#cps_static_revenue_date_range").on("change", function () {
    enableThisAndDisableOthersForRevenueStaticMethod("#cps_static_revenue_date_range", "#static_revenue_date_range");
});

// CPS static orders range
$("#cps_static_revenue_orders_range").on("change", function () {
    enableThisAndDisableOthersForRevenueStaticMethod("#cps_static_revenue_orders_range", "#static_revenue_orders_range");
});

// CPS static countries
$("#cps_static_revenue_countries").on("change", function () {
    enableThisAndDisableOthersForRevenueStaticMethod("#cps_static_revenue_countries", "#static_revenue_countries");
});

function enableThisAndDisableOthersForRevenueStaticMethod(checkBoxId, formId) {
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
