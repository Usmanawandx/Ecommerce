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
                                                            <option  disabled> Please select </option>
                                                            @foreach ($vendors as $item)
                                                                <option value="{{$item->id}}"> {{$item->name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div>
                                                    <table class="table table-responsive-lg">
                                                        <thead>
                                                            <tr>
                                                                <th>Products</th>
                                                                <th>Quantity</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                            <tr class="trRow">
                                                                <td>
                                                                    <select required class="products form-control form-control-sm m-1" name="products[]">
                                                                        <option value="">Please Select</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input required type="number" min="0"  class="quantity form-control form-control-sm m-1" name="quantity[]">
                                                                </td>
                                                                <td class="action"><button role="button" type="button"  class="btn btn-sm m-1 ml-3 btn-primary  add_btn">+</button></td>
                                                            </tr>

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
                                                        <button class="addProductSubmit-btn" type="submit">{{ __('Create PO') }}</button>
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
            <script type="text/html" id="tbody_row">
                <tr class="trRow">
                    <td>
                        <select class="products form-control form-control-sm m-1" name="products[]" required>
                            <option value="">Please Select</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" min="0"  class="quantity form-control form-control-sm m-1" required name="quantity[]">
                    </td>
                    <td class="action" ><button role="button" type="button" class="btn btn-sm btn-primary m-1 ml-3  add_btn">+</button><button role="button" type="button"  class="btn btn-sm btn-danger  delete_btn">-</button></td>
                </tr>
            </script>
            <script>

                $(document).on('click','.add_btn',function (){
                    if ($('.trRow').length>=1) {
                        $('.trRow').last().children('.action').html(`<button role="button" type="button"  class="btn ml-3 btn-sm btn-danger  delete_btn">-</button>`)
                    }
                    $('#tbody').append($('#tbody_row').html());
                    $('.submit-loader').hide();
                    $('#vendor').trigger('change');

                });
                $(document).on('click','.delete_btn',function (){

                    // if ($('.trRow').length>1) {
                    //     $('.trRow').first().children('.action').html(`<button role="button" type="button" class="btn btn-sm btn-primary  add_btn">+</button>`)
                    // }
                    $(this).parents('.trRow').remove();
                    if ($('.trRow').length==1) {
                        $('.trRow').first().children('.action').html(`<button role="button" type="button" class="btn ml-3 btn-sm btn-primary  add_btn">+</button>`)
                    }
                    if($('.trRow').length>=2){
                        $('.trRow').last().children('.action').html(`<button role="button" type="button" class="btn ml-3 btn-sm btn-primary  add_btn">+</button><button role="button" type="button"  class="btn btn-sm btn-danger  delete_btn">-</button>`)
                    }


                    $('#vendor').trigger('change');
                });



                $(document).on('change','#vendor',function(){
                    $('.submit-loader').show();
                   id= $('#vendor ').find(":selected").val();
                   console.log(id);
                //    debugger;
                //    if (id!=undefined) {
                //        $('#products').children("[data-users!='"+id+"']").hide();
                //        $('#products').children("[data-users='"+id+"']").show();
                //    }
                  var  urlls="{{route('getVendorProduct',':id')}}";
                  urlls=urlls.replace(':id',id);
                $.ajax({
                    url:urlls,
                    method:"GET",
                    success:function(res){
                       $('.products').each(function(i,e){
                        $(e).html(res);
                       })
                       $('.submit-loader').hide();

                    },
                    error:function(){
                       $('.submit-loader').hide();

                    }

                })
                })
            </script>
@endsection
