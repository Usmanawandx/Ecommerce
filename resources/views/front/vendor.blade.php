@extends('layouts.front')
@section('content')

<!-- Vendor Area Start -->
  <div class="vendor-banner" style="background: url({{  $vendor->shop_image != null ? asset('assets/images/vendorbanner/'.$vendor->shop_image) : '' }}); background-repeat: no-repeat; background-size: cover;background-position: center;{!! $vendor->shop_image != null ? '' : 'background-color:'.$gs->vendor_color !!} ">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <p class="sub-title">
                {{ $langg->lang226 }}
            </p>
            <h2 class="title">
              {{ $vendor->shop_name }}
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>


{{-- Info Area Start --}}
<section class="info-area">
  <div class="container">


        @foreach($services->chunk(4) as $chunk)

        <div class="row">

        <div class="col-lg-12 p-0">
          <div class="info-big-box">
              <div class="row">
                @foreach($chunk as $service)
              <div class="col-6 col-xl-3 p-0">
                <div class="info-box">
                  <div class="icon">
                    <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                  </div>
                  <div class="info">
                      <div class="details">
                        <h4 class="title">{{ $service->title }}</h4>
                      <p class="text">
                        {!! $service->details !!}
                      </p>
                      </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
          </div>
        </div>

        </div>

          @endforeach


        </div>
</section>
{{-- Info Area End  --}}




<!-- SubCategori Area Start -->
<section class="sub-categori">
    <div class="container">
       <div class="row">
          @include('includes.vendor-catalog')
          <div class="col-lg-9 order-first order-lg-last ajax-loader-parent">
             <div class="right-area" id="app">

                @include('includes.filter')
                <div class="categori-item-area">
                  <div class="row" id="ajaxContent">
                    @include('includes.product.filtered-products')
                  </div>
                  <div id="ajaxLoader" class="ajax-loader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center rgba(0,0,0,.6);"></div>
                </div>

             </div>
          </div>
       </div>
    </div>
 </section>
<!-- SubCategori Area End -->


@if(Auth::guard('web')->check())

{{-- MESSAGE VENDOR MODAL --}}

<div class="message-modal">
  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1">{{ $langg->lang118 }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-form">

                <form id="emailreply">
                  {{csrf_field()}}
                  <ul>

                    <li>
                      <input type="text" class="input-field" readonly="" placeholder="Send To {{ $vendor->shop_name }}" readonly="">
                    </li>

                    <li>
                      <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ $langg->lang119}}" required="">
                    </li>

                    <li>
                      <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ $langg->lang120 }}" required=""></textarea>
                    </li>

                    <input type="hidden" name="email" value="{{ Auth::guard('web')->user()->email }}">
                    <input type="hidden" name="name" value="{{ Auth::guard('web')->user()->name }}">
                    <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

                  </ul>
                  <button class="submit-btn" id="emlsub1" type="submit">{{ $langg->lang118 }}</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- MESSAGE VENDOR MODAL ENDS --}}


@endif

@endsection

@section('scripts')

<script type="text/javascript">

  $(function () {
    $("#slider-range").slider({
    range: true,
    orientation: "horizontal",
    min: 0,
    max: 10000000,
    values: [{{ isset($_GET['min']) ? $_GET['min'] : '0' }}, {{ isset($_GET['max']) ? $_GET['max'] : '10000000' }}],
    step: 5,

    slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
        return false;
      }

      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

  });

  $(document).ready(function(){
        $(".attribute-input, #sortby").on('change', function() {
        $("#ajaxLoader").show();
        filter();
        });
        $(".categoryBox").on('change',function(){
        $("#ajaxLoader").show();
        filter();
        })
        $(".brandBox").on('change',function(){
        $("#ajaxLoader").show();
        filter();
        })
        $('.filter-btn').on('click',function(e){
            e.preventDefault();
            $("#ajaxLoader").show();
            filter();
        })
    })
    function filter() {
    let filterlink = '';

    // if ($("#prod_name").val() != '') {
    //   if (filterlink == '') {
    //     filterlink += '{{route('front.category.brand',[Request::route('slug')])}}' + '?search='+$("#prod_name").val();
    //   } else {
    //     filterlink += '&search='+$("#prod_name").val();
    //   }
    // }
    $(".categoryBox").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.vendor', [Request::route('slug')])}}' + '?'+'child_category[]'+'='+$(this).attr('id');
        } else {
          filterlink += '&'+'child_category[]'+'='+$(this).attr('id');
        }
      }
    });
    $(".brandBox").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '{{route('front.vendor', [Request::route('slug')])}}' + '?'+'brand[]'+'='+$(this).attr('id');
        } else {
          filterlink += '&'+'brand[]'+'='+$(this).attr('id');
        }
      }
    });
    if ($("#sortby").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.vendor',[Request::route('slug')])}}' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortby").attr('name')+'='+$("#sortby").val();
      }
    }

    if ($("#min_price").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.vendor',[Request::route('slug')])}}' + '?'+$("#min_price").attr('name')+'='+$("#min_price").val();
      } else {
        filterlink += '&'+$("#min_price").attr('name')+'='+$("#min_price").val();
      }
    }

    if ($("#max_price").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.vendor',[Request::route('slug')])}}' + '?'+$("#max_price").attr('name')+'='+$("#max_price").val();
      } else {
        filterlink += '&'+$("#max_price").attr('name')+'='+$("#max_price").val();
      }
    }
    console.log(filterlink);
    console.log(encodeURI(filterlink));
    $("#ajaxContent").load(encodeURI(filterlink), function(data) {
        window.history.pushState({path:filterlink},'',filterlink);
      // add query string to pagination
      addToPagination();
      $("#ajaxLoader").fadeOut(1000);

    });
    }
    function addToPagination() {
    // add to attributes in pagination links
    $('ul.pagination li a').each(function() {
      let url = $(this).attr('href');
      let queryString = '?' + url.split('?')[1]; // "?page=1234...."

      let urlParams = new URLSearchParams(queryString);
      let page = urlParams.get('page'); // value of 'page' parameter

      let fullUrl = '{{route('front.vendor', [Request::route('slug')])}}?page='+page+'&search='+'{{request()->input('search')}}';

      $(".attribute-input").each(function() {
        if ($(this).is(':checked')) {
          fullUrl += '&'+encodeURI($(this).attr('name'))+'='+encodeURI($(this).val());
        }
      });
      $(".categoryBox").each(function() {
      if ($(this).is(':checked')) {
            fullUrl += '&child_category[]'+'='+$(this).attr('id');
      }
    });
      $(".brandBox").each(function() {
      if ($(this).is(':checked')) {
            fullUrl += '&brand[]'+'='+$(this).attr('id');
      }
    });
      if ($("#sortby").val() != '') {
        fullUrl += '&sort='+encodeURI($("#sortby").val());
      }

      if ($("#min_price").val() != '') {
        fullUrl += '&min='+encodeURI($("#min_price").val());
      }

      if ($("#max_price").val() != '') {
        fullUrl += '&max='+encodeURI($("#max_price").val());
      }

      $(this).attr('href', fullUrl);
      window.history.pushState({path:fullUrl},'',fullUrl);
    });
  }
  $(document).on('click', '.categori-item-area .pagination li a', function (event) {
    event.preventDefault();
    if ($(this).attr('href') != '#' && $(this).attr('href')) {
      $('#preloader').show();
      $('#ajaxContent').load($(this).attr('href'), function (response, status, xhr) {
        if (status == "success") {
          $('#preloader').fadeOut();
          $("html,body").animate({
            scrollTop: 0
          }, 1);

          addToPagination();
        }
      });
    }

  });
</script>

<script type="text/javascript">
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          var vendor_id = $(this).find('input[name=vendor_id]').val();
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/vendor/contact')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id,
                'vendor_id'  : vendor_id
                  },
            success: function() {
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("{{ $langg->message_sent }}");
        $('.ti-close').click();
            }
        });
          return false;
        });
</script>


@endsection
