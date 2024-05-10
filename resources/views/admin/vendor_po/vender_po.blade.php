@extends('layouts.load')

@section('content')
<!-- <script>
    $(document).ready(function(){
        $('.js-example-basic-single').select2({
  placeholder: 'Select an option'
});
    })

</script> -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#category" class="nav-link active" data-toggle="tab">Purchase Order</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="category">
                    <div class="content-area">

                        <div class="add-product-content1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-description">
                                        <div class="body-area">
                                            @include('includes.admin.form-error')
                                            <form id="geniusformdata" action="{{route('Add_po')}}" method="POST" >
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Vendors') }} *</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select name="vendor" class="" id="vendor">
                                                            <option  disabled selected> Please select </option>
                                                            @foreach ($vendors as $item)
                                                                    <option value="{{$item->id}}"> {{$item->shop_name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div>
                                                    <table class="table table-responsive-lg">
                                                        <thead>
                                                            <tr>
                                                                <th>Order No</th>
                                                                <th>Product Sku</th>
                                                                <th>Product Name</th>
                                                                <th>Details</th>
                                                                <th>Quantity</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                                @include('admin.vendor_po.partials.vender_po_td')
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <button class="btn btn-primary" type="submit">{{ __('Create PO') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>


                $(document).on('change','#vendor',function(){
                    $('.submit-loader').show();
                   id= $('#vendor ').find(":selected").val();
                  var  urlls="{{route('getVendorItem',':id')}}";
                  urlls=urlls.replace(':id',id);
                $.ajax({
                    url:urlls,
                    method:"GET",
                    success:function(res){
                        $('#tbody').html(res);
                       $('.submit-loader').hide();

                    },
                    error:function(){
                       $('.submit-loader').hide();

                    }

                })
                })
            </script>
@endsection
