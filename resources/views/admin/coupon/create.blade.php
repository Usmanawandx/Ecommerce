@extends('layouts.admin')

@section('styles')

<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

@endsection


@section('content')

            <div class="content-area">

              <div class="mr-breadcrumb">
                <div class="row">
                  <div class="col-lg-12">
                      <h4 class="heading">{{ __('Add New Coupon') }} <a class="add-btn" href="{{route('admin-coupon-index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="{{ route('admin-coupon-index') }}">{{ __('Coupons') }}</a>
                        </li>
                        <li>
                          <a href="{{ route('admin-coupon-create') }}">{{ __('Add New Coupon') }}</a>
                        </li>
                      </ul>
                  </div>
                </div>
              </div>

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                        @include('includes.admin.form-both')
                      <form id="geniusform" action="{{route('admin-coupon-create')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Code') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="code" placeholder="{{ __('Enter Code') }}" required="" value="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Type') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="type" name="type" required="">
                                <option value="">{{ __('Choose a type') }}</option>
                                <option value="0">{{ __('Discount By Percentage') }}</option>
                                <option value="1">{{ __('Discount By Amount') }}</option>
                              </select>
                          </div>
                        </div>

                        <div class="row hidden">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"></h4>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <input type="text" class="input-field less-width" name="price" placeholder="" required="" value=""><span></span>
                          </div>
                        </div>
                        <div class="row hidden" id="Max" >
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">Maximum Discount*</h4>
                                </div>
                              </div>
                            <div class="col-lg-7">
                              <input type="text" name="maximum_discount" class="input-field less-width" placeholder="Add Maximum Discount"  value="" style="width: 180px;">
                            </div>
                        </div>              
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Quantity') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="times" required="">
                                <option value="0">{{ __('Unlimited') }}</option>
                                <option value="1">{{ __('Limited') }}</option>
                              </select>
                          </div>
                        </div>

                        <div class="row hidden">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Value') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field less-width" name="times" placeholder="{{ __('Enter Value') }}" value=""><span></span>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('exclude sku') }} </h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select  multiple class="form-control" id="sku"  name="sku[]">
                                    <option disabled     selected value="" >Please Select</option>
                                    @foreach ($prod as $item)
                                      <option value="{{$item->sku}}">{{$item->sku}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Child Category') }} </h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="child_category"  name="childcategories_id">
                                  <option selected value="" >Please Select</option>
                                  @foreach ($child as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Seller') }} </h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select id="vendor" name="users_id" >
                                    <option selected value="">Please Select</option>
                                    @foreach ($vendor as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                        <div class="row">
                            <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Brand') }} </h4>
                            </div>
                            </div>
                            <div class="col-lg-7">
                                <select id="brand" name="brands_id" >
                                    <option selected value="" >Please Select</option>
                                    @foreach ($brand as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h6 class="heading">Min & Max Shopping cart Amount</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Min Amount') }} *</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <input type="number" min="0" class="input-field" name="min_amount" placeholder="{{ __('Enter Value') }}" value="">
                              </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Max Amount') }}</h4>
                                </div>
                              </div>
                              <div class="col-lg-7">
                                <input type="number" min="0" class="input-field" name="max_amount" placeholder="{{ __('Enter Value') }}" value="">
                              </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Start Date') }}</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="start_date" id="from" placeholder="{{ __('Select a date') }}" required="" value="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('End Date') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="end_date" id="to" placeholder="{{ __('Select a date') }}" required="" value="">
                          </div>
                        </div>

                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Coupon') }}</button>
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

{{-- Coupon Type --}}

    $('#type').on('change', function() {
      var val = $(this).val();
      var selector = $(this).parent().parent().next();
      if(val == "")
      {
        selector.hide();
      }
      else {
        if(val == 0)
        {
          selector.find('.heading').html('{{ __('Percentage') }} *');
          selector.find('input').attr("placeholder", "{{ __('Enter Percentage') }}").next().html('%');
          selector.css('display','flex');
        }
        else if(val == 1){
          selector.find('.heading').html('{{ __('Amount') }} *');
          selector.find('input').attr("placeholder", "{{ __('Enter Amount') }}").next().html('$');
          selector.css('display','flex');
        }
      }
    });


{{-- Coupon Qty --}}

  $(document).on("change", "#times" , function(){
    var val = $(this).val();
    var selector = $(this).parent().parent().next();
    if(val == 1){
    selector.css('display','flex');
    }
    else{
    selector.find('input').val("");
    selector.hide();
    }
});

</script>

<script type="text/javascript">
    var dateToday = new Date();
    var dates =  $( "#from,#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        minDate: dateToday,
        onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
          instance = $(this).data("datepicker"),
          date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
          dates.not(this).datepicker("option", option, date);
    }
});
</script>
<script>
   $('#type').on('click', function() {
    var val = $(this).val();

      $('#Max').hide();

      if(val == 0)
      {
        $('#Max').show();
        $('#Max').css('display','flex');

        if(val==""){
            $('#Max').hide();
        }
        
      }
      else{
        $('#Max').hide();
      }

});
</script>
@endsection

