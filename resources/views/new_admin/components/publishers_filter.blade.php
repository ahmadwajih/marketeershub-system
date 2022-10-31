<!--begin::Input group-->
<div class="mb-10 fv-row">
    <!--begin::Label-->
    <label class="form-label">Publisher Search</label>
    <input type="text" class="form-control mb-3 publisher_input" name="publisher" placeholder="Name or Email"
        aria-label="Search" aria-describedby="basic-addon2" value="" />
</div>
@push('scripts')
    <script>
        // get countries based on country
        $(".publisher_input").keyup(function() {
            if ($(this).val().length > 3) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.get({
                    url: '{{ route('admin.ajax.publishers.search') }}',
                    data: {
                        publisher_input: $(this).val(),
                    },
                    beforeSend: function() {
                        $('#loading').show()
                    },
                    success: function(data) {
                        console.log(data);
                        $('.publishers_filter').html(data)
                    },
                    complete: function() {
                        $('#loading').hide()
                    }
                });
            }

        });
    </script>
@endpush
