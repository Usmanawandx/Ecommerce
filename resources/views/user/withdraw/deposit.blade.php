@extends('layouts.vendor')

@section('content')
<style type="text/css">

</style>

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">Company Deposit</h4>
            </div>
        </div>
    </div>
    <div class="add-product-content1">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area">
                        <div class="gocover" style="background: url(https://localhost/ecp/assets/images/1564224329loading3.gif) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                        <div class="alert alert-success validation" style="display: none;">
                            <button type="button" class="close alert-close"><span>×</span></button>
                            <p class="text-left"></p>
                        </div>
                        <div class="alert alert-danger validation" style="display: none;">
                            <button type="button" class="close alert-close"><span>×</span></button>
                            <ul class="text-left">
                            </ul>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form id="geniusform" action="{{ route('deposit_store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Bank Name *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" readonly class="input-field" name="bank_name" placeholder="Bank" value="Faysal Bank Limited" required >
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Account Title *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" readonly class="input-field" name="account_title"
                                           placeholder="Account Title" required="" value="The Eagle Crest">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">IBAN Number *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" readonly name="iban_no" placeholder="IBAN Number" required="" value="PK93FAYS0173007000003194">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Account NO. *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" readonly class="input-field" name="account_no" placeholder="Account NO." required="" value="0173007000003194">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Amount *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" name="amount" placeholder="Amount" required="" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Deposit Date *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="date" class="input-field" name="deposit_date" placeholder="Deposit Date" value="" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Payment mode *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="radio" value="1" name="payment_mode[]"> <span>Cash Deposit</span>
                                    <input type="radio" value="2" name="payment_mode[]"> <span>Cheques Deposit</span>
                                    <input type="radio" value="3" name="payment_mode[]"> <span>Online Transfer</span>
                                    <input type="radio" value="4" name="payment_mode[]"> <span>ATM Transfer</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Slip No. </h4>
{{--                                        <p class="sub-heading">(This Field is Optional)</p>--}}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" required class="input-field" name="slip_no" placeholder="Slip No." value="">
                                </div>
                            </div>

                            <div class="row" style="display:none">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Remarks </h4>
{{--                                        <p class="sub-heading">(This Field is Optional)</p>--}}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" name="remarks" placeholder="Remarks" value="">
                                </div>
                            </div>
                            <div class="row" style="display:none">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">E-Pin </h4>
{{--                                        <p class="sub-heading">(This Field is Optional)</p>--}}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" name="e_pin" placeholder="E-Pin" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Depsit Slip Snap </h4>
{{--                                        <p class="sub-heading">(This Field is Optional)</p>--}}
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="file" required class="input-field" name="slip_image" placeholder="Depsit Slip Snap" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">

                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')


<script type="text/javascript">
    $("#withmethod").change(function(){
        var method = $(this).val();
        if(method == "Bank"){

            $("#bank").show();
            $("#bank").find('input, select').attr('required',true);

            $("#paypal").hide();
            $("#paypal").find('input').attr('required',false);

        }
        if(method != "Bank"){
            $("#bank").hide();
            $("#bank").find('input, select').attr('required',false);

            $("#paypal").show();
            $("#paypal").find('input').attr('required',true);
        }
        if(method == ""){
            $("#bank").hide();
            $("#paypal").hide();
        }

    })
</script>

@endsection
