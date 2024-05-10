@extends('layouts.vendor')

@section('content')
                    <div class="content-area">
                            @if($user->checkWarning())
                                <div class="alert alert-danger validation text-center">
                                        <h3>{{ $user->displayWarning() }} </h3> <a href="{{ route('vendor-warning',$user->verifies()->where('admin_warning','=','1')->orderBy('id','desc')->first()->id) }}"> {{$langg->lang803}} </a>
                                </div>
                        @endif
                        @include('includes.form-success')
                                @if(Auth::user()->email == "mlmadmin@gmail.com")
                                    <span><b>Activate User : </b>  <a href="{{ route("activate_user") }}"> Activate </a></span><br>
                                @endif
                                <span><b>User : </b>  {{ Auth::user()->email }} </span><br>
                                @if(Auth::user()->referal_status == 1)
                                <a href="{{ @route("user.referal",Auth::user()->refer_id) }}">Referal ID: {{ @route("user.referal",Auth::user()->refer_id) }}</a>
                                <br>
                                @endif
{{--                                @foreach($references as $refer)--}}
{{--                                        <span>{{ $refer->name }}</span> &nbsp; &nbsp;--}}
{{--                                @endforeach--}}
                                @if(session()->has('active_success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('active_success') }}
                                    </div>
                                @endif
                                <div class="row row-cards-one">
                                @if(Auth::user()->is_vendor == 11)
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg1">
                                        <div class="left">
                                            <h5 class="title">Balance </h5>
                                            <span class="number">{{ $balance }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-dollar"></i>--}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg2">
                                        <div class="left">
                                            <h5 class="title">Total Earning</h5>
                                            <span class="number">{{ count($processing) }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-truck-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg3">
                                        <div class="left">
                                            <h5 class="title">Direct Commission</h5>
                                            <span class="number">{{ $direct_commission }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-check-circled"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">Indirect Commision</h5>
                                            <span class="number">{{ $indirect_commission }}</span>
                                            <a href="{{route('vendor-prod-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-cart-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg5">
                                        <div class="left">
                                            <h5 class="title">Profit Share</h5>
                                            <span class="number">{{ $profit_shared }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-shopify"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg6">
                                        <div class="left">
                                            <h5 class="title">Return On Investment</h5>
                                            <span class="number">{{ $roi }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                               <i class="icofont-dollar-true"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg2">
                                        <div class="left">
                                            <h5 class="title">Deposit</h5>
                                            <span class="number">{{ $mydeposit }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-truck-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg3">
                                        <div class="left">
                                            <h5 class="title">My Team</h5>
                                            <span class="number">{{ $team }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-check-circled"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">My Directs</h5>
                                            <span class="number">{{ $direct }}</span>
                                            <a href="{{route('vendor-prod-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-cart-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg5">
                                        <div class="left">
                                            <h5 class="title">Rank</h5>
                                            <span class="number">{{ App\Models\VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('qty') }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-shopify"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg6">
                                        <div class="left">
                                            <h5 class="title">Remaining Rank</h5>
                                            <span class="number">{{ App\Models\Product::vendorConvertPrice( App\Models\VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('price') ) }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-dollar-true"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg1">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang465 }} </h5>
                                            <span class="number">{{ count($pending) }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-dollar"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg2">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang466 }}</h5>
                                            <span class="number">{{ count($processing) }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-truck-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg3">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang467 }}</h5>
                                            <span class="number">{{ count($completed) }}</span>
                                            <a href="{{route('vendor-order-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-check-circled"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang468 }}</h5>
                                            <span class="number">{{ count(App\Models\Product::where('vendor_id',$user->id)->get()) }}</span>
                                            <a href="{{route('vendor-prod-index')}}" class="link">{{ $langg->lang471 }}</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-cart-alt"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg5">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang469 }}</h5>
                                            <span class="number">{{ App\Models\VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('qty') }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-shopify"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg6">
                                        <div class="left">
                                            <h5 class="title">{{ $langg->lang470 }}</h5>
                                            <span class="number">{{ App\Models\Product::vendorConvertPrice( App\Models\VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->sum('price') ) }}</span>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
{{--                                                <i class="icofont-dollar-true"></i>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            </div>
                    </div>
@endsection
