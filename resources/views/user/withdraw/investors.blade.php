@extends('layouts.vendor')

@section('content')
    <style type="text/css">

    </style>

    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Withdraw</h4>
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

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($investors as $investor)
                                    <tr>
                                        <td>{{ $investor->name }}</td>
                                        <td>{{ $investor->email }}</td>
                                        <td>{{ ($investor->referal_status == 1) ? "active" : "Inactive"}}</td>
                                        <td> <select _id="{{ $investor->id }}" class="investor_status form-control">
                                                <option value="">Select</option>
                                                <option value="1">Active</option>
                                                <option value="0">In Active</option>
                                            </select> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

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
        $(".investor_status").change(function(){
            var url = "{{ route('activate_user') }}"+$(this).attr("_id");
            $.ajax({
                url:url,
                success:function(response){
                    if(response.success == "true"){
                        alert("User Active");
                        location.reload();
                    }
                }
            });
        });
    </script>

@endsection
