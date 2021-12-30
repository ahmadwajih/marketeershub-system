
/*
"use strict";

// Class definition
var MHWidgets = function () {
    // Private properties

    var css = function (el, styleProp, value) {
        if (!el) {
            return;
        }

        if (value !== undefined) {
            el.style[styleProp] = value;
        } else {
            var defaultView = (el.ownerDocument || document).defaultView;
            // W3C standard way:
            if (defaultView && defaultView.getComputedStyle) {
                // sanitize property name to css notation
                // (hyphen separated words eg. font-Size)
                styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
                return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
            } else if (el.currentStyle) { // IE
                // sanitize property name to camelCase
                styleProp = styleProp.replace(/\-(\w)/g, function (str, letter) {
                    return letter.toUpperCase();
                });
                value = el.currentStyle[styleProp];
                // convert other units to pixels on IE
                if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                    return (function (value) {
                        var oldLeft = el.style.left,
                            oldRsLeft = el.runtimeStyle.left;
                        el.runtimeStyle.left = el.currentStyle.left;
                        el.style.left = value || 0;
                        value = el.style.pixelLeft + "px";
                        el.style.left = oldLeft;
                        el.runtimeStyle.left = oldRsLeft;
                        return value;
                    })(value);
                }
                return value;
            }
        }
    };

    var _chart_offersMarketShare = function () {
        var element = document.getElementById("chartOfferMarketShare");
        var height = parseInt(css(element, 'height'));

        if (!element) {
            return;
        }

        var options = {
            series: [44, 55, 13, 43, 22],
            chart: {
                width: 380,
                height: height,
                type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    // Public methods
    return {
        init: function () {
            _chart_offersMarketShare();
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined') {
    module.exports = MHWidgets;
}

jQuery(document).ready(function () {
    MHWidgets.init();
});
*/
