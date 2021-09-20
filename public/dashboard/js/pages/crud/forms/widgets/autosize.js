// Class definition

var KTAutosize = function () {

    // Private functions
    var demos = function () {

        var demo1 = $('#kt_autosize_1');
        var demo2 = $('#kt_autosize_2');
        var demo3 = $('#kt_autosize_3');
        var demo4 = $('#kt_autosize_4');

        autosize(demo1);
        autosize(demo2);
        autosize(demo3);
        autosize(demo4);

    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTAutosize.init();
});
