@extends('layouts.front')
@section('content')
    
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <ul class="pages">
               <li>
                  <a href="{{route('front.index')}}">{{ $langg->lang17 }}</a>
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
         @include('includes.catalog')
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
@endsection
