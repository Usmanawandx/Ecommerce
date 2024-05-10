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
    <link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
    <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
          thead{

              background-color: #d29370 !important;
            -webkit-print-color-adjust: exact;
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
    <div class="order-table-wrap">
        <div class="view-order-page" id="printarea" style="font-weight:bold;">
            <div class="order-table-wrap">
                <div class="invoice-wrap">
                    <div class="invoice__title">
                        <div class="row">
                            <div class="col-12">
                                <div class="invoice__logo text-center" style="text-align:center;">
                                    <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo"
                                        width="150px" height="100px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    @if($order->dp == 1)

                    <div class="billing-add-area">
                        <div class="row">
                            <div class="col-6">
                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >Billing Details</h5>
                                <address>
                                    {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                    {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                    {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                    {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                    @if($order->order_note != null)
                                    {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                    @endif
                                    {{$order->city->name}}-{{$order->customer_zip}}
                                </address>
                            </div>
                            <div class="col-6">
                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >{{ $langg->lang292 }}</h5>

                                <p>{{ $langg->lang798 }}:
                                    {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>".
                                        $langg->lang799
                                        ."</span>":"<span class='badge badge-success'>".
                                        $langg->lang800 ."</span>" !!}
                                </p>

                                <p>{{ $langg->lang293 }}
                                    {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                </p>
                                <p>{{ $langg->lang294 }} {{$order->method}}</p>

                                @if($order->method != "Cash On Delivery")
                                @if($order->method=="Stripe")
                                {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}
                                </p>
                                @endif
                                {{$order->method}} {{ $langg->lang296 }} <p id="ttn">
                                    {{$order->txnid}}</p>
                                <a id="tid" style="cursor: pointer;" class="mybtn2">{{ $langg->lang297 }}</a>

                                <form id="tform">
                                    <input style="display: none; width: 100%;" type="text" id="tin"
                                        placeholder="{{ $langg->lang299 }}" required="" class="mb-3">
                                    <input type="hidden" id="oid" value="{{$order->id}}">

                                    <button
                                        style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                        id="tbtn" type="submit" class="mybtn1">{{ $langg->lang300 }}</button>

                                    <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;"
                                        id="tc" class="mybtn1">{{ $langg->lang298 }}</a>

                                    {{-- Change 1 --}}
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    @else
                    <div class="shipping-add-area">
                        <div class="row">
                            <div class="col-6">
                                <div class="invoice__orderDetails">
                                    <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >Order Details</h5>
                                    <span><strong>{{  __('Order No')}} :</strong></span>
                                        <span>{{ $order->order_number }}<br>
                                        <strong>{{ __('Order Date') }} :</strong>
                                        {{ date('d-M-Y',strtotime($order->created_at)) }}<br>
                                        @if($order->dp == 0)
                                        <strong>{{ __('Shipping Method') }} :</strong>
                                        @if($order->shipping == "pickup")
                                        {{ __('Pick Up') }}
                                        @else
                                        {{ __('Ship To Address') }}
                                        @endif
                                        <br>
                                        @endif
                                        <strong>{{ __('Payment Method') }} :</strong>
                                        {{$order->method}}</span>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >{{ $langg->lang292 }}</h5>
                                <span>{{ $langg->lang798 }}
                                    {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>".
                                        $langg->lang799
                                        ."</span>":"<span class='badge badge-success'>".
                                        $langg->lang800 ."</span>" !!}
                                    <br>
                                    {{ $langg->lang293 }}
                                    {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                    <br>
                                    {{ $langg->lang294 }} {{$order->method}} <br>

                                    @if($order->method != "Cash On Delivery")
                                    @if($order->method=="Stripe")
                                    {{$order->method}} {{ $langg->lang295 }} {{$order->charge_id}}
                                    <br>
                                    @endif
                                    {{$order->method}} {{ $langg->lang296 }}
                                    {{$order->txnid}} <br>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="billing-add-area">
                        <div class="row">
                            <div class="col-6">
                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >Billing Details</h5>
                                <address>
                                    {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                    {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                    {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                    {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                    @if($order->order_note != null)
                                    {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                    @endif
                                    City: {{$order->city->name}} <br>
                                    Province : {{$order->province->country_name}}
                                </address>
                            </div>
                            <div class="col-6">
                                @if($order->shipping == "shipto")
                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >Shipping Details</h5>
                                <address>
                                    {{ $langg->lang288 }}
                                    {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                    {{ $langg->lang289 }}
                                    {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                    {{ $langg->lang290 }}
                                    {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                    {{ $langg->lang291 }}
                                    {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                    City: {{$order->shipping_city == null ? $order->city->name : $order->scity->name}} <br>
                                    Province: {{$order->shipping_province == null ? $order->province->country_name : $order->sprovince->country_name}} <br>
                                </address>
                                @else
                                <h5>{{ $langg->lang303 }}</h5>
                                <address>
                                    {{ $langg->lang304 }} {{$order->pickup_location}}<br>
                                </address>
                                @endif

                            </div>
                        </div>
                    </div>
                    @endif
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice_table">
                                <div class="mr-table">
                                    <hr>
                                    <h4 class="text-left "><strong>Order Products</strong> </h4>
                                    <div class="table-responsive">
                                        <table id="example2"
                                            class="table table-hover dt-responsive table-sm  "
                                            cellspacing="0" width="100%">
                                            <thead >
                                                <tr>
                                                    <th style="background-color: #d29370 !important;color:black;">{{ __('Product') }}</th>
                                                    <th style="background-color: #d29370 !important;color:black;">{{ __('Details') }}</th>
                                                    <th style="background-color: #d29370 !important;color:black;">{{ __('Total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $subtotal = 0;
                                                $tax = 0;
                                                @endphp
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
                                                        <a href="javascript:;">{{$product['item']['name']}}</a>
                                                        @endif

                                                        @else
                                                        <a href="javascript:;">{{ $product['item']['name']}}</a>

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
        </div>
    </div>

    <script type="text/javascript">
        setTimeout(function () {
            window.close();
        }, 500);

    </script>
</body>

</html>
