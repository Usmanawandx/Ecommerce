@extends('layouts.admin')

@section('content')
<style>
    table, td, th {
  border: 1px solid black !important;
    }
</style>
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Invoice') }} <a class="add-btn" href="javascript:history.back();"><i
                            class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Orders') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Invoice') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="order-table-wrap" style="font-weight:bold;">
        <div class="invoice-wrap">
            <div class="invoice__title">
                <div class="row">
                    <div class="col-12">
                        <div class="invoice__logo text-center">
                           <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <a class="btn  add-newProduct-btn print" href="{{route('admin-order-print',$order->id)}}"
                        target="_blank"><i class="fa fa-print"></i> {{ __('Print Invoice') }}</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row invoice__metaInfo mb-4">
                <div class="col-lg-6">
                    <div class="invoice__orderDetails">

                        <p style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;"><strong>{{ __('Order Details') }} </strong></p>
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
                        <p style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;"><strong>{{ __('Billing Details') }}</strong></p>
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
                            <p style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;"><strong>{{ __('Shipping Details') }}</strong></p>
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
<!-- Main Content Area End -->
</div>
</div>
</div>

@endsection
