
	@if($ps->best == 1)
    <!-- Phone and Accessories Area Start -->
    <section class="phone-and-accessories categori-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            Featured Categories
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="trending-item-slider">
                        <?php
                         $i= 1;
                            foreach($featured_categories as $prod)
                            {
                        
                            if($i % 2 == 0)
                            {
                               
                            }
                            else
                            {
                                echo '<div class="row">';
                            }
                        ?>
                            @include('includes.product.featured_categories')
                        <?php 
                            if($i % 2 == 0)
                            {
                            echo '</div>';
                            }
                        $i++; 
                            }
                        ?>
                    </div>
                </div>
                <!--<div class="col-lg-3 remove-padding d-none d-lg-block">-->
                <!--	<div class="aside">-->
                <!--		<a class="banner-effect mb-10" href="{{ $ps->best_seller_banner_link }}">-->
                <!--			<img src="{{asset('assets/images/'.$ps->best_seller_banner)}}" alt="">-->
                <!--		</a>-->
                <!--		<a class="banner-effect" href="{{ $ps->best_seller_banner_link1 }}">-->
                <!--			<img src="{{asset('assets/images/'.$ps->best_seller_banner1)}}" alt="">-->
                <!--		</a>-->
                <!--	</div>-->
                <!--</div>-->
            </div>
        </div>
    </section>
    <!-- Phone and Accessories Area start-->
    
@endif

	@if($ps->flash_deal == 1)
    <!-- Electronics Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            {{ $langg->lang244 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="flash-deals">
                        <div class="flas-deal-slider">

                            @foreach($discount_products as $prod)
                                @include('includes.product.flash-product')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Electronics Area start-->
@endif


@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
            @foreach($large_banners1->chunk(1) as $chunk)
                    @foreach($chunk as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
            @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif

@if($ps->top_rated == 1)
    <!-- Electronics Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            New Arrivals
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                        <div class="trending-item-slider nw-arr">
                        @foreach($top_products as $prod)
                            @include('includes.product.top-product')
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Electronics Area start-->
@endif
@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
            @foreach($large_banners2->chunk(1) as $chunk)
                    @foreach($chunk as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
            @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif

    @if($ps->hot_sale == 1)
    <!-- Electronics Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            Hot Products
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                        <div class="trending-item-slider nw-arr">
                        @foreach($hot_products as $prod)
                            @include('includes.product.top-product')
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Electronics Area start-->
@endif
@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
            @foreach($large_banners3->chunk(1) as $chunk)
                    @foreach($chunk as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
            @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif
	@if($ps->big == 1)
    <!-- Clothing and Apparel Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            BIG SAVE
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                        <div class="trending-item-slider nw-arr">
                        @foreach($big_products as $prod)
                            @include('includes.product.top-product')
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Clothing and Apparel Area start-->
@endif 
@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
            @foreach($large_banners4->chunk(1) as $chunk)
                    @foreach($chunk as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
            @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif
    <!-- Clothing and Apparel Area Start -->
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            Trending Product
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                        <div class="trending-item-slider nw-arr">
                        @foreach($trending_products as $prod)
                            @include('includes.product.top-product')
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Clothing and Apparel Area start-->
@if($ps->large_banner == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
            @foreach($large_banners5->chunk(1) as $chunk)
                    @foreach($chunk as $img)
                        <div class="col-lg-6 remove-padding">
                            <div class="left">
                                <a class="banner-effect" href="{{ $img->link }}">
                                    <img src="{{asset('assets/images/banners/'.$img->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
            @endforeach
            </div>
        </div>
    </section>
    <!-- Banner Area One Start -->
@endif
    <section class="categori-item electronics-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 remove-padding">
                    <div class="section-top">
                        <h2 class="section-title">
                            Sale Product
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 remove-padding">
                        <div class="trending-item-slider nw-arr">
                        @foreach($sale_products as $prod)
                            @include('includes.product.top-product')
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
@if($ps->bottom_small == 1)
    <!-- Banner Area One Start -->
    <section class="banner-section">
        <div class="container">
            @foreach($bottom_small_banners->chunk(3) as $chunk)
                <div class="row">
                    @foreach($chunk as $img)
                        <div class="col-lg-4 remove-padding">
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
@if($ps->review_blog == 1)
    <!-- Blog Area Start -->
    <section class="blog-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="aside">
                        <div class="slider-wrapper">
                            <div class="aside-review-slider">
                                @foreach($reviews as $review)
                                    <div class="slide-item">
                                        <div class="top-area">
                                            <div class="left">
                                                <img src="{{ $review->photo ? asset('assets/images/reviews/'.$review->photo) : asset('assets/images/noimage.png') }}" alt="">
                                            </div>
                                            <div class="right">
                                                <div class="content">
                                                    <h4 class="name">{{ $review->title }}</h4>
                                                    <p class="dagenation">{{ $review->subtitle }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <blockquote class="review-text">
                                            <p>
                                                {!! $review->details !!}
                                            </p>
                                        </blockquote>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @foreach(DB::table('blogs')->orderby('views','desc')->take(2)->get() as $blogg)

                        <div class="blog-box">
                            <div class="blog-images">
                                <div class="img">
                                    <img src="{{ $blogg->photo ? asset('assets/images/blogs/'.$blogg->photo):asset('assets/images/noimage.png') }}" class="img-fluid" alt="" loading="lazy">
                                    <div class="date d-flex justify-content-center">
                                        <div class="box align-self-center">
                                            <p>{{date('d', strtotime($blogg->created_at))}}</p>
                                            <p>{{date('M', strtotime($blogg->created_at))}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="details">
                                <a href='{{route('front.blogshow',$blogg->id)}}'>
                                    <h4 class="blog-title">
                                        {{mb_strlen($blogg->title,'utf-8') > 40 ? mb_substr($blogg->title,0,40,'utf-8')."...":$blogg->title}}
                                    </h4>
                                </a>
                                <p class="blog-text">
                                    {{substr(strip_tags($blogg->details),0,170)}}
                                </p>
                                <a class="read-more-btn" href="{{route('front.blogshow',$blogg->id)}}">{{ $langg->lang34 }}</a>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- Blog Area start-->
@endif

@if($ps->partners == 1)
    <!-- Partners Area Start -->
    <section class="partners">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top">
                        <h2 class="section-title">
                            {{ $langg->lang236 }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="partner-slider">
                        @foreach($partners as $data)
                            <div class="item-slide">
                                <a href="{{route('front.category.brand',$data->slug)}}" target="_blank">
                                    <img src="{{asset('assets/images/brands/'.$data->photo)}}" alt="" loading="lazy">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Partners Area Start -->
@endif

@if($ps->service == 1)

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
                                                    <img src="{{ asset('assets/images/services/'.$service->photo) }}" loading="lazy">
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

    @endif


<!-- main -->
<!--<script src="{{asset('assets/front/js/mainextra.js')}}"></script>-->
<script src="{{asset('project/public/js/extraapp.js')}}"></script>
