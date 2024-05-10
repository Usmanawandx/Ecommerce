<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
  <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
  <style type="text/css">
@page { size: auto;  margin: 0mm; }
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 287mm;
  }

table, td, th {
border: 1px solid black !important;
}
#printarea{
-webkit-print-color-adjust: exact;
}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: hidden;  /* optional: just make scrollbar invisible */
}
}
  </style>
</head>
<body onload="window.print();">
    <div class="order-table-wrap" id="printarea" style="font-weight:bold;">
        <div class="invoice-wrap">
            <div class="invoice__title">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="invoice__logo text-center" style="text-align:center;">
                           <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row invoice__metaInfo mb-4">
                <div class="col-lg-6">
                    <div class="invoice__orderDetails">

                        <p style="background-color: #d29370 ;color:black; padding:1px; font-weight:bolder;" ><strong>{{ __('Order Details') }} </strong></p>
                        <span><strong>{{  __('Order No')}} :</strong> {{ $order->order_number }}</span><br>
                        <span><strong>{{ __('Order Date') }} :</strong> {{ date('d-M-Y',strtotime($order->created_at)) }}</span><br>
                        @if($order->dp == 0)
                        <span> <strong>{{ __('Shipping Method') }} :</strong>
                            @if($order->shipping == "pickup")
                            {{ __('Pick Up') }}
                            @else
                            {{ __('Ship To Address') }}
                            @endif
                        </span><br>
                        @endif
                        <span> <strong>{{ __('Payment Method') }} :</strong> {{$order->method}}</span>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row invoice__metaInfo">
                <div class="col-lg-6">
                    <div class="buyer invoice__shipping">
                        <p style="background-color: #d29370 ;color:black; padding:1px; font-weight:bolder;" ><strong>{{ __('Billing Details') }}</strong></p>
                        <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->customer_name}}</span><br>
                        <span><strong>{{ __('Address') }}</strong>: {{ $order->customer_address }}</span><br>
                        <span><strong>{{ __('Phone No') }}</strong>: {{ $order->customer_phone }}</span><br>
                        <span><strong>{{ __('City') }}</strong>: {{ $order->city->name }}</span><br>
                        <span><strong>{{ __('Province') }}</strong>: {{ $order->province->country_name }}</span>
                    </div>
            </div>
           @if($order->dp == 0)
                <div class="col-lg-6">
                        <div class="invoice__shipping">
                            <p style="background-color: #d29370 ;color:black; padding:1px; font-weight:bolder;" ><strong>{{ __('Shipping Details') }}</strong></p>
                           <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</span><br>
                           <span><strong>{{ __('Address') }}</strong>: {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</span><br>
                           <span><strong>{{ __('Phone No') }}</strong>: {{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}</span><br>
                           <span><strong>{{ __('City') }}</strong>: {{ $order->shipping_city == null ? $order->city->name : $order->scity->name }}</span><br>
                           <span><strong>{{ __('Province') }}</strong>: {{ $order->shipping_province == null ? $order->province->country_name : $order->sprovince->country_name }}</span>

                        </div>
                </div>
            @endif

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="invoice_table">
                        <div class="mr-table">
                            <hr>
                            <h4 class="text-left "><strong>Order Products</strong> </h4>
                            <div class="table-responsive">
                                <table id="example2"
                                    class="table table-hover dt-responsive table-sm table-bordered "
                                    cellspacing="0" width="100%" >
                                    <thead style="background-color: #d29370 !important;color:black;">
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Details') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $subtotal = 0;
                                        $tax = 0;
                                        @endphp
                                        @if(count($order->order_items) > 0)
                                            @foreach($order->order_items as $item)
                                            <tr>
                                                <td width="50%">

                                                    <a target="_blank"
                                                        href="{{ route('front.product', $item->product->slug) }}">{{ $item->product->name}}</a>

                                                </td>


                                                <td>
                                                    @if($item['size'])
                                                    <p>
                                                        <strong>{{ __('Size') }} :</strong>
                                                        {{str_replace('-',' ',$item['size'])}}
                                                    </p>
                                                    @endif
                                                    @if($item['color'])
                                                    <p>
                                                        <strong>{{ __('color') }} :</strong>
                                                        <span
                                                            style="width: 40px; height: 20px; display: block; background: #{{$item['color']}};"></span>
                                                    </p>
                                                    @endif
                                                    <p>
                                                        <strong>{{ __('Price') }} :</strong>
                                                        {{$order->currency_sign}}{{ round($item['item_price'] * $order->currency_value , 2) }}
                                                    </p>
                                                    <p>
                                                        <strong>{{ __('Qty') }} :</strong>
                                                        {{$item['qty']}}
                                                        {{ $item->product->measure }}
                                                    </p>

                                                    @if(!empty($item['keys']))

                                                    @foreach( array_combine(explode(',',
                                                    $item['keys']), explode(',',
                                                    $item['values'])) as $key => $value)
                                                    <p>

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }}
                                                            : </b> {{ $value }}

                                                    </p>
                                                    @endforeach

                                                    @endif

                                                </td>





                                                <td>{{$order->currency_sign}}{{ round($item['total_price'] * $order->currency_value , 2) }}
                                                </td>
                                                @php
                                                $subtotal += round($item['total_price'] *
                                                $order->currency_value, 2);
                                                @endphp

                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach($cart->items as $product)
                                            <tr>
                                                <td width="50%">
                                                    @if($product['item']['user_id'] != 0)
                                                    @php
                                                    $user =
                                                    App\Models\User::find($product['item']['user_id']);
                                                    @endphp
                                                    @if(isset($user))
                                                    <a target="_blank"
                                                        href="{{ route('front.product', $product['item']['slug']) }}">{{ $product['item']['name']}}</a>
                                                    @else
                                                    <a
                                                        href="javascript:;">{{$product['item']['name']}}</a>
                                                    @endif

                                                    @else
                                                    <a
                                                        href="javascript:;">{{ $product['item']['name']}}</a>

                                                    @endif
                                                </td>


                                                <td>
                                                    @if($product['size'])
                                                    <p>
                                                        <strong>{{ __('Size') }} :</strong>
                                                        {{str_replace('-',' ',$product['size'])}}
                                                    </p>
                                                    @endif
                                                    @if($product['color'])
                                                    <p>
                                                        <strong>{{ __('color') }} :</strong>
                                                        <span
                                                            style="width: 40px; height: 20px; display: block; background: #{{$product['color']}};"></span>
                                                    </p>
                                                    @endif
                                                    <p>
                                                        <strong>{{ __('Price') }} :</strong>
                                                        {{$order->currency_sign}}{{ round($product['item_price'] * $order->currency_value , 2) }}
                                                    </p>
                                                    <p>
                                                        <strong>{{ __('Qty') }} :</strong>
                                                        {{$product['qty']}}
                                                        {{ $product['item']['measure'] }}
                                                    </p>

                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',',
                                                    $product['keys']), explode(',',
                                                    $product['values'])) as $key => $value)
                                                    <p>

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }}
                                                            : </b> {{ $value }}

                                                    </p>
                                                    @endforeach

                                                    @endif

                                                </td>





                                                <td>{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}
                                                </td>
                                                @php
                                                $subtotal += round($product['price'] *
                                                $order->currency_value, 2);
                                                @endphp

                                            </tr>

                                            @endforeach
                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td style="background-color: #f4e3d3 !important;color:black;">Thank You For Your Order</td>
                                            <td style="background-color: #d29370 !important;color:black;">{{ __('Subtotal') }}</td>
                                            <td style="background-color: #f4e3d3 !important;color:black;">{{$order->currency_sign}}{{ round($subtotal, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="background-color: #d29370 !important;color:black;">{{ __('Shipping Cost') }}</td>
                                            <td style="background-color: #f4e3d3 !important;color:black;">
                                                @if($order->shipping_cost != 0)
                                                Rs{{$order->shipping_cost}}
                                                @else
                                                0
                                                @endif
                                            </td>
                                        </tr>
                                        @if($order->tax != 0)
                                        <tr>
                                            <td></td>
                                            <td style="background-color: #d29370 !important;color:black;">
                                                {{ __('TAX') }}({{$order->currency_sign}})
                                            </td>
                                            @php
                                            $tax = ($subtotal / 100) * $order->tax;
                                            @endphp
                                            <td style="background-color: #f4e3d3 !important;color:black;">{{round($tax, 2)}}</td>
                                        </tr>
                                        @endif
                                        @if($order->coupon_discount != null)
                                        <tr>
                                            <td></td>
                                            <td style="background-color: #d29370 !important;color:black;">
                                                {{ __('Coupon Discount') }}({{$order->currency_sign}})
                                            </td>
                                            <td style="background-color: #f4e3d3 !important;color:black;">{{round($order->coupon_discount, 2)}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td style="background-color: #d29370 !important;color:black;">{{ __('Total') }}</td>
                                            <td style="background-color: #f4e3d3 !important;color:black;">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>

</body>
</html>
