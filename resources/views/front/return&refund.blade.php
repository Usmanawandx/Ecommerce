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
                        <a href="{{ route('front.return&refund') }}">
                            Return & Refund
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<div class="bann">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h2>Return & Refund</h2>
            </div>
            <div class="col-md-6 col-sm-12">
                <img src="{{ asset('assets/front/images/payment-method/ret-ref.svg')}}" alt="">
            </div>
        </div>
    </div>
</div>
    <!-- Contact Us Area Start -->
    <section class="contact-us ret-ref-sec">
        <div class="container">
            <p><strong>7 Days Checking & Replacement Warranty Policy</strong></p>
            <span>ECPMARKET has absolute faith in making internet shopping a remarkable experience focused around you, so you can appreciate complete fulfillment alongside the flawless degree of administration. That is the reason we trust you reserve the privilege to have your ordered product checked and if necessary be replaced. Thus, we have our popular 7-days checking and Replacement Warranty.</span>
            <p><strong>What is it?</strong></p>
            <span>Even though you won’t need it, our 7-days Replacement and Checking Warranty is the assistance we made to provide you with true serenity. You have 7 days, to check your item for any defect or operational issues.</span>
            <p><strong>ECPMARKET Replacement Policy is applicable within 2 circumstances/conditions:</strong></p>
            <li>In case the product is not as per the given described product on website.</li>
            <li>In case the item delivered to you is defective.</li>
            <p> <strong>What You Need to Make Sure of?</strong></p>
            <span>To replace your item, you need to make sure that the product should be:</span>
            <li>Undamaged, unused, and in the condition as it was delivered to you.</li>
            <li>The package contains its original product packaging, manufacturer’s containers, documentation, warranty cards, manuals, and all accessories that came in or attached to the product when purchased.</li>
            <li>None of the things referenced above, including the item itself, is damaged or set apart in any capacity whatsoever.</li>
            <p><strong>Note:</strong></p>
            <li>If product received is damaged.</li>
            <li>If product is dead on arrival.</li>
            <li>If product is completely different from what you have ordered.</li>
            <span>In such cases kindly inform us within 24 hours of delivery via email at <strong>support@ecpmarket.com</strong> or through call at our helpline so we may assist you with the replacement procedure.</span>
            <p>For more information on our return and replacement policy, don’t hesitate to get in touch with us at our helpline or email us at <strong> info@ecpmarket.com </strong> </p>
        </div>
    </section>
    <!-- Contact Us Area End-->

@endsection
