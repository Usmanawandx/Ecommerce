@extends('layouts.vendor')

@section('content')
<style type="text/css">

</style>

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">KYC</h4>
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
                        <form id="geniusform" action="{{ route('mlm-kyc_store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Name on CNIC*</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" {{ ($kyc_information != null) ? 'readonly' : ''}} class="input-field" name="nic_name" placeholder="Name NIC" value="{{ ($kyc_information != null) ? $kyc_information[0]->name : ''}}" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Father Name *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" name="father_name"
                                           placeholder="Father Name" {{ ($kyc_information != null) ? 'readonly' : ''}} required="" value="{{ ($kyc_information != null) ? $kyc_information[0]->father_name : ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">CNIC Number *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="input-field" required name="cnic" {{ ($kyc_information != null) ? 'readonly' : ''}} placeholder="CNIC Number" required="" value="{{ ($kyc_information != null) ? $kyc_information[0]->cnic : ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Date of Birth. *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="date" class="input-field" name="dob" {{ ($kyc_information != null) ? 'readonly' : ''}} placeholder="DOB" required="" value="{{ ($kyc_information != null) ? $kyc_information[0]->dob : ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">Address *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" {{ ($kyc_information != null) ? 'readonly' : ''}} class="input-field" name="address" placeholder="CNIC Address" required="" value="{{ ($kyc_information != null) ? $kyc_information[0]->address : ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">CNIC Front Image*</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="file" {{ ($kyc_information != null) ? 'disabled' : ''}} class="input-field" name="cnic_front" required>
                                    @if($kyc_information != null)
                                        <img width="50%" height="50%" src="{{ asset('assets/images/users/'.$kyc_information[0]->nic_front) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">
                                        <h4 class="heading">CNIC Back Image *</h4>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <input type="file" {{ ($kyc_information != null) ? 'disabled' : ''}} class="input-field" name="cnic_back" required>
                                    @if($kyc_information != null)
                                        <img width="50%" height="50%" src="{{ asset('assets/images/users/'.$kyc_information[0]->nic_back) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="left-area">

                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <button {{ ($kyc_information != null) ? 'disabled' : ''}} class="btn btn-primary" type="submit">Submit</button>
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
