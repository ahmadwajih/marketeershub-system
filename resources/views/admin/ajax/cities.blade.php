
@foreach($cities as $city)
<option value="{{$city->id}}">{{$city->name_en}}</option>
@endforeach