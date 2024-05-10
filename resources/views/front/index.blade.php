    @extends('layouts.front')

@section('content')

	@if($ps->slider == 1)

		@if(count($sliders))
			@include('includes.slider-style')
		@endif
	@endif

	@if($ps->slider == 1)
		<!-- Hero Area Start -->
		<section class="hero-area">
			@if($ps->slider == 1)

			    <div class="owl-carousel owl-theme">
			        @foreach($sliders as $data)
                    <div class="item">
                        <div class="itm-dsk">
                            <a href="{{$data->link}}">
                                <img src="{{asset('assets/images/sliders/'.$data->photo)}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="itm-tab">
                            <a href="{{$data->link_ipad}}">
                                <img src="{{asset('assets/images/sliders/'.$data->photo_ipad)}}" alt="" loading="lazy">
                            </a>
                        </div>
                        <div class="itm-mob">
                            <a href="{{$data->link_mobile}}">
                                <img src="{{asset('assets/images/sliders/'.$data->photo_mobile)}}" alt="" loading="lazy">
                            </a>
                        </div>
                    </div>
                    @endforeach
                    <!--<div class="item">-->
                    <!--    <div class="itm-dsk">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 1600x500.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--    <div class="itm-tab">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 1080x400.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--    <div class="itm-mob">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 500x300.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="item">-->
                    <!--    <div class="itm-dsk">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 1600x500.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--    <div class="itm-tab">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 1080x400.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--    <div class="itm-mob">-->
                    <!--        <img src="{{ asset('assets/front/images/iphone 500x300.jpg')}}" alt="">-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>


				<!--@if(count($sliders))
					<div class="hero-area-slider">
						<div class="slide-progress"></div>
						<div class="intro-carousel">
							@foreach($sliders as $data)
								<div class="intro-content {{$data->position}}" style="background-image: url({{asset('assets/images/sliders/'.$data->photo)}})">
									<div class="container">
										<div class="row">
											<div class="col-lg-12">
												<div class="slider-content">

													<div class="layer-1">
														<h4 style="font-size: {{$data->subtitle_size}}px; color: {{$data->subtitle_color}}" class="subtitle subtitle{{$data->id}}" data-animation="animated {{$data->subtitle_anime}}">{{$data->subtitle_text}}</h4>
														<h2 style="font-size: {{$data->title_size}}px; color: {{$data->title_color}}" class="title title{{$data->id}}" data-animation="animated {{$data->title_anime}}">{{$data->title_text}}</h2>
													</div>

													<div class="layer-2">
														<p style="font-size: {{$data->details_size}}px; color: {{$data->details_color}}"  class="text text{{$data->id}}" data-animation="animated {{$data->details_anime}}">{{$data->details_text}}</p>
													</div>

													<div class="layer-3">
														<a href="{{$data->link}}" target="_blank" class="mybtn1"><span>{{ $langg->lang25 }} <i class="fas fa-chevron-right"></i></span></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endif-->

			@endif

		</section>
		<!-- Hero Area End -->
	@endif


	<!--@if($ps->featured_category == 1)-->

	<!--{{-- Slider buttom Category Start --}}-->
	<!--<section class="slider-buttom-category d-none d-md-block">-->
	<!--	<div class="container-fluid">-->
	<!--		<div class="row">-->
	<!--			@foreach($categories->where('is_featured','=',1) as $cat)-->
	<!--				<div class="col-xl-2 col-lg-3 col-md-4 sc-common-padding">-->
	<!--					<a href="{{ route('front.category',$cat->slug) }}" class="single-category">-->
	<!--						<div class="left">-->
	<!--							<h5 class="title">-->
	<!--								{{ $cat->name }}-->
	<!--							</h5>-->
	<!--							<p class="count">-->
	<!--								{{ count($cat->products) }} {{ $langg->lang4 }}-->
	<!--							</p>-->
	<!--						</div>-->
	<!--						<div class="right">-->
	<!--							{{-- <img src="{{asset('assets/images/categories/'.$cat->image) }}" alt=""> --}}-->
	<!--						</div>-->
	<!--					</a>-->
	<!--				</div>-->
	<!--			@endforeach-->
	<!--		</div>-->
	<!--	</div>-->
	<!--</section>-->
	<!--{{-- Slider buttom banner End --}}-->

	<!--@endif-->

	@if($ps->featured == 1)
		<!-- Trending Item Area Start -->
		<section  class="categori-item electronics-section trend">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="section-top">
							<h2 class="section-title">
								{{ $langg->lang26 }} Products
							</h2>
							{{-- <a href="#" class="link">View All</a> --}}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 remove-padding">
						<div class="trending-item-slider">
							@foreach($feature_products as $prod)
								@include('includes.product.slider-product')
							@endforeach
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- Tranding Item Area End -->
	@endif

	@if($ps->small_banner == 1)

		<!-- Banner Area One Start -->
		<section class="banner-section">
			<div class="container">
				@foreach($top_small_banners->chunk(2) as $chunk)
					<div class="row">
						@foreach($chunk as $img)
							<div class="col-lg-6 remove-padding">
								<div class="left">
									<a class="banner-effect" href="{{ $img->link }}" target="_blank">
										<img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
									</a>
								</div>
							</div>
						@endforeach
					</div>
				@endforeach
			</div>
		</section>
		<!-- Banner Area One Start -->
	@endif

	<section id="extraData">
		<div class="text-center">
			<img src="{{asset('assets/images/'.$gs->loader)}}">
		</div>
	</section>


@endsection

@section('scripts')
	<script>
        $(window).on('load',function() {

            setTimeout(function(){

                $('#extraData').load('{{route('front.extraIndex')}}');

            }, 500);
        });
        $("#select_seller").change(function(){
            var val = $(this).val();
            if(val == 11){
                $("input[name='address']").eq(1).parent().hide();
                $("input[name='shop_name']").parent().hide();
                $("input[name='owner_name']").parent().hide();
                $("input[name='shop_number']").parent().hide();
                $("input[name='shop_address']").parent().hide();
                $("input[name='reg_number']").parent().hide();
                $("input[name='shop_message']").parent().hide();
                $("input[name='shop_message'],input[name='reg_number'],input[name='shop_address'],input[name='shop_number'],input[name='owner_name'],input[name='shop_name']").removeAttr("required");
                $("input[name='address']").eq(1).removeAttr("required");
            }else{
                $("input[name='address']").eq(1).parent().show();
                $("input[name='shop_name']").parent().show();
                $("input[name='owner_name']").parent().show();
                $("input[name='shop_number']").parent().show();
                $("input[name='shop_address']").parent().show();
                $("input[name='reg_number']").parent().show();
                $("input[name='shop_message']").parent().show();
                $("input[name='address']").eq(1).atstr("required");
                $("input[name='shop_message'],input[name='reg_number'],input[name='shop_address'],input[name='shop_number'],input[name='owner_name'],input[name='shop_name']").attr("required");
            }
        });
	</script>

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
          <script>
                const getUA = () => {
                    let device = "Unknown";
                    const ua = {
                        "Generic Linux": /Linux/i,
                        "Android": /Android/i,
                        "BlackBerry": /BlackBerry/i,
                        "Bluebird": /EF500/i,
                        "Chrome OS": /CrOS/i,
                        "Datalogic": /DL-AXIS/i,
                        "Honeywell": /CT50/i,
                        "iPad": /iPad/i,
                        "iPhone": /iPhone/i,
                        "iPod": /iPod/i,
                        "macOS": /Macintosh/i,
                        "Windows": /IEMobile|Windows/i,
                        "Zebra": /TC70|TC55/i,
                    }
                    Object.keys(ua).map(v => navigator.userAgent.match(ua[v]) && (device = v));
                    return device;
                }
              function fnBrowserDetect(){

                 let userAgent = navigator.userAgent;
                 let browserName;

                 if(userAgent.match(/chrome|chromium|crios/i)){
                     browserName = "chrome";
                   }else if(userAgent.match(/firefox|fxios/i)){
                     browserName = "firefox";
                   }  else if(userAgent.match(/safari/i)){
                     browserName = "safari";
                   }else if(userAgent.match(/opr\//i)){
                     browserName = "opera";
                   } else if(userAgent.match(/edg/i)){
                     browserName = "edge";
                   }else{
                     browserName="No browser detection";
                   }
                   return browserName;
                }
              $(document).ready(function() {
                  device = getUA(),
                  browser = fnBrowserDetect(),
                    dataLayer.push({
                        'event': 'pageView',
                        'device': device,
                        'browser': browser,
                    })
              })
          </script>
@endsection
