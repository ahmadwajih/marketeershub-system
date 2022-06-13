@extends('admin.layouts.app')
@section('title',__('Help'))
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=207032e23c2cef9749c0d1"></script>@endpush
@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                
                @if(session()->has('message'))
                    @include('admin.temps.success')
                @endif
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3>{{ __('Help') }}</h3>
                    </div>
                    @can('create_helps')
                        <div class="card-toolbar">
                            <a href="{{route('admin.helps.create')}}" class="btn btn-primary font-weight-bolder ">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span> {{ __('Add New') }}
                            </a>
                            <!--end::Button-->
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">{{ __('Search') }}</span>
                        <input id="search" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <div id="searchValidation" class="invalid-feedback">
                            {{ __('Please add atleast 3 letters.') }}
                        </div>
                      </div>
                      
                    <div class="accordion" id="accordionPanel">
                        
                        @foreach ($helps as $help)
                        <div class="accordion-item mt-2">
                          <h2 class="accordion-header" id="panelsStayOpen-heading{{ $help->id }}">
                            <div class="d-flex justify-content-betwee">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $help->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{ $help->id }}">
                                    {{ $help->title }}
                                </button>
                                <div class="d-flex justify-content-center">
                                    @can('update_helps')
                                    <a href="{{ route('admin.helps.edit', $help->id) }}" class="btn btn-icon btn-success m-1">
                                        <i class="flaticon2-pen"></i>
                                    </a>
                                @endcan
                                @can('delete_helps')
                                    <button onclick="deleteItem('{{ route('admin.helps.destroy', $help->id) }}', {{ $help->id }})" class="btn btn-icon btn-danger  m-1">
                                        <i class="flaticon2-trash"></i>
                                    </button>
                                @endcan
                                <a href="{{ route('admin.helps.show', $help->id) }}" class="btn btn-icon btn-secondary  m-1">
                                    <i class="flaticon-eye"></i>
                                </a>
                                </div>
                                
                            </div>
                          </h2>
                          <div id="panelsStayOpen-collapse{{ $help->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{ $help->id }}">
                            <div class="accordion-body">

                                {!! $help->content !!}
                            </div>
                          </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    </div>
    </div>
    <!--end::Entry-->
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
        iframely.load( element, element.attributes.url.value );
    } );
</script>

<script>
    "use strict";
var destroyRoute = '';
var itemId = '';
function deleteItem(route, id){
    destroyRoute = route;
    itemId = id;
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            console.log(destroyRoute);
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: destroyRoute,
                data: {
                    "_token": '{{ csrf_token() }}',
                    "_method": "DELETE",
                    id: itemId
                }, 
            })
            .done(function(res) {
                location.reload();

            })
            .fail(function(res) { 
                resolve('{{ __("Error!") }}');
            });

          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
}
</script>

<script>
    $('#search').keyup(function(){
        var search = $(this).val();
        // if($(this).val().length > 3){
            $('#searchValidation').fadeOut();
            
            $.ajax({
                method: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('admin.helps.search') }}",
                data: {
                    "_token": '{{ csrf_token() }}',
                    search: search
                }, 
            })
            .done(function(res) {
                $('#accordionPanel').html(res);
            })
            .fail(function(res) { 
                resolve('{{ __("Error!") }}');
            });

        // }else{
        //     $('#searchValidation').fadeIn();
        // }
    });
</script>
@endpush
