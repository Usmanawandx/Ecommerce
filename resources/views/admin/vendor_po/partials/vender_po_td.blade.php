@if(isset($items))
@foreach ($items as $item)
    <tr>
        <td>{{$item->order->order_number}}</td>
        <td>{{$item->product->sku}}</td>
        <td width="30%">{{$item->product->name}}</td>
        <td>
            @if(!empty($item->size) || $item->size != null || $item->size != '')
                Size : {{$item->size}}
            @endif
            <br>
            @if(!empty($item->color) || $item->color != null || $item->color != '')
                Color : {{$item->color}}
            @endif
        </td>
        <td>{{$item->qty}}</td>
        <td>{{$item->vendor_amount}}</td>
    </tr>
@endforeach
@endif
