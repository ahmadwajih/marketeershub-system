@extends('dashboard.layouts.app')

@section('title', 'Users')

@section('content')



@endsection
@push('scripts')
<script>
    var route = "{{ route('user.index') }}";
    var csrfToken = "{{ csrf_token() }}";
</script>

<script src="{{ asset('dashboard') }}/assets/js/users/list.js"></script>
@endpush
