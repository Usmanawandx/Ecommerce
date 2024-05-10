@extends('layouts.front')


@section('content')

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
                        <a href="{{ route('front.paymentmethod') }}">
                            Payment Method
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->


    <!-- Contact Us Area Start -->
    <section class="py-method align-items-center" style="margin-top: 200px;">
        <div class="container">
            <div class="row m-5 align-items-center" style="margin-bottom: -70px !important;">
                <div class="col-md-6">
                    <img src="{{ asset('assets/front/images/payment-method/cashondelivery.svg')}}" alt="">
                </div>
                <div class="col-md-6 col-sm-12">
                    <h4>Cash On delivery</h4>
                    <span>ECP Market is trying to provide maximum ease of online shopping to our customers so the customer can pay the amount of order on delivery so we have started aligned top-notch and most reliable logistics partners with maximum cities coverage in Pakistan.</span>
                </div>
            </div>
            <div class="row m-5 align-items-center">
                <div class="col-md-6 col-sm-12">
                    <h4>Bank Deposit or Online Trasfer</h4>
                    <span>A customer can also choose the bank Payment method while checkout and pay the order amount in below Given Bank account and share transfer receipt over any contact medium like email, WhatsApp, or Chat.</span>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/front/images/payment-method/banktransfer.svg')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us Area End-->
    
    <section class="bnk-det">
        <div class="container">
            <div class="row">
            <div class="col-md-4 col-sm-12">
                <img src="{{ asset('assets/front/images/payment-method/faisal.png')}}" alt="">
                <ul>
                    <li><b>Bank Name :</b> Faysal Bank Account</li>
                    <li><b>Title :</b> ECP MARKET</li>
                    <li><b>AC number :</b> 017300700003694</li>
                    <li><b>IBAN# :</b> PK76FAYS0173007000003694</li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12">
                <img src="{{ asset('assets/front/images/payment-method/hbl.png')}}" alt="">
                <ul>
                    <li><b>Bank Name :</b> HBL</li>
                    <li><b>Title :</b> ECP MARKET</li>
                    <li><b>AC number :</b> 0050477000050955</li>
                    <li><b>IBAN# :</b> PK70HABB0050477000050955</li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12">
                <img src="{{ asset('assets/front/images/payment-method/js.png')}}" alt="">
                <ul>
                    <li><b>Bank Name :</b> JS Bank</li>
                    <li><b>Title :</b> ECP MARKET</li>
                    <li><b>AC number :</b> 96210001843455</li>
                    <li><b>IBAN# :</b> PK80JSBL9621000001843455</li>
                </ul>
            </div>
        </div>
        </div>
    </section>
    
    
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="py-note">Bank Deposit orders will be processed after payment verification from the finance department.</p>
            </div>
        </div>
    </div>
    
    <!-- Contact Us Area Start -->
    <section class="py-method" style="margin-top: 50px;">
        <div class="container">
            <div class="row m-5 align-items-center">
                <div class="col-md-6 col-sm-12">
                    <img src="{{ asset('assets/front/images/payment-method/ecp-wallet.svg')}}" alt="">
                </div>
                <div class="col-md-6">
                    <h4>ECP Wallet</h4>
                    <span>Customers can also pay through ECP Wallet and the amount in Wallet Top-up can be made in different mediums i.e bank deposit of old order refunds (if the customer wished to).</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us Area End-->

@endsection
