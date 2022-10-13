const editSelected = document.querySelector('[data-kt-user-table-select="edit_selected"]');
if (editSelected) {
     
    // Deleted selected rows
    editSelected.addEventListener("click", function () {
       

        
        // append checkboxes
        var checkBoxes = '';
        $('input[name="item_check"]:checked').each(function (index) {
             checkBoxes  = checkBoxes + '<input class="d-none" name="item_check[]" type="checkbox" checked value="'+this.value+'">';
        });
        console.log(checkBoxes);

        $('#bulk_edit_coupon_form').append(checkBoxes);
        $('#bulk_edit_coupon_form').submit();

        
    });
}
