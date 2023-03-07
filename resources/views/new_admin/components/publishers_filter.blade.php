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
                        $('.publishers_filter').find('option').remove().end();
                        let select = document.getElementById('publishers_filter');
                        for (const key in data.items) {
                            let opt = document.createElement('option');
                            opt.value = data.items[key].id;
                            opt.innerHTML = data.items[key].name;
                            select.appendChild(opt);
                        }
                        $(".publishers_filter .select2-selection__placeholder").html("Select Publisher");
                    },
                    complete: function() {
                        $('#loading').hide()
                    }
                });
            }

        });
    </script>
@endpush
