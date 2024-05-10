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
                        <a href="{{ route('front.contact') }}">
                            {{ $langg->lang20 }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->


    <!-- Contact Us Area Start -->
    <section class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-section-title">
                            {!! $ps->contact_title !!}
                            {!! $ps->contact_text !!}
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-md-6 col-sm-12">
                    <div class="left-area">
                        <div class="contact-form">
                            <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form id="contactform" action="{{route('front.contact.submit')}}" method="POST">
                                {{csrf_field()}}
                                    @include('includes.admin.form-both')  

                                    <div class="form-input">
                                        <input type="text" name="name" placeholder="{{ $langg->lang47 }} *" required="">
                                        <i class="icofont-user-alt-5"></i>
                                    </div>
                                    <div class="form-input">
                                            <input type="text" name="phone"  placeholder="{{ $langg->lang48 }} *">
																						<i class="icofont-ui-call"></i>
                                    </div>
                                    <div class="form-input">
                                            <input type="email" name="email"  placeholder="{{ $langg->lang49 }} *" required="">
																						<i class="icofont-envelope"></i>
                                    </div>
                                    <div class="form-input">
                                            <textarea name="text" placeholder="{{ $langg->lang50 }} *" required=""></textarea>
                                    </div>
   
                                    @if($gs->is_capcha == 1)

                                    <ul class="captcha-area">
                                        <li>
                                            <p><img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i class="fas fa-sync-alt pointer refresh_code"></i></p>
                                        
                                        </li>
                                        <li>
                                                <input name="codes" type="text" class="input-field" placeholder="{{ $langg->lang51 }}" required="">
                                                
                                            </li>
                                    </ul>

                                    @endif


                                    <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                                    <button class="submit-btn" type="submit">{{ $langg->lang52 }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 text-center">
                    <img src="{{ asset('assets/front/images/payment-method/contact-pic.svg')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    
    <section class="con-map">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.8007897507186!2d67.11109931488!3d24.904775849613685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb339213d4913a1%3A0xcff8f5a5ea2f9e07!2sJohar%20Mor%20Bridge%2C%20Block%2010%20A%20Gulshan-e-Iqbal%2C%20Karachi%2C%20Karachi%20City%2C%20Sindh%2C%20Pakistan!5e0!3m2!1sen!2s!4v1637406447216!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="right-area">

                        @if($ps->site != null || $ps->email != null )
                        <div class="contact-info ">
                            <div class="content d-flex align-self-center">
                                <div class="content">
                                        <!--@if($ps->site != null && $ps->email != null) 
                                        <a href="{{$ps->site}}" target="_blank">{{$ps->site}}</a>
                                        <a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                                        @elseif($ps->site != null)
                                        <a href="{{$ps->site}}" target="_blank">{{$ps->site}}</a>
                                        @else
                                        <a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                                        @endif-->
                                        
                                        <div class="cont-det">
                                            <p><b>SUPPORT</b><br/>
                                            Email<br/>
                                            <a href="mailto:Support@ecpmarket.com">Support@ecpmarket.com</a>, <a href="mailto:info@ecpmarket.com">info@ecpmarket.com</a>
                                            </p>
                                            <p>
                                            <b>Phone</b><br/>
                                            <a href="tel:+922135662201">+92 213 5662201-2-3</a>
                                            </p>
                                            <p>
                                            <b>Office</b><br/>
                                            Office 103# First Floor Shafi Courts Civil Lines, Karachi.
                                            </p>
                                            <p>
                                            <b>HOURS OF OPERATION</b><br/>
                                            Monday:10:00-6:00 PM<br/>
                                            Tuesday:10:00-6:00 PM<br/>
                                            Wendnesday:10:00-6:00 PM<br/>
                                            Thursday:10:00-6:00 PM<br/>
                                            Friday:10:00-6:00 PM<br/>
                                            Saturday:10:00-6:00 PM
                                            </p>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!--@endif
                        @if($ps->street != null) 
                        <div class="contact-info">
                                <div class="left">
                                        <div class="icon">
                                                <i class="icofont-google-map"></i>
                                        </div>
                                </div>
                                <div class="content d-flex align-self-center">
                                    <div class="content">
                                            <p>
                                                @if($ps->street != null) 
                                                    {!! $ps->street !!}
                                                @endif
                                            </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($ps->phone != null || $ps->fax != null ) 
                            <div class="contact-info">
                                    <div class="left">
                                            <div class="icon">
                                                    <i class="icofont-smart-phone"></i>
                                            </div>
                                    </div>
                                    <div class="content d-flex align-self-center">
                                        <div class="content">
                                            @if($ps->phone != null && $ps->fax != null)
                                            <a href="tel:{{$ps->phone}}">{{$ps->phone}}</a>
                                            <a href="tel:{{$ps->fax}}">{{$ps->fax}}</a>
                                            @elseif($ps->phone != null)
                                            <a href="tel:{{$ps->phone}}">{{$ps->phone}}</a>
                                            @else
                                            <a href="tel:{{$ps->fax}}">{{$ps->fax}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        @endif


                                <div class="social-links">
                                    <h4 class="title">{{ $langg->lang53 }} :</h4>
                                    <ul>

                                     @if(App\Models\Socialsetting::find(1)->f_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->facebook }}" class="facebook" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->g_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->gplus }}" class="google-plus" target="_blank">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->t_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->twitter }}" class="twitter" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->l_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->linkedin }}" class="linkedin" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->d_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->dribble }}" class="dribbble" target="_blank">
                                            <i class="fab fa-dribbble"></i>
                                        </a>
                                      </li>
                                      @endif

                                        </ul>
                                </div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us Area End-->

@endsection