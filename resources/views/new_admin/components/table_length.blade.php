@php($lengths = [10, 25, 50, 100])
<select id="change_table_length" class="form-select form-select-sm">
    @foreach( $lengths as $length)
        <option {{  session('table_length') == $length ? 'selected' : '' }} value="{{ $length }}">{{ $length }}</option>
    @endforeach
</select>

@push('scripts')
    <script>
         $('#change_table_length').change(function(){
                var url = "{{ route('admin.table.handler.set.table.length', request()->all()) }}" + "{{ count(request()->all())> 0 ? '&' : '?' }}" + "table_length="+$(this).val();
                url = url.replace(/&amp;/g, '&');
                window.location.href = url;
            });

    </script>
@endpush