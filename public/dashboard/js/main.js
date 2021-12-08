(function ($) {

    var mh = {

        table: $('#publisherTable'),
        column: $('.toggle-column'),


        init: function () {
            $('.btn-light').on('click', mh.toggleDropdown)
            mh.column.on('change', mh.toggleColumn);
            mh.eachColumn()

            $('#promoted').on('change', function () {
                $('.promoted-container').removeClass('d-none');
                $('.promoted-container').toggle('slow');
            });
        },

        toggleColumn: function(event) {
            event.preventDefault();
            mh.dataColumn($(event.target));
        },

        eachColumn: function(){
            var table = mh.table.DataTable(),
                elem = '', column = '';
            mh.column.each(function (i) {
                elem = mh.column[i];
                column = table.column(elem.value + ':name');
                if (elem.checked) {
                    column.visible(false);
                } else {
                    column.visible(true);
                }
            })
        },

        dataColumn: function (elem) {
            var table = mh.table.DataTable(),
                column = table.column(elem.val() + ':name');
            if (elem.prop('checked')) {
                column.visible(false);
            } else {
                column.visible(true);
            }
        },

        toggleDropdown: function (event) {
            var $next = this.next();
            if ($next.hasClass('show')) {
                $next.show()
                event.stopPropagation();
                event.preventDefault();
            } else {
                $next.hide();
            }
        }
    }

    $(document).ready(function () {
        mh.init();
    })
    .on('click', '.card-header .dropdown-menu', function (e) {
        e.stopPropagation();
    });

})(jQuery);
