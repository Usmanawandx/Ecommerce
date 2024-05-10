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
            <a href="{{ route('front.cmspage',$page->page_slug) }}">
              {{ $page->page_title }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Breadcrumb Area End -->

    @if($page->slider_status == 1)
		<!-- Hero Area Start -->
		<section class="hero-area">
			@if($page->slider_status == 1)
                <?php $sliders = explode(",",$page->top_sliders) ?>

			    <div class="owl-carousel owl-theme">
			        @foreach($sliders as $key => $data)
                    {{-- {{dd($data)}} --}}
                    <div class="item">
                        <div class="itm-dsk">
                            <a href="#">
                                <img src="{{asset('assets/images/sliders/cmspage/'.$data)}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="itm-tab">
                            <a href="#">
                                <img src="{{asset('assets/images/sliders/cmspage/'.$data)}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="itm-mob">
                            <a href="#">
                                <img src="{{asset('assets/images/sliders/cmspage/'.$data)}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>
			@endif
		</section>
		<!-- Hero Area End -->
	@endif
    @if($page->block1_status == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block1_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block1_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner1 = explode(",",$page->block1_banner);
                $banner1 = array_slice($banner1, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner1 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
    @if($page->block2_status == 2)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block2_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block2_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner2 = explode(",",$page->block2_banner);
                $banner2 = array_slice($banner2, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner2 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
    @if($page->block3_status == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block3_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block3_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner3 = explode(",",$page->block3_banner);
                $banner3 = array_slice($banner3, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner3 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
    @if($page->block4_status == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block4_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block4_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner4 = explode(",",$page->block4_banner);
                $banner4 = array_slice($banner4, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner4 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
    @if($page->block5_status == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block5_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block5_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner5 = explode(",",$page->block5_banner);
                $banner5 = array_slice($banner5, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner5 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
    @if($page->block6_status == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{$page->block6_title}}
							</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
                            <?php
                                $ids = explode(',',$page->block6_skus);
                                $products = App\Models\Product::whereIn('id',$ids)->get();
                            ?>
							@foreach($products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
        <!-- Banner Area One Start -->
        <section class="banner-section">
        <div class="container">
            <?php
                $banner6 = explode(",",$page->block6_banner);
                $banner6 = array_slice($banner6, 0, 2);
            ?>
                <div class="row">
                    @foreach($banner6 as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="#" target="_blank">
                                    <img src="{{asset('assets/images/banners/cmspage/'.$img)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        </section>
    <!-- Banner Area One Start -->
	@endif
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        autoPlaySpeed: 5000,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 1,
          },
          1000: {
            items: 1,
            loop: false,
            margin: 20
          }
        }
      })
    })
  </script>
@endsection
