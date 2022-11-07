$(document).ready(function() {

    $('#main_form_check').change(function(){
        if(this.checked) {
            $('.table-checkbox').prop('checked', true);
            $('#delete_btn').removeClass('d-none');
            $('#add_btn').addClass('d-none');
        }else{
            $('.table-checkbox').prop('checked', false);
            $('#delete_btn').addClass('d-none');
            $('#add_btn').removeClass('d-none');
        }
        var numberOfChecked = $('.table-checkbox:checked').length;
        $('#selected_count').html(numberOfChecked);
    });

    $('.table-checkbox').change(function(){
        var numberOfChecked = $('.table-checkbox:checked').length;
        if(this.checked) {
            $('#delete_btn').removeClass('d-none');
            $('#add_btn').addClass('d-none');
        }else{
            if(numberOfChecked == 0){
                $('#delete_btn').addClass('d-none');
                $('#add_btn').removeClass('d-none');
            }
        }
        numberOfChecked = $('.table-checkbox:checked').length;
        $('#selected_count').html(numberOfChecked);
    });

});