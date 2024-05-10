<option value="">Select City</option>
@if (isset($cities))
@foreach ($cities as $item)
<option value="{{$item->id}}" data-id="{{$item->zone_id}}">{{$item->name}}</option>
@endforeach
@endif

