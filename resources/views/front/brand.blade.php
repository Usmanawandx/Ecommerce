@extends('layouts.front')
@section('content')
        @if($brand->slider_status == 1)
        <section class="hero-area">
			@if($brand->slider != null)
			    <div class="row">
                    <div class="item col-12">
                        <div class="itm-dsk">
                                <a href="{{$brand->link}}" target="blank"><img src="{{asset('assets/images/brands/'.$brand->slider)}}" alt="" style="width:100%; height:400px"></a>
                        </div>
                    </div>
                </div>
			@endif
		</section>
		@endif
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <ul class="pages">
               <li>
                  <a href="{{route('front.index')}}">{{ $langg->lang17 }}</a>
               </li>
               <li>
                <a href="{{route('front.category.brand',$brand->slug)}}">{{ $brand->name }}</a>
                </li>
            </ul>
         </div>
      </div>
   </div>
</div>
<!-- Breadcrumb Area End -->
<!-- SubCategori Area Start -->
<section class="sub-categori">
   <div class="container">
      <div class="row">
         @include('includes.brandcatalog')
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
          filterlink += '{{route('front.category.brand', [Request::route('slug')])}}' + '?'+'child_category[]'+'='+$(this).attr('id');
        } else {
          filterlink += '&'+'child_category[]'+'='+$(this).attr('id');
        }
      }
    });
    if ($("#sortby").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category.brand',[Request::route('slug')])}}' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortby").attr('name')+'='+$("#sortby").val();
      }
    }

    if ($("#min_price").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category.brand',[Request::route('slug')])}}' + '?'+$("#min_price").attr('name')+'='+$("#min_price").val();
      } else {
        filterlink += '&'+$("#min_price").attr('name')+'='+$("#min_price").val();
      }
    }

    if ($("#max_price").val() != '') {
      if (filterlink == '') {
        filterlink += '{{route('front.category.brand',[Request::route('slug')])}}' + '?'+$("#max_price").attr('name')+'='+$("#max_price").val();
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

      let fullUrl = '{{route('front.category.brand', [Request::route('slug')])}}?page='+page+'&search='+'{{request()->input('search')}}';

    //   $(".attribute-input").each(function() {
    //     if ($(this).is(':checked')) {
    //       fullUrl += '&'+encodeURI($(this).attr('name'))+'='+encodeURI($(this).val());
    //     }
    //   });
      $(".categoryBox").each(function() {
      if ($(this).is(':checked')) {
            fullUrl += '&child_category[]'+'='+$(this).attr('id');
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
@endsection
