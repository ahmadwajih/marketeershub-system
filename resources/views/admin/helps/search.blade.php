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