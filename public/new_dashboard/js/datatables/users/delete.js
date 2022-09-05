"use strict";
var itemId = '';
function deleteItem(id){
    itemId = id;

    Swal.fire({
        title: 'هل انت متأكد؟',
        text: "لن تتمكن من التراجع عن هذا!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'إلغاء',
        confirmButtonText: 'نعم احذف!'
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: route+'/'+itemId,
                data: {
                    "_token": csrfToken,
                    "_method": "DELETE",
                    id: itemId
                }, 
            })
            .done(function(res) {
                $("#kt_table_users").DataTable().ajax.reload();
            })
            .fail(function(res) { 
                resolve('{{ __("Error!") }}');
            });

          Swal.fire(
            'تم الحذف.',
            'تم حذف العنصر',
            'success'
          )
        }
      })
}