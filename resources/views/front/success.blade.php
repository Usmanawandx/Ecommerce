@extends('layouts.front')

@section('content')
<script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

<style>
    /*@media print {*/
        /* #printarea *:not(.link)
        {
            display: visible !important;
            height: 100%;
        }
        .noPrint,body *{
            visibility: hidden !important;
        } */
        /* footer,.search-box,.nav-header,.toggle-bar .core-nav-toggle .right,#preloader,.categories_title,#catSelectForm,#category_select,.breadcrumb-area,.mainmenu-area.nav-fixed,.logo-header,.top-header,.link,.mainmenu-area .mainmenu-bb,.row .align-items-center .mainmenu-area-innner{
            display:none !important ;
        }
        .tempcart{
            display: block;
            visibility: visible;
        } */

    /*}*/
    table, td, th {
  border: 1px solid black !important;
}
</style>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="pages">
                    <li>
                        <a href="{{ route('front.index') }}">
                            {{ $langg->lang17 }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment.return') }}">
                            {{ $langg->lang169 }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->







<section  class="tempcart">

    @if(!empty($tempcart))

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Starting of Dashboard data-table area -->
                <div class="content-box section-padding add-product-1">
                    <div class="top-area">
                        <div class="content">
                            <h4 class="heading">
                                {{ $langg->order_title }}
                            </h4>
                            <p class="text">
                                {{ $langg->order_text }}
                            </p>
                            <a href="{{ route('front.index') }}" class="link">{{ $langg->lang170 }}</a>
                        </div>
                    </div>
                    <div class="view-order-page" id="printarea" style="font-weight:bold;">
                        <div class="order-table-wrap">
                            <div class="invoice-wrap">
                                <div class="invoice__title">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="invoice__logo text-center">
                                                <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}"
                                                    alt="woo commerce logo" width="250px" height="100px">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <br>
                                @if($order->dp == 1)

                                <div class="billing-add-area">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >{{ $langg->lang292 }}</h5>

                                            <p>{{ $langg->lang798 }}:
                                                {!! $order->payment_status == 'Pending' ? "<span
                                                    class='badge badge-danger'>". $langg->lang799
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
                                            
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @else
                                <div class="shipping-add-area">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="invoice__orderDetails">
                                                <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >Order Details</h5>
                                                <p><strong>{{  __('Order No')}} :</strong>
                                                    {{ $order->order_number }}<br>
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
                                                    {{$order->method}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 style="background-color: #d29370 ;color:black; padding:5px; font-weight:bolder;" >{{ $langg->lang292 }}</h5>

                                            <p>{{ $langg->lang798 }}
                                                {!! $order->payment_status == 'Pending' ? "<span
                                                    class='badge badge-danger'>". $langg->lang799
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

                                                <!--<a id="tid" style="cursor: pointer;"-->
                                                <!--    class="mybtn2">{{ $langg->lang297 }}</a>-->

                                                <!--<form id="tform">-->
                                                <!--    <input style="display: none; width: 100%;" type="text"-->
                                                <!--        id="tin" placeholder="{{ $langg->lang299 }}" required=""-->
                                                <!--        class="mb-3">-->
                                                <!--    <input type="hidden" id="oid" value="{{$order->id}}">-->

                                                <!--    <button-->
                                                <!--        style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;"-->
                                                <!--        id="tbtn" type="submit"-->
                                                <!--        class="mybtn1">{{ $langg->lang300 }}</button>-->

                                                <!--    <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;"-->
                                                <!--        id="tc" class="mybtn1">{{ $langg->lang298 }}</a>-->

                                                <!--    {{-- Change 1 --}}-->
                                                <!--</form>-->
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="billing-add-area">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
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
                                                            @foreach($tempcart->items as $product)
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
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>

            @endif
            <input type="hidden" name="cutEmail" id="CustomerEmail" value="{{$order->customer_email}}">
</section>
<script>
    var htm=$('#printarea').html()
      window.onload =function(){
            //  window.print();
             $.ajax({
                 url:"{{route('order_invoice')}}",
                 method:'POST',
                 data:{htmll:htm,_token:"{{ csrf_token()}}",email:"{{$order->customer_email}}",name:' {{$order->customer_name}}'},
                 success:function(){
                  // alert();
                  toastr.success('Email Send Successfully');
                 }

             })
       }
  </script>
<script>
    $(document).ready(function(e) {
        var order_no = <?php echo json_encode($order->order_number) ?>;
        var order_date = <?php echo json_encode($order->created_at) ?>;
        var payment_method = <?php echo json_encode($order->method) ?>;
        var shipping_method = <?php echo json_encode($order->shipping) ?>;
        var paid_amount = <?php echo json_encode($order->pay_amount) ?>;
        var payment_status = <?php echo json_encode($order->payment_status) ?>;
        var payment_method = <?php echo json_encode($order->method) ?>;
        var customer_name = <?php echo json_encode($order->customer_name) ?>;
        var city = <?php echo json_encode($order->city->name) ?>;
        var province = <?php echo json_encode($order->province->country_name) ?>;
        var totalQty = <?php echo json_encode($order->totalQty) ?>;
        var shipping_cost = <?php echo json_encode($order->shipping_cost) ?>;
        var sub_total = <?php echo json_encode($subtotal) ?>;
        $.ajax({
            type: "get",
            url: "{{route('purchaseLayer')}}",
            success: function (response) {
                dataLayer.push({ ecommerce: null });
                dataLayer.push({
                    'event': "Purchase",
                    'ecommerce': {'detail': [ {"content_type":"product","pageType":"product","content_ids":response.ids,"content_names":response.names,"content_skus":response.skus,"quantities":response.qty,"value":response.prices,"currency":response.currency,"category":response.mains,"sub_category":response.subs,"child_category":response.childs,"brands":response.brands,"sellers":response.sellers,"order_date":order_date,"order_number":order_no,"payment_method":payment_method,"shipping_method":shipping_method,"paid_amount":paid_amount,"payment_status":payment_status,"payment_method":payment_method,"customer_name":customer_name,"city":city,"province":province,"quantity":totalQty,"sub_total":sub_total,"shipping_cost":shipping_cost,"total_amount":paid_amount} ]}
                })
            }
        });
    })
</script>
@endsection
