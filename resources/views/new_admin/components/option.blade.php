<option value="">{{ $title }}</option>
@foreach($items as $item)
    <option value="{{ $item->id }}">{{ $item->name }}</option>
@endforeach