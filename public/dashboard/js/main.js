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

        toggleColumn: function (event) {
            event.preventDefault();
            mh.dataColumn($(event.target));
            // var val = event.target.value;
            //  mh.columns('set', [{key:val}])
        },

        /*
        columns: function(type, data){
            if (type === 'set') {
                var getS = localStorage.getItem('pub_cols');
                console.log(JSON.parse(getS))
                data = (Object.keys(getS).length > 0) ? JSON.parse(getS).push(data) : data;
                localStorage.setItem('pub_cols', JSON.stringify(data));
            } else {
                return localStorage.getItem('pub_cols') ? JSON.parse(localStorage.getItem('pub_cols')) : [];
            }
        },
        */

        eachColumn: function () {
            var table = mh.table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: $(mh.table).data('action'),
                    //columns: {!! json_encode($columns) !!}
                    "initComplete": function( settings, json ) {
                       $('.table-loading').removeClass('table-loading')
                    }
                }),
                elem = '',
                column = '';
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
    }).on('click', '.card-header .dropdown-menu', function (e) {
        e.stopPropagation();
    });

})(jQuery);
