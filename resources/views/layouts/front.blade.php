<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
		<title>{{$gs->title}}</title>
    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
		<title>{{$gs->title}}</title>
    @elseif(isset($productt))
		<meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
		<meta name="description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
	    <meta property="og:title" content="{{$productt->name}}" />
	    <meta property="og:description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
	    <meta name="author" content="GeniusOcean">
    	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
    @else
	    {{-- <meta name="keywords" content="{{ $seo->meta_keys }}"> --}}
	    <meta name="author" content="GeniusOcean">
		<title>{{$gs->title}}</title>
    @endif
	<!-- favicon -->
	<link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/>


@if($langg->rtl == "1")

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{asset('assets/front/css/rtl/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/dilawar.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/naseem.css')}}">
    <!--Updated CSS-->
    <link rel="stylesheet" href="{{ asset('assets/front/css/rtl/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">

@else

<!-- stylesheet -->
	{{-- <link rel="stylesheet" href="{{asset('assets/front/css/all.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('project/public/css/app.css')}}">
<!-- stylesheet -->
	{{-- <link rel="stylesheet" href="{{asset('assets/front/css/dilawar.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/naseem.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/splide.min.css')}}"> --}}
    <!--Updated CSS-->
    <link rel="stylesheet" href="{{ asset('assets/front/css/styles.php?color='.str_replace('#','',$gs->colors).'&amp;'.'header_color='.str_replace('#','',$gs->header_color).'&amp;'.'footer_color='.str_replace('#','',$gs->footer_color).'&amp;'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&amp;'.'menu_color='.str_replace('#','',$gs->menu_color).'&amp;'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}">
   
@endif



	@yield('styles')
	<!--<script src="https://cdn.onesignal.com/sdks/OneSignalSDKWorker.js" ></script>-->
	<!--<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>-->
	<script src="{{asset('assets/front/js/onesignalscript.js')}}" defer></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
      OneSignal.showNativePrompt();
    OneSignal.init({
      appId: "b92110ee-e5c6-4b6e-89a9-d248e7027761",
      safari_web_id: "web.onesignal.auto.4e6ae055-7872-4c1f-b42a-6c60bed16bbe",
      notifyButton: {
        enable: true,
      },
    });
  });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-195215053-1"></script>-->
<!--<script>-->

<!--  window.dataLayer = window.dataLayer || [];-->
<!--  function gtag(){dataLayer.push(arguments);}-->
<!--  gtag('js', new Date());-->

<!--  gtag('config', 'UA-195215053-1');-->
<!--</script>-->
	<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MTMZ999');</script>
	<!-- End Google Tag Manager -->
</head>

<body>
    <!--<div class='onesignal-customlink-container'></div>-->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MTMZ999"
				  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@if($gs->is_loader == 1)
	<div class="preloader" id="preloader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
	@endif
	<div class="xloader d-none" id="xloader" style="background: url({{asset('assets/front/images/xloading.gif')}}) no-repeat scroll center center #FFF;"></div>

@if($gs->is_popup== 1)

@if(isset($visited))
    <div style="display:none">
        <img src="{{asset('assets/images/'.$gs->popup_background)}}">
    </div>

    <!--  Starting of subscribe-pre-loader Area   -->
    <div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
        <div class="subscribePreloader__thumb" style="background-image: url({{asset('assets/images/'.$gs->popup_background)}});">
            <span class="preload-close"><i class="fas fa-times"></i></span>
            <div class="subscribePreloader__text text-center">
                <h1>{{$gs->popup_title}}</h1>
                <p>{{$gs->popup_text}}</p>
                <form action="{{route('front.subscribe')}}" id="subscribeform" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="email" name="email"  placeholder="{{ $langg->lang741 }}" required="">
                        <button id="sub-btn" type="submit">{{ $langg->lang742 }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  Ending of subscribe-pre-loader Area   -->

@endif

@endif


	{{-- <section class="top-header">
		<div class="container">
		    
			<div class="row">
				<div class="col-lg-12 remove-padding">
					<div class="content">
						<div class="left-content">
							<div class="list">
								<ul>
									@if($gs->is_language == 1)
									<li>
										<div class="language-selector">
											<i class="fas fa-globe-americas"></i>
											<select name="language" class="language selectors nice">
										@foreach(DB::table('languages')->get() as $language)
											<option value="{{route('front.language',$language->id)}}" {{ Session::has('language') ? ( Session::get('language') == $language->id ? 'selected' : '' ) : ( $language->is_default == 1 ? 'selected' : '') }} >{{$language->language}}</option>
										@endforeach
											</select>
										</div>
									</li>
									@endif

									@if($gs->is_currency == 1)
									<li>
										<div class="currency-selector">
								<span>{{ Session::has('currency') ?   DB::table('currencies')->where('id','=',Session::get('currency'))->first()->sign   : DB::table('currencies')->where('is_default','=',1)->first()->sign }}</span>
										<select name="currency" class="currency selectors nice">
										@foreach(DB::table('currencies')->get() as $currency)
											<option value="{{route('front.currency',$currency->id)}}" {{ Session::has('currency') ? ( Session::get('currency') == $currency->id ? 'selected' : '' ) : ( $currency->is_default == 1 ? 'selected' : '') }} >{{$currency->name}}</option>
										@endforeach
										</select>
										</div>
									</li>
									@endif


								</ul>
							</div>
						</div>
						<div class="right-content">
							<div class="list">
								<ul>
                                    <li>
                                        <a href="https://ecpmarket.com/investment/account/login" target="_blank">Investor Login</a>
                                    </li>
									@if(!Auth::guard('web')->check())
									<li class="login">
										<a href="{{ route('user.login') }}" class="sign-log">
											<div class="links">
												<span class="sign-in">{{ $langg->lang12 }}</span> <span>|</span>
												<span class="join">{{ $langg->lang13 }}</span>
											</div>
										</a>
									</li>
									@else
										<li class="profilearea my-dropdown">
											<a href="javascript: ;" id="profile-icon" class="profile carticon">
												<span class="text">
													<i class="far fa-user"></i>	{{ $langg->lang11 }} <i class="fas fa-chevron-down"></i>
												</span>
											</a>
											<div class="my-dropdown-menu profile-dropdown">
												<ul class="profile-links">
													<li>
														<a href="{{ route('user-dashboard') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang221 }}</a>
													</li>
													@if(Auth::user()->IsVendor())
													<li>
														<a href="{{ route('vendor-dashboard') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang222 }}</a>
													</li>
													@endif

													<li>
														<a href="{{ route('user-profile') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang205 }}</a>
													</li>

													<li>
														<a href="{{ route('user-logout') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang223 }}</a>
													</li>
												</ul>
											</div>
										</li>
									@endif


                        			@if($gs->reg_vendor == 1)
										<li>
                        				@if(Auth::check())
	                        				@if(Auth::guard('web')->user()->is_vendor == 2)
	                        					<a href="{{ route('vendor-dashboard') }}" class="sell-btn">{{ $langg->lang220 }}</a>
	                        				@else
	                        					<a href="{{ route('user-package') }}" class="sell-btn">{{ $langg->lang220 }}</a>
	                        				@endif
										</li>
                        				@else
										<li>
											<a href="javascript:;" data-toggle="modal" data-target="#vendor-login" class="sell-btn">{{ $langg->lang220 }}</a>
										</li>
										@endif
									@endif


								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> --}}
	<!-- Top Header Area End -->

	<!-- Logo Header Area Start -->
	<section class="ecp-tb">
	    <div class="container">
	        <div class="row">
		        <div class="col-md-6 col-sm-12">
		            <div class="ecp-tb-left">
		                <ul>
		                    <li><a href="tel:02135662201"><i class="fa fa-phone"></i> 021-35662201-3</a></li>
		                    <li><a href="http://wa.me//923322450119"><img src="https://ecpmarket.com/assets/front/images/payment-method/whatsapp.png"> 0332-2450119</a></li>
		                </ul>
		            </div>
		        </div>
		        <div class="col-md-6 col-sm-12">
		            <div class="ecp-tb-right">
		                <ul>
		                    <li>
		                        @if($gs->reg_vendor == 1)
                                @if(Auth::check())
                                    @if(Auth::guard('web')->user()->is_vendor == 2)
                                        <a href="{{ route('vendor-dashboard') }}">Sell With Us</a>
                                    @else
                                        {{-- <a href="{{ route('user-package') }}" class="sell-btn">Become a partner</a> --}}
                                    @endif
                                @else
                                    {{-- <a href="javascript:;" data-toggle="modal" data-target="#vendor-login">Sell With Us</a> --}}
                                    <a href="{{route('vendorLogin')}}">Sell With US</a>
                                @endif
    						    @endif
		                    </li>
		                    <li><a href="#" data-toggle="modal" data-target="#track-order-modal">Track my order</a></li>
		                    <li>
		                        <a href="{{ route('user.login') }}">
		                           @if(Auth::guard('web')->check())
		                            {{Auth::guard('web')->user()->name}}
		                           @else
		                            Register
		                           @endif
		                            </a>
		                    </li>
		                    <li>
		                        @if(Auth::guard('web')->check())
		         <!--                           <div class="dropdown">-->
		         <!--                               <div>-->
		         <!--                                   <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-angle-double-right"></i></a>-->
		         <!--                               </div>-->
		         <!--                               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
											<!--			<a href="{{ route('user-dashboard') }}" class="dropdown-item"><i class="fas fa-angle-double-right"></i> {{ $langg->lang221 }}</a>-->
											<!--		@if(Auth::user()->IsVendor())-->
											<!--			<a href="{{ route('vendor-dashboard') }}" class="dropdown-item"><i class="fas fa-angle-double-right"></i> {{ $langg->lang222 }}</a>-->
											<!--		@endif-->
											<!--			<a href="{{ route('user-profile') }}" class="dropdown-item"><i class="fas fa-angle-double-right"></i> {{ $langg->lang205 }}</a>-->
											<!--			<a href="{{ route('user-logout') }}" class="dropdown-item"><i class="fas fa-angle-double-right"></i> {{ $langg->lang223 }}</a>-->
											<!--	</ul>-->
											<!--	</div>-->
											<!--</div>-->
		                        @else
		                        <a href="{{ route('user.login') }}">Sign In</a>
		                        @endif
		                    </li>
		                </ul>
		            </div>
		        </div>
		    </div>
	    </div>    
	</section>
	
	<section class="logo-header">
		<div class="container">
		    <div class="row">
		        <div class="col-md-2 col-sm-12">
		            <div class="mob-nav-icn">
			            <div class="cat-mob">
					    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
                        	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        	    <span class="navbar-toggler-icon">
                        	    </span>
                        	</button>
                        	<!--<div class="nav-bg-ov navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"></div>-->
                        	<div class="collapse navbar-collapse bg-dark" id="navbarCollapse" style="overflow:scroll">
                            	<button class="navbar-toggler mn-close" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            	    <img src="{{ asset('assets/front/images/payment-method/nav-icn.png')}}" alt="">
                            	</button>
                            	
    					        <h5 class="mn-hd">CATEGORIES</h5>
                        		<ul class="navbar-nav mr-auto sd-menu">
                        			
                        			<li class="nav-item">
                        			@foreach($categories as $category)
                        			<?php
                        			    $idnam = substr($category->name, 0, 2).''.$category->id;
                        			?>
                        				<a class="nav-link" href="{{ route('front.category',$category->slug) }}">{{ $category->name }} <span id="accordion"><i class="fa fa-caret-down text-right collapsed" data-toggle="collapse" data-target="{{'#'.$idnam}}" aria-expanded="false" aria-controls="{{$idnam}}"></i></span></a>
                        				@if(count($category->subs) > 0)
                        			    <ul id="{{$idnam}}" class="collapse sb-menu" aria-labelledby="headingThree" data-parent="#accordion">
                        			        @foreach($category->subs()->whereStatus(1)->get() as $subcat)
                        			        <?php
                                			    $idsubnam = substr($subcat->name, 0, 2).''.$subcat->id;
                                			?>
                        			        <li>
                        			            <a class="nav-link nav-child-link" href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}<span id="accordion"><i class="fa fa-caret-down text-right collapsed" data-toggle="collapse" data-target="{{'#'.$idsubnam}}" aria-expanded="false" aria-controls="{{$idsubnam}}"></i></span></a>
                        			            @if(count($subcat->childs) > 0)
                        			            <ul id="{{$idsubnam}}" class="collapse sb-menu" aria-labelledby="headingFive" data-parent="#accordion">
                        			                @foreach($subcat->childs()->whereStatus(1)->get() as $childcat)
                                			        <li><a href="{{ route('front.childcat',['slug1' => $category->slug, 'slug2' => $subcat->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
                                			        @endforeach
                                			    </ul>
                                			    @endif
                        			        </li>
                        			        @endforeach
                        			    </ul>
                        			    @endif
                        			@endforeach
                        			</li>
                        		</ul>
                        	</div>
                        </nav>
					</div>
			        </div>
			        <div class="logo">
						<a href="{{ route('front.index') }}">
							<img src="{{asset('assets/images/'.$gs->logo)}}" alt="">
						</a>
					</div>
		        </div>
		        
		        <div class="col-md-8 col-sm-12 cat-col">
		            <div class="search-box-wrapper">
                        <div class="categori-container" id="catSelectForm">
							<select name="category" id="category_select" class="categoris">
								<option value="">{{ $langg->lang1 }}</option>
								@foreach($categories as $data)
								<option value="{{ $data->slug }}" {{ Request::route('category') == $data->slug ? 'selected' : '' }}>{{ $data->name }}</option>
								@endforeach
							</select>
						</div> 
						<div class="search-box">
							<form id="searchForm" class="search-form pl-0" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
								@if (!empty(request()->input('sort')))
									<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
								@endif
								@if (!empty(request()->input('minprice')))
									<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
								@endif
								@if (!empty(request()->input('maxprice')))
									<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
								@endif
								<input type="text" id="prod_name" class="P-0 prod_name" name="search" placeholder="{{ $langg->lang2 }}" value="{{ request()->input('search') }}" autocomplete="off">
								<div class="autocomplete">
								  <div id="myInputautocomplete-list" class="autocomplete-items myInputautocomplete-list">
								  </div>
								</div>
								<button type="submit"><i class="icofont-search-1"></i></button>
							</form>
						</div>
					</div>
		        </div>
		        
		        <div class="col-md-2 col-sm-12">
				    <div class="mob-icns">
				        <div class="search-wrapper">
                            <div class="input-holder">
                                <form id="searchForm" class="search-form pl-0" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
    								@if (!empty(request()->input('sort')))
    									<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
    								@endif
    								@if (!empty(request()->input('minprice')))
    									<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
    								@endif
    								@if (!empty(request()->input('maxprice')))
    									<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
    								@endif
    								<input type="text" id="prod_name" class="P-0 search-input prod_name" name="search" placeholder="{{ $langg->lang2 }}" value="{{ request()->input('search') }}" autocomplete="off">
    								<div class="autocomplete">
    								  <div id="myInputautocomplete-list" class="autocomplete-items myInputautocomplete-list">
    								  </div>
    								</div>
    								<button type="submit" class="search-icon" onclick="searchToggle(this, event);"><span class="icofont-search-1"></span></button>
    							</form>
                            </div>
                            <span class="close" onclick="searchToggle(this, event);">
                                <i class="fa fa-times"></i>
                            </span>
                        </div>
				    </div>
				    <nav class="helpful-links" hidden>
						<ul class="menu helpful-links-inner">
                            <li class="my-dropdown"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang3 }}">
								<a href="javascript:;" class="cart carticon">
									<div class="icon">
										<i class="icofont-cart"></i>
										<span class="cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
									</div>

								</a>
								<div class="my-dropdown-menu" id="cart-items">
									@include('load.cart')
								</div>
							</li>
							<li class="wishlist"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang9 }}">
								@if(Auth::guard('web')->check())
									<a href="{{ route('user-wishlists') }}" class="wish">
										<i class="far fa-heart"></i>
										<span id="wishlist-count">{{ Auth::user()->wishlistCount() }}</span>
									</a>
								@else
									<a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="wish">
										<i class="far fa-heart"></i>
										<span id="wishlist-count">0</span>
									</a>
								@endif
							</li>
							<li class="compare"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang10 }}">
								<a href="{{ route('product.compare') }}" class="wish compare-product">
									<div class="icon">
										<i class="fas fa-exchange-alt"></i>
										<span id="compare-count">{{ Session::has('compare') ? count(Session::get('compare')->items) : '0' }}</span>
									</div>
								</a>
							</li>
							{{-- @if($gs->is_home == 1)
							<li><a href="{{ route('front.index') }}">{{ $langg->lang17 }}</a></li>
							@endif
							@if (DB::table('pagesettings')->find(1)->review_blog==1)
								<li class="active" ><a  href="{{ route('front.blog') }}">{{ $langg->lang18 }}</a></li>
							@endif
							@if($gs->is_faq == 1)
							<li><a href="{{ route('front.faq') }}">{{ $langg->lang19 }}</a></li>
							@endif
							@foreach(DB::table('pages')->where('header','=',1)->get() as $data)
								<li><a href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a></li>
							@endforeach
							@if($gs->is_contact == 1)
							<li><a href="{{ route('front.contact') }}">{{ $langg->lang20 }}</a></li>
							@endif
							<li>
								<a href="javascript:;" data-toggle="modal" data-target="#track-order-modal" class="track-btn">{{ $langg->lang16 }}</a>
							</li> --}}
						</ul>
					</nav>
		        </div>
		    </div>
		    
			
		</div>
	</section>
	<!-- Logo Header Area End -->

	<!--Main-Menu Area Start-->
	<div class="mainmenu-area mainmenu-bb">
		<div class="container">
			<div class="row align-items-center mainmenu-area-innner">
				<div class="col-lg-3 col-md-6 categorimenu-wrapper remove-padding">
					<!--categorie menu start-->
					<div class="categories_menu">
						<div class="categories_title">
							<h2 class="categori_toggle"><i class="fa fa-bars"></i>  {{ $langg->lang14 }} <i class="fa fa-angle-down arrow-down"></i></h2>
						</div>
						<div class="categories_menu_inner">
							<ul>

								@foreach($categories as $category)

								<li class="{{count($category->subs) > 0 ? 'dropdown_list':''}} {{ $loop->index >= 14 ? 'rx-child' : '' }}">
								@if(count($category->subs) > 0)
									<div class="img">
										{{-- <img src="{{ asset('assets/images/categories/'.$category->photo) }}" alt=""> --}}
									</div>
									<div class="link-area">
										<span><a href="{{ route('front.category',$category->slug) }}">{{ $category->name }}</a></span>
										<a href="javascript:;">
											<i class="fa fa-angle-right" aria-hidden="true"></i>
										</a>
									</div>

								@else
									{{-- <a href="{{ route('front.category',$category->slug) }}"><img src="{{ asset('assets/images/categories/'.$category->photo) }}"> {{ $category->name }}</a> --}}

								@endif
									@if(count($category->subs) > 0)


									<ul class="{{ $category->subs()->withCount('childs')->get()->sum('childs_count') > 0 ? 'categories_mega_menu' : 'categories_mega_menu column_1' }}">
										@foreach($category->subs()->whereStatus(1)->get() as $subcat)
											<li>
												<a href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}</a>
												@if(count($subcat->childs) > 0)
													<div class="categorie_sub_menu">
														<ul>
															@foreach($subcat->childs()->whereStatus(1)->get() as $childcat)
															<li><a href="{{ route('front.childcat',['slug1' => $category->slug, 'slug2' => $subcat->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
															@endforeach
														</ul>
													</div>
												@endif
											</li>
										@endforeach
									</ul>

									@endif

									</li>

									@if($loop->index == 14)
						                <li>
						                <a href="{{ route('front.categories') }}"><i class="fas fa-plus"></i> {{ $langg->lang15 }} </a>
						                </li>
						                @break
									@endif

									@endforeach

							</ul>
						</div>
					</div>
					<!--categorie menu end-->
					
					<section class="logo-header">
                		<div class="container">
                		    <div class="row">
                		        <div class="col-md-2 col-sm-12">
                		            <div class="mob-nav-icn">
                			            <div class="cat-mob">
                					    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
                                        	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                        	    <span class="navbar-toggler-icon">
                                        	    </span>
                                        	</button>
                                        	<!--<div class="nav-bg-ov navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"></div>-->
                                        	<div class="collapse navbar-collapse bg-dark" id="navbarCollapse" style="overflow:scroll">
                                            	<button class="navbar-toggler mn-close" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                            	    <img src="{{ asset('assets/front/images/payment-method/nav-icn.png')}}" alt="">
                                            	</button>
                                            	
                    					        <h5 class="mn-hd">CATEGORIES</h5>
                                        		<ul class="navbar-nav mr-auto sd-menu">
                                        			
                                        			<li class="nav-item">
                                        			@foreach($categories as $category)
                                        			<?php
                                        			    $idnam = substr($category->name, 0, 2).''.$category->id;
                                        			?>
                                        				<a class="nav-link" href="{{ route('front.category',$category->slug) }}">{{ $category->name }} <span id="accordion"><i class="fa fa-caret-down text-right collapsed" data-toggle="collapse" data-target="{{'#'.$idnam}}" aria-expanded="false" aria-controls="{{$idnam}}"></i></span></a>
                                        				@if(count($category->subs) > 0)
                                        			    <ul id="{{$idnam}}" class="collapse sb-menu" aria-labelledby="headingThree" data-parent="#accordion">
                                        			        @foreach($category->subs()->whereStatus(1)->get() as $subcat)
                                        			        <?php
                                                			    $idsubnam = substr($subcat->name, 0, 2).''.$subcat->id;
                                                			?>
                                        			        <li>
                                        			            <a class="nav-link nav-child-link" href="{{ route('front.subcat',['slug1' => $category->slug, 'slug2' => $subcat->slug]) }}">{{$subcat->name}}<span id="accordion"><i class="fa fa-caret-down text-right collapsed" data-toggle="collapse" data-target="{{'#'.$idsubnam}}" aria-expanded="false" aria-controls="{{$idsubnam}}"></i></span></a>
                                        			            @if(count($subcat->childs) > 0)
                                        			            <ul id="{{$idsubnam}}" class="collapse sb-menu" aria-labelledby="headingFive" data-parent="#accordion">
                                        			                @foreach($subcat->childs()->whereStatus(1)->get() as $childcat)
                                                			        <li><a href="{{ route('front.childcat',['slug1' => $category->slug, 'slug2' => $subcat->slug, 'slug3' => $childcat->slug]) }}">{{$childcat->name}}</a></li>
                                                			        @endforeach
                                                			    </ul>
                                                			    @endif
                                        			        </li>
                                        			        @endforeach
                                        			    </ul>
                                        			    @endif
                                        			@endforeach
                                        			</li>
                                        		</ul>
                                        	</div>
                                        </nav>
                					</div>
                			        </div>
                			        <div class="logo">
                						<a href="{{ route('front.index') }}">
                							<img src="{{asset('assets/images/'.$gs->logo)}}" alt="">
                						</a>
                					</div>
                		        </div>
                		        
                		        <div class="col-md-8 col-sm-12 cat-col">
                		            <div class="search-box-wrapper">
                                        <div class="categori-container" id="catSelectForm">
                							<select name="category" id="category_select" class="categoris">
                								<option value="">{{ $langg->lang1 }}</option>
                								@foreach($categories as $data)
                								<option value="{{ $data->slug }}" {{ Request::route('category') == $data->slug ? 'selected' : '' }}>{{ $data->name }}</option>
                								@endforeach
                							</select>
                						</div> 
                						<div class="search-box">
                							<form id="searchForm" class="search-form pl-0" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
                								@if (!empty(request()->input('sort')))
                									<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                								@endif
                								@if (!empty(request()->input('minprice')))
                									<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                								@endif
                								@if (!empty(request()->input('maxprice')))
                									<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                								@endif
                								<input type="text" id="prod_name" class="P-0 prod_name" name="search" placeholder="{{ $langg->lang2 }}" value="{{ request()->input('search') }}" autocomplete="off">
                								<div class="autocomplete">
                								  <div id="myInputautocomplete-list" class="autocomplete-items myInputautocomplete-list">
                								  </div>
                								</div>
                								<button type="submit"><i class="icofont-search-1"></i></button>
                							</form>
                						</div>
                					</div>
                		        </div>
                		        
                		        <div class="col-md-2 col-sm-12">
                				    <div class="mob-icns">
                				        <div class="search-wrapper">
                                            <div class="input-holder">
                                                <form id="searchForm" class="search-form pl-0" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
                    								@if (!empty(request()->input('sort')))
                    									<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                    								@endif
                    								@if (!empty(request()->input('minprice')))
                    									<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
                    								@endif
                    								@if (!empty(request()->input('maxprice')))
                    									<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
                    								@endif
                    								<input type="text" id="prod_name" class="P-0 search-input prod_name" name="search" placeholder="{{ $langg->lang2 }}" value="{{ request()->input('search') }}" autocomplete="off">
                    								<div class="autocomplete">
                    								  <div id="myInputautocomplete-list" class="autocomplete-items myInputautocomplete-list">
                    								  </div>
                    								</div>
                    								<button type="submit" class="search-icon" onclick="searchToggle(this, event);"><span class="icofont-search-1"></span></button>
                    							</form>
                                            </div>
                                            <span class="close" onclick="searchToggle(this, event);">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                				    </div>
                				    <nav class="helpful-links" hidden>
                						<ul class="menu helpful-links-inner">
                                            <li class="my-dropdown"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang3 }}">
                								<a href="javascript:;" class="cart carticon">
                									<div class="icon">
                										<i class="icofont-cart"></i>
                										<span class="cart-quantity" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
                									</div>
                
                								</a>
                								<div class="my-dropdown-menu" id="cart-items">
                									@include('load.cart')
                								</div>
                							</li>
                							<li class="wishlist"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang9 }}">
                								@if(Auth::guard('web')->check())
                									<a href="{{ route('user-wishlists') }}" class="wish">
                										<i class="far fa-heart"></i>
                										<span id="wishlist-count">{{ Auth::user()->wishlistCount() }}</span>
                									</a>
                								@else
                									<a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="wish">
                										<i class="far fa-heart"></i>
                										<span id="wishlist-count">0</span>
                									</a>
                								@endif
                							</li>
                							<li class="compare"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang10 }}">
                								<a href="{{ route('product.compare') }}" class="wish compare-product">
                									<div class="icon">
                										<i class="fas fa-exchange-alt"></i>
                										<span id="compare-count">{{ Session::has('compare') ? count(Session::get('compare')->items) : '0' }}</span>
                									</div>
                								</a>
                							</li>
                							{{-- @if($gs->is_home == 1)
                							<li><a href="{{ route('front.index') }}">{{ $langg->lang17 }}</a></li>
                							@endif
                							@if (DB::table('pagesettings')->find(1)->review_blog==1)
                								<li class="active" ><a  href="{{ route('front.blog') }}">{{ $langg->lang18 }}</a></li>
                							@endif
                							@if($gs->is_faq == 1)
                							<li><a href="{{ route('front.faq') }}">{{ $langg->lang19 }}</a></li>
                							@endif
                							@foreach(DB::table('pages')->where('header','=',1)->get() as $data)
                								<li><a href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a></li>
                							@endforeach
                							@if($gs->is_contact == 1)
                							<li><a href="{{ route('front.contact') }}">{{ $langg->lang20 }}</a></li>
                							@endif
                							<li>
                								<a href="javascript:;" data-toggle="modal" data-target="#track-order-modal" class="track-btn">{{ $langg->lang16 }}</a>
                							</li> --}}
                						</ul>
                					</nav>
                		        </div>
                		    </div>
                		    
                			
                		</div>
                	</section>
				</div>
			</div>
		</div>
	</div>
	<!--Main-Menu Area End-->

@yield('content')

	<!-- Footer Area Start -->
	<footer class="footer dsk-foot" id="footer">
		<div class="container">
			<div class="row">

                {{-- Contact Info --}}
				<div class="col-md-6 col-lg-3">
					<div class="footer-info-area">
						<h1 class=" h5 text-gray font-weight-bold text-uppercase">Contact Informations</h1>
                        <div class="pt-1">
                            <label class="  text-sm text-gray font-weight-bold text-uppercase">Address</label>
                            <h6 class="h6 text-gray">Office #103 First Floor Shafi Courts Civil Lines, Karachi</h6>
                        </div>

                        <div class="pt-1">
                            <label class="  text-gray font-weight-bold text-uppercase">Phone</label>
                            <h6 class="h6 text-gray">+92 213 5662201-2</h6>
                        </div>

                        <div class="pt-1">
                            <label class="  text-gray font-weight-bold text-uppercase">Email</label>
                            <h6 class="h6 text-sm text-gray">support@ecpmarket.com</h6>
                            <h6 class="h6 text-sm text-gray">info@ecpmarket.com</h6>
                        </div>

					</div>

				</div>



                {{-- my Account --}}

				<div class="col-md-6 col-lg-3">
                    <!--<h1 class="h5 text-gray font-weight-bold text-uppercase">My Accounts</h1>-->
                    <div class="pt-2">
                        @if(!Auth::guard('web')->check())
										<a href="{{ route('user.login') }}" class="sign-log">
											<div class="links">
												<span class="sign-in">REGISTER|SIGN IN</span>
											</div>
										</a>
									@else
											<a href="javascript: ;" id="profile-icon" class="profile carticon">
												<span class="text text-dark">
													<i class="far fa-user"></i>	{{ $langg->lang11 }} <i class="fas fa-chevron-down"></i>
												</span>
											</a>
											<div class="my-dropdown-menu profile-dropdown">
												<ul class="profile-links">
													<li>
														<a href="{{ route('user-dashboard') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang221 }}</a>
													</li>
													@if(Auth::user()->IsVendor())
													<li>
														<a href="{{ route('vendor-dashboard') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang222 }}</a>
													</li>
													@endif

													<li>
														<a href="{{ route('user-profile') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang205 }}</a>
													</li>

													<li>
														<a href="{{ route('user-logout') }}"><i class="fas fa-angle-double-right"></i> {{ $langg->lang223 }}</a>
													</li>
												</ul>
											</div>
									@endif
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('front.cart') }}" class=" h6 text-gray">
                            View cart
                       </a>
                    </div>
                    <div class="pt-4">
                        @if(Auth::guard('web')->check())
                            <a href="{{ route('user-wishlists') }}" class="wish h6 text-gray">
                                {{-- <i class="far fa-heart"></i> --}}
                                <span id="wishlist-count">My Whishlist</span>
                            </a>
                        @else
                            <a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="wish h6 text-gray">
                                {{-- <i class="far fa-heart"></i> --}}
                                <span id="wishlist-count">My Whishlist</span>
                            </a>
                        @endif
                        {{-- <a href="{{ route('front.cart') }}" class=" h6 text-gray">
                            My Whishlist
                       </a> --}}
                    </div>
                    <div class="pt-4">
                        <a href="javascript:;" data-toggle="modal" data-target="#track-order-modal" class="track-btn text-gray h6">Track My Order</a>
                    </div>



				</div>

                {{-- Information --}}
				<div class="col-md-6 col-lg-3">
                    <h1 class="h5 text-gray font-weight-bold text-uppercase">Information</h1>
                    @php
                        $is=1
                    @endphp
                    @foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
                    <div class="{{ (($is==1)?'pt-2':'pt-4')}}">

								<a class=" h6 text-gray" href="{{ route('front.page',$data->slug) }}">{{ $data->title }}</a>
                    </div>
                        @php
                            $is++
                        @endphp
					@endforeach
                    <div class="pt-4">
                        <a href="{{ route('front.contact') }}" class=" h6 text-gray">
                            Contact Us
                       </a>
                    </div>
				</div>
                {{-- Customer Services --}}
                <div class="col-md-6 col-lg-3">
                    <h1 class="h5 text-gray font-weight-bold text-uppercase">Customer Services</h1>
                    <div class="pt-4">
                        <a href="{{ route('front.paymentmethod') }}" class=" h6 text-gray">
                            Payment Methods
                       </a>
                    </div>
                    <div class="pt-4">
                        <a href="{{ route('front.return&refund') }}" class=" h6 text-gray">
                            Return & Refund Policy
                       </a>
                    </div>
                    <div class="pt-4">
                        @if($gs->reg_vendor == 1)
                            @if(Auth::check())
                                @if(Auth::guard('web')->user()->is_vendor == 2)
                                    <a href="{{ route('vendor-dashboard') }}" class=" h6 text-gray">Sell With Us</a>
                                @else
                                    {{-- <a href="{{ route('user-package') }}" class="sell-btn">Become a partner</a> --}}
                                @endif
                            @else
                                <!--<a href="javascript:;" data-toggle="modal" data-target="#vendor-login" class=" h6 text-gray">Sell With Us</a>-->
                                <a href="{{route('vendorLogin')}}" class=" h6 text-gray">Sell With US</a>
                            @endif
						@endif
                    </div>
				</div>
			</div>
		</div>
		
		<div class="copy-bg mt-1 p-1"  >
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
						<div class="fotter-social-links">
							<ul>

											@if($socialsetting->f_status == 1)
										  <li>
											<a href="{{ $socialsetting->facebook }}" class="facebook" target="_blank">
												<i class="fab fa-facebook-f"></i>
											</a>
										  </li>
										  @endif
										  @if($socialsetting->i_status == 1)
										  <li>
											<a href="{{ $socialsetting->instagram }}" class="instagram" target="_blank">
												<i class="fab fa-instagram"></i>
											</a>
										  </li>
										  @endif
										  @if($socialsetting->y_status == 1)
										  <li>
											<a href="{{ $socialsetting->youtube }}" class="youtube" target="_blank">
												<i class="fab fa-youtube"></i>
											</a>
										  </li>
										  @endif

										  @if($socialsetting->g_status == 1)
										  <li>
											<a href="{{ $socialsetting->gplus }}" class="google-plus" target="_blank">
												<i class="fab fa-google-plus-g"></i>
											</a>
										  </li>
										  @endif

										  @if($socialsetting->t_status == 1)
										  <li>
											<a href="{{ $socialsetting->twitter }}" class="twitter" target="_blank">
												<i class="fab fa-twitter"></i>
											</a>
										  </li>
										  @endif

										  @if($socialsetting->l_status == 1)
										  <li>
											<a href="{{ $socialsetting->linkedin }}" class="linkedin" target="_blank">
												<i class="fab fa-linkedin-in"></i>
											</a>
										  </li>
										  @endif

										  @if($socialsetting->d_status == 1)
										  <li>
											<a href="{{ $socialsetting->dribble }}" class="dribbble" target="_blank">
												<i class="fab fa-dribbble"></i>
											</a>
										  </li>
										  @endif

							</ul>
						</div>
					</div>
					<div class="col-lg-9">
							<div class="content">
								<div class="content">
									<p class="text-gray">{!! $gs->copyright !!}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	
	<div class="stk-icns">
        <div class="stk-icns-inn">
            <ul>
                <li><a href="https://ecpmarket.com/"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="/user/login"><i class="fa fa-user"></i> My Account</a></li>
                <li><a href="#" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-sitemap"></i> Categories</a></li>
                <li><a href="/carts"><i class="fa fa-shopping-cart"></i> Cart</a></li>
            </ul>
        </div>
    </div>
	
	<footer class="footer mob-foot" id="footer">
	    <div class="mb-cont-details">
    	    <div class="mb-em">
    	        <i class="fa fa-envelope"></i>
    	        <div>
    	            <h6>Email Support:</h6>
    	            <h5><a href="mailto:support@ecpmarket.com">support@ecpmarket.com</a></h5>
    	        </div>
    	    </div>
    	    
    	    <div class="mb-em">
    	        <i class="fa fa-phone"></i>
    	        <div>
    	            <h6>Phone:</h6>
    	            <h5><a href="tel:021356622013">021-35662201-3</a></h5>
    	        </div>
    	    </div>
    	    
    	    <div class="mb-em">
    	        <i class="fa fa-shopping-cart"></i>
    	        <div style="padding-top: 9px;">
    	            <!--<a href="javascript:;" data-toggle="modal" data-target="#vendor-login">Sell With Us</a>-->
    	            <a href="{{route('vendorLogin')}}">Sell With US</a>
    	        </div>
    	    </div>
    	    
    	    <div class="mb-em wa-cont">
    	        <img src="https://ecpmarket.com/assets/front/images/payment-method/whatsapp.png">
    	        <div>
    	            <h6>Whatsapp:</h6>
    	            <h5><a href="http://wa.me//923322450119">0332-2450119</a></h5>
    	        </div>
    	    </div>
	    </div>
	    
	    <div class="fotter-social-links">
			<ul>
              <li>
				<a href="https://www.facebook.com/ECPMarketPakistan" class="facebook" target="_blank">
					<i class="fab fa-facebook-f"></i>
				</a>
			  </li>
			  <li>
				<a href="https://www.instagram.com/ecpmarket/" class="instagram" target="_blank">
					<i class="fab fa-instagram"></i>
				</a>
			  </li>
			  <li>
				<a href="https://www.youtube.com/channel/UCnDRr-iyA3GDdvF6EJSnOgQ" class="youtube" target="_blank">
					<i class="fab fa-youtube"></i>
				</a>
			  </li>
			  <li>
				<a href="https://twitter.com/ecpmarket" class="twitter" target="_blank">
					<i class="fab fa-twitter"></i>
				</a>
			  </li>
			  <li>
				<a href="https://www.linkedin.com/company/ecpmarket/" class="linkedin" target="_blank">
					<i class="fab fa-linkedin-in"></i>
				</a>
			  </li>
			</ul>
		</div>
	    <p>&copy; 2022 - ECP Market, All rights reserved.</p>
	    <ul class="mb-py">
	        <li><a href="#"><img src="http://ecpmarket.com/assets/front/images/payment-method/py-001.png"></a></li>
	        <li><a href="#"><img src="http://ecpmarket.com/assets/front/images/payment-method/py-002.png"></a></li>
	        <li><a href="#"><img src="http://ecpmarket.com/assets/front/images/payment-method/py-003.png"></a></li>
	        <li><a href="#"><img src="http://ecpmarket.com/assets/front/images/payment-method/py-004.png"></a></li>
	    </ul>
	</footer>
	<!-- Footer Area End -->

	<!-- Back to Top Start -->
	<div class="bottomtotop">
		<i class="fas fa-chevron-right"></i>
	</div>
	<!-- Back to Top End -->

	<!-- LOGIN MODAL -->
	<div class="modal fade" id="comment-log-reg" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
		aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<nav class="comment-log-reg-tabmenu">
						<div class="nav nav-tabs" id="nav-tab" role="tablist">
							<a class="nav-item nav-link login active" id="nav-log-tab1" data-toggle="tab" href="#nav-log1"
								role="tab" aria-controls="nav-log" aria-selected="true">
								{{ $langg->lang197 }}
							</a>
							<a class="nav-item nav-link" id="nav-reg-tab1" data-toggle="tab" href="#nav-reg1" role="tab"
								aria-controls="nav-reg" aria-selected="false">
								{{ $langg->lang198 }}
							</a>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-log1" role="tabpanel"
							aria-labelledby="nav-log-tab1">
							<div class="login-area">
								<div class="header-area">
									<h4 class="title">{{ $langg->lang172 }}</h4>
								</div>
								<div class="login-form signin-form">
									@include('includes.admin.form-login')
									<form class="mloginform" action="{{ route('user.login.submit') }}" method="POST">
										{{ csrf_field() }}
										<div class="form-input">
											<input type="email" name="email" placeholder="{{ $langg->lang173 }}"
												required="">
											<i class="icofont-user-alt-5"></i>
										</div>
										<div class="form-input">
											<input type="password" class="Password" name="password"
												placeholder="{{ $langg->lang174 }}" required="">
											<i class="icofont-ui-password"></i>
										</div>
										<div class="form-forgot-pass">
											<div class="left">
												<input type="checkbox" name="remember" id="mrp"
													{{ old('remember') ? 'checked' : '' }}>
												<label for="mrp">{{ $langg->lang175 }}</label>
											</div>
											<div class="right">
												<a href="javascript:;" id="show-forgot">
													{{ $langg->lang176 }}
												</a>
											</div>
										</div>
										<input type="hidden" name="modal" value="1">
										<input class="mauthdata" type="hidden" value="{{ $langg->lang177 }}">
										<button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
										@if($socialsetting->f_check == 1 ||
										$socialsetting->g_check == 1)
										<div class="social-area">
											<h3 class="title">{{ $langg->lang179 }}</h3>
											<p class="text">{{ $langg->lang180 }}</p>
											<ul class="social-links">
												@if($socialsetting->f_check == 1)
												<li>
													<a href="{{ route('social-provider','facebook') }}">
														<i class="fab fa-facebook-f"></i>
													</a>
												</li>
												@endif
												@if($socialsetting->g_check == 1)
												<li>
													<a href="{{ route('social-provider','google') }}">
														<i class="fab fa-google-plus-g"></i>
													</a>
												</li>
												@endif
											</ul>
										</div>
										@endif
									</form>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="nav-reg1" role="tabpanel" aria-labelledby="nav-reg-tab1">
							<div class="login-area signup-area">
								<div class="header-area">
									<h4 class="title">{{ $langg->lang181 }}</h4>
								</div>
								<div class="login-form signup-form">
									@include('includes.admin.form-login')
									<form class="mregisterform" action="{{route('user-register-submit')}}"
										method="POST">
										{{ csrf_field() }}

										<div class="form-input">
											<input type="text" class="User Name" name="name"
												placeholder="{{ $langg->lang182 }}" required="">
											<i class="icofont-user-alt-5"></i>
										</div>

										<div class="form-input">
											<input type="email" class="User Name" name="email"
												placeholder="{{ $langg->lang183 }}" required="">
											<i class="icofont-email"></i>
										</div>

										<div class="form-input">
											<input type="text" class="User Name" name="phone"
												placeholder="{{ $langg->lang184 }}" required="">
											<i class="icofont-phone"></i>
										</div>

										<div class="form-input">
											<input type="text" class="User Name" name="address"
												placeholder="{{ $langg->lang185 }}" required="">
											<i class="icofont-location-pin"></i>
										</div>

										<div class="form-input">
											<input type="password" class="Password" name="password"
												placeholder="{{ $langg->lang186 }}" required="">
											<i class="icofont-ui-password"></i>
										</div>

										<div class="form-input">
											<input type="password" class="Password" name="password_confirmation"
												placeholder="{{ $langg->lang187 }}" required="">
											<i class="icofont-ui-password"></i>
										</div>


										@if($gs->is_capcha == 1)

										<ul class="captcha-area">
											<li>
												{{-- <p><img class="codeimg1"
														src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i
														class="fas fa-sync-alt pointer refresh_code "></i></p> --}}
											</li>
										</ul>

										<div class="form-input">
											<input type="text" class="Password" name="codes"
												placeholder="{{ $langg->lang51 }}" required="">
											<i class="icofont-refresh"></i>
										</div>


										@endif

										<input class="mprocessdata" type="hidden" value="{{ $langg->lang188 }}">
										<button type="submit" class="submit-btn">{{ $langg->lang189 }}</button>

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- LOGIN MODAL ENDS -->

	<!-- FORGOT MODAL -->
	<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
		aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="login-area">
						<div class="header-area forgot-passwor-area">
							<h4 class="title">{{ $langg->lang191 }} </h4>
							<p class="text">{{ $langg->lang192 }} </p>
						</div>
						<div class="login-form">
							@include('includes.admin.form-login')
							<form id="mforgotform" action="{{route('user-forgot-submit')}}" method="POST">
								{{ csrf_field() }}
								<div class="form-input">
									<input type="email" name="email" class="User Name"
										placeholder="{{ $langg->lang193 }}" required="">
									<i class="icofont-user-alt-5"></i>
								</div>
								<div class="to-login-page">
									<a href="javascript:;" id="show-login">
										{{ $langg->lang194 }}
									</a>
								</div>
								<input class="fauthdata" type="hidden" value="{{ $langg->lang195 }}">
								<button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- FORGOT MODAL ENDS -->


<!-- VENDOR LOGIN MODAL -->
	<div class="modal fade" id="vendor-login" tabindex="-1" role="dialog" aria-labelledby="vendor-login-Title" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" style="transition: .5s;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<nav class="comment-log-reg-tabmenu">
					<div class="nav nav-tabs" id="nav-tab1" role="tablist">
						<a class="nav-item nav-link login active" id="nav-log-tab11" data-toggle="tab" href="#nav-log11" role="tab" aria-controls="nav-log" aria-selected="true">
							{{ $langg->lang234 }}
						</a>
						<a class="nav-item nav-link" id="nav-reg-tab11" data-toggle="tab" href="#nav-reg11" role="tab" aria-controls="nav-reg" aria-selected="false">
							{{ $langg->lang235 }}
						</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-log11" role="tabpanel" aria-labelledby="nav-log-tab">
				        <div class="login-area">
				          <div class="login-form signin-form">
				                @include('includes.admin.form-login')
				            <form class="mloginform" action="{{ route('user.login.submit') }}" method="POST">
				              {{ csrf_field() }}
				              <div class="form-input">
				                <input type="email" name="email" placeholder="{{ $langg->lang173 }}" required="">
				                <i class="icofont-user-alt-5"></i>
				              </div>
				              <div class="form-input">
				                <input type="password" class="Password" name="password" placeholder="{{ $langg->lang174 }}" required="">
				                <i class="icofont-ui-password"></i>
				              </div>
				              <div class="form-forgot-pass">
				                <div class="left">
				                  <input type="checkbox" name="remember"  id="mrp1" {{ old('remember') ? 'checked' : '' }}>
				                  <label for="mrp1">{{ $langg->lang175 }}</label>
				                </div>
				                <div class="right">
				                  <a href="javascript:;" id="show-forgot1">
				                    {{ $langg->lang176 }}
				                  </a>
				                </div>
				              </div>
				              <input type="hidden" name="modal"  value="1">
				               <input type="hidden" name="vendor"  value="1">
				              <input class="mauthdata" type="hidden"  value="{{ $langg->lang177 }}">
				              <button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
					              @if($socialsetting->f_check == 1 || $socialsetting->g_check == 1)
					              <div class="social-area">
					                  <h3 class="title">{{ $langg->lang179 }}</h3>
					                  <p class="text">{{ $langg->lang180 }}</p>
					                  <ul class="social-links">
					                    @if($socialsetting->f_check == 1)
					                    <li>
					                      <a href="{{ route('social-provider','facebook') }}">
					                        <i class="fab fa-facebook-f"></i>
					                      </a>
					                    </li>
					                    @endif
					                    @if($socialsetting->g_check == 1)
					                    <li>
					                      <a href="{{ route('social-provider','google') }}">
					                        <i class="fab fa-google-plus-g"></i>
					                      </a>
					                    </li>
					                    @endif
					                  </ul>
					              </div>
					              @endif
				            </form>
				          </div>
				        </div>
					</div>
					<div class="tab-pane fade" id="nav-reg11" role="tabpanel" aria-labelledby="nav-reg-tab">
                <div class="login-area signup-area">
                    <div class="login-form signup-form">
                       @include('includes.admin.form-login')
                        <form class="mregisterform" action="{{route('user-register-submit')}}" method="POST">
                            <select class="form-control" name="select_seller" id="select_seller" style="display:none;">
                                <option value="">Select Type</option>
                                <option value="1" selected>Vendor</option>
                                <option value="11">Network Member</option>
                            </select>
                            <br>
                            <br>
                          {{ csrf_field() }}

                          <div class="row">
                              <div id="referal" style="display: none" class="col-lg-6">

                                  <div class="form-input">
                                      <input type="text" class="User Name" name="referal_key" placeholder="Referal Key" >
                                      <i class="icofont-location-pin"></i>
                                  </div>
                              </div>
                          <div class="col-lg-6">
                            <div class="form-input">
                                <input type="text" class="User Name" name="name" placeholder="{{ $langg->lang182 }}" required="">
                                <i class="icofont-user-alt-5"></i>
                            	</div>
                           </div>

                           <div class="col-lg-6">
 <div class="form-input">
                                <input type="email" class="User Name" name="email" placeholder="{{ $langg->lang183 }}" required="">
                                <i class="icofont-email"></i>
                            </div>

                           	</div>
                           <div class="col-lg-6">
    <div class="form-input">
                                <input type="text" class="User Name" name="phone" placeholder="{{ $langg->lang184 }}" required="">
                                <i class="icofont-phone"></i>
                            </div>

                           	</div>
                           <div id="address" class="col-lg-6">

                            <div class="form-input">
                                <input type="text" class="User Name" name="address" placeholder="{{ $langg->lang185 }}" required="">
                                <i class="icofont-location-pin"></i>
                            </div>
                           	</div>

                           <div class="col-lg-6">
 <div class="form-input">
                                <input type="text" class="User Name" name="shop_name" placeholder="{{ $langg->lang238 }}" required="">
                                <i class="icofont-cart-alt"></i>
                            </div>

                           	</div>
                            <div class="col-lg-6">
                                <div class="form-input">
                                    <input type="number" min="0" class="User Name" name="shop_number" placeholder="Shop Contact" required="">
                                    <i class="icofont-cart-alt"></i>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-input">
                                    <input type="text" class="User Name" name="shop_address" placeholder="Shop Address" required="">
                                    <i class="icofont-cart-alt"></i>
                                </div>
                            </div>
                           {{-- <div class="col-lg-6">

 <div class="form-input">
                                <input type="text" class="User Name" name="owner_name" placeholder="{{ $langg->lang239 }}" required="">
                                <i class="icofont-cart"></i>
                            </div>
                           	</div> --}}
                           <div class="col-lg-6">
  <div class="form-input">
                                <input type="password" class="Password" name="password" placeholder="{{ $langg->lang186 }}" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

                           	</div>
                           <div class="col-lg-6">
 								<div class="form-input">
                                <input type="password" class="Password" name="password_confirmation" placeholder="{{ $langg->lang187 }}" required="">
                                <i class="icofont-ui-password"></i>
                            	</div>
                           	</div>

{{--                            @if($gs->is_capcha == 1)--}}

{{--<div class="col-lg-6">--}}


{{--                            <ul class="captcha-area">--}}
{{--                                <li>--}}
{{--                                 	<p>--}}
{{--                                 		--}}{{-- <img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i> --}}
{{--                                 	</p>--}}

{{--                                </li>--}}
{{--                            </ul>--}}


{{--</div>--}}

{{--<div class="col-lg-6">--}}

{{-- <div class="form-input">--}}
{{--                                <input type="text" class="Password" name="codes" placeholder="{{ $langg->lang51 }}" required="">--}}
{{--                                <i class="icofont-refresh"></i>--}}

{{--                            </div>--}}



{{--                          </div>--}}

{{--                            @endif--}}
				            <input type="hidden" name="vendor" id="seller_type"  value="2">
                            <input class="mprocessdata" type="hidden"  value="{{ $langg->lang188 }}">
                            <button type="submit" class="submit-btn">{{ $langg->lang189 }}</button>
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
<!-- VENDOR LOGIN MODAL ENDS -->

<!-- Product Quick View Modal -->

	  <div class="modal fade" id="quickview" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog quickview-modal modal-dialog-centered modal-lg" role="document">
		  <div class="modal-content">
			<div class="submit-loader">
				<img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
			</div>
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<div class="container quick-view-modal">

				</div>
			</div>
		  </div>
		</div>
	  </div>
<!-- Product Quick View Modal -->

<!-- Order Tracking modal Start-->
    <div class="modal fade" id="track-order-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"> <b>{{ $langg->lang772 }}</b> </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                        <div class="order-tracking-content">
                            <form id="track-form" class="track-form">
                                {{ csrf_field() }}
                                <input type="text" id="track-code" placeholder="{{ $langg->lang773 }}" required="">
                                <button type="submit" class="mybtn1">{{ $langg->lang774 }}</button>
                                <a href="#"  data-toggle="modal" data-target="#order-tracking-modal"></a>
                            </form>
                        </div>

                        <div>
				            <div class="submit-loader d-none">
								<img src="{{asset('assets/images/'.$gs->loader)}}" alt="">
							</div>
							<div id="track-order">

							</div>
                        </div>

            </div>
            </div>
        </div>
    </div>
<!-- Order Tracking modal End -->

<script type="text/javascript">
  var mainurl = "{{url('/')}}";
  var gs      = {!! json_encode(\App\Models\Generalsetting::first()->makeHidden(['stripe_key', 'stripe_secret', 'smtp_pass', 'instamojo_key', 'instamojo_token', 'paystack_key', 'paystack_email', 'paypal_business', 'paytm_merchant', 'paytm_secret', 'paytm_website', 'paytm_industry', 'paytm_mode', 'molly_key', 'razorpay_key', 'razorpay_secret'])) !!};
  var langg    = {!! json_encode($langg) !!};
</script>
	<!-- jquery -->
	{{-- <script src="{{asset('assets/front/js/all.js')}}"></script> --}}
	<script src="{{asset('assets/front/js/jquery.js')}}"></script>
	{{-- <script src="{{asset('assets/front/js/vue.js')}}"></script> --}}

	<script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- popper -->
    <script src="{{asset('project/public/js/app.js')}}"></script>
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<!-- bootstrap -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
	<!-- plugin js-->
	<script src="{{asset('assets/front/js/plugin.js')}}"></script>


	{{-- <script src="{{asset('assets/front/js/xzoom.min.js')}}"></script> --}}
	{{-- <script src="{{asset('assets/front/js/jquery.hammer.min.js')}}"></script> --}}
	{{-- <script src="{{asset('assets/front/js/setup.js')}}"></script> --}}

	<script src="{{asset('assets/front/js/toastr.js')}}"></script>
	<!-- main -->
	{{-- <script src="{{asset('assets/front/js/main.js')}}"></script> --}}
	<!-- custom -->
	{{-- <script src="{{asset('assets/front/js/custom.js')}}"></script> --}}
	{{-- <script src="{{asset('assets/front/js/splide.min.js')}}"></script> --}}

    {{-- {!! $seo->google_analytics !!} --}}

	@if($gs->is_talkto == 1)
		<!--Start of Tawk.to Script-->
		{!! $gs->talkto !!}
		<!--End of Tawk.to Script-->
	@endif

	@yield('scripts')

</body>
<script>

// OneSignal.push(function() {
//   OneSignal.showNativePrompt();
// });
    // $("#select_seller").change(function(){
    //     var val = $(this).val();
    //     if(val == 11){
    //         $("input[name='address']").eq(1).parent().hide();
    //         $("input[name='shop_name']").parent().hide();
    //         $("input[name='owner_name']").parent().hide();
    //         $("input[name='shop_number']").parent().hide();
    //         $("input[name='shop_address']").parent().hide();
    //         $("input[name='reg_number']").parent().hide();
    //         $("input[name='shop_message']").parent().hide();
    //         $("#referal").show();
    //         $("#address").hide();
    //         $("input[name='shop_message'],input[name='reg_number'],input[name='address'],input[name='shop_address'],input[name='shop_number'],input[name='owner_name'],input[name='shop_name']").removeAttr("required");
    //         $("input[name='address']").eq(1).removeAttr("required");
    //     }else{
    //         $("input[name='address']").eq(1).parent().show();
    //         $("input[name='shop_name']").parent().show();
    //         $("input[name='owner_name']").parent().show();
    //         $("input[name='shop_number']").parent().show();
    //         $("input[name='shop_address']").parent().show();
    //         $("input[name='reg_number']").parent().show();
    //         $("input[name='shop_message']").parent().show();
    //         $("#address").show();
    //         $("input[name='address']").eq(1).attr("required");
    //         $("#referal").hide();
    //         $("input[name='shop_message'],input[name='address'],input[name='reg_number'],input[name='shop_address'],input[name='shop_number'],input[name='owner_name'],input[name='shop_name']").attr("required");
    //     }
    // });
</script>

<script>
    function searchToggle(obj, evt){
    var container = $(obj).closest('.search-wrapper');
        if(!container.hasClass('active')){
            container.addClass('active');
            evt.preventDefault();
        }
        else if(container.hasClass('active') && $(obj).closest('.input-holder').length == 0){
            container.removeClass('active');
            // clear input
            container.find('.search-input').val('');
        }
}
</script>
<script>
    $(document).on('click','.add-to-cart',function() {
                var url = $(this).attr('data-href');
                var split = url.split('/');
                var id = split[4];
                $.ajax({
                    type: "get",
                    url: "{{route('getcartdata')}}",
                    data: {'id':id},
                    success: function (response) {
                        dataLayer.push({
                            'event':'addToCart',
                            'ecommerce': {'detail': [ {"content_type":"product","pageType":"product","content_category":{"main" : response.main,"sub" : response.sub, "child" : response.child},"brand":response.brand,"seller":response.seller,"currency":response.currency,"value":response.price,"quantity":1,"content_name":response.name,"content_ids":response.id,"sku":response.sku,"category":{ "main" : response.main,"sub" : response.sub,"child" : response.child}} ]}
                        })
                    }
                });
              })
</script>
<script>
    $(document).on('submit','#searchForm',function() {
        var string  = $('#prod_name').val();
        var cat = $('#category_select :selected').text();
        dataLayer.push({
            'event':'search',
            'ecommerce': {'detail': [ {"content_type":"product","pageType":"search","brand":"not set","search_category":cat,"customer_type":"not set","search_string":string} ]}
        })
    })
    
</script>
</html>
