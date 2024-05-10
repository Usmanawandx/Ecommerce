<!doctype html>
<html lang="en" dir="ltr">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="author" content="GeniusOcean">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Title -->
		<title>{{$gs->title}}</title>
		<!-- favicon -->
		<link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/>
		<!-- Bootstrap -->
		<link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
		<!-- Select 2 -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        {{-- Datatable --}}

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

		<!-- Fontawesome -->
		<link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome.css')}}">
		<!-- icofont -->
		<link rel="stylesheet" href="{{asset('assets/admin/css/icofont.min.css')}}">
		<!-- Sidemenu Css -->
		<link href="{{asset('assets/admin/plugins/fullside-menu/css/dark-side-style.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/admin/plugins/fullside-menu/waves.min.css')}}" rel="stylesheet" />

		<link href="{{asset('assets/admin/css/plugin.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/admin/css/plugin.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/admin/css/toastr.css')}}" rel="stylesheet" />
    	<link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-coloroicker.css') }}">
		<!-- Main Css -->

		<!-- stylesheet -->
		@if(DB::table('admin_languages')->where('is_default','=',1)->first()->rtl == 1)

		<link href="{{asset('assets/admin/css/rtl/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/admin/css/rtl/custom.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/admin/css/rtl/responsive.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />

		@else

		<link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/admin/css/common.css')}}" rel="stylesheet" />

		@endif

		@yield('styles')
<script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
	</head>
	<body>
		<div class="page">
			<div class="page-main">
				<!-- Header Menu Area Start -->
				<div class="header">
					<div class="container-fluid">
						<div class="d-flex justify-content-between">
							<a class="admin-logo" href="{{ route('front.index') }}" target="_blank">
								<img src="{{asset('assets/images/'.$gs->logo)}}" alt="">
							</a>
							<div class="menu-toggle-button">
								<a class="nav-link" href="javascript:;" id="sidebarCollapse">
									<div class="my-toggl-icon">
											<span class="bar1"></span>
											<span class="bar2"></span>
											<span class="bar3"></span>
									</div>
								</a>
							</div>

							<div class="right-eliment">
								<ul class="list">

									<input type="hidden" id="all_notf_count" value="{{ route('all-notf-count') }}">

									<li class="bell-area">
										<a id="notf_conv" class="dropdown-toggle-1" target="_blank" href="{{ route('front.index') }}">
										<i class="fas fa-globe-americas"></i>
										</a>
									</li>


									<li class="bell-area">
										<a id="notf_conv" class="dropdown-toggle-1" href="javascript:;">
											<i class="far fa-envelope"></i>
											<span id="conv-notf-count">{{ App\Models\Notification::countConversation() }}</span>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper" data-href="{{ route('conv-notf-show') }}" id="conv-notf-show">
										</div>
										</div>
									</li>

									<li class="bell-area">
										<a id="notf_product" class="dropdown-toggle-1" href="javascript:;">
											<i class="icofont-cart"></i>
											<span id="product-notf-count">{{ App\Models\Notification::countProduct() }}</span>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper" data-href="{{ route('product-notf-show') }}" id="product-notf-show">
										</div>
										</div>
									</li>

									<li class="bell-area">
										<a id="notf_user" class="dropdown-toggle-1" href="javascript:;">
											<i class="far fa-user"></i>
											<span id="user-notf-count">{{ App\Models\Notification::countRegistration() }}</span>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper" data-href="{{ route('user-notf-show') }}" id="user-notf-show">
										</div>
										</div>
									</li>

									<li class="bell-area">
										<a id="notf_order" class="dropdown-toggle-1" href="javascript:;">
											<i class="far fa-newspaper"></i>
											<span id="order-notf-count">{{ App\Models\Notification::countOrder() }}</span>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper" data-href="{{ route('order-notf-show') }}" id="order-notf-show">

										    </div>
										</div>
									</li>

									<li class="login-profile-area">
										<a class="dropdown-toggle-1" href="javascript:;">
											<div class="user-img">
												<img src="{{ Auth::guard('admin')->user()->photo ? asset('assets/images/admins/'.Auth::guard('admin')->user()->photo ):asset('assets/images/noimage.png') }}" alt="">
											</div>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper">
													<ul>
														<h5>{{ __('Welcome!') }}</h5>
															<li>
																<a href="{{ route('admin.profile') }}"><i class="fas fa-user"></i> {{ __('Edit Profile') }}</a>
															</li>
															<li>
																<a href="{{ route('admin.password') }}"><i class="fas fa-cog"></i> {{ __('Change Password') }}</a>
															</li>
															<li>
																<a href="{{ route('admin.logout') }}"><i class="fas fa-power-off"></i> {{ __('Logout') }}</a>
															</li>
														</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Header Menu Area End -->
				<div class="wrapper">
					<!-- Side Menu Area Start -->
					<nav id="sidebar" class="nav-sidebar">
						<ul class="list-unstyled components" id="accordion">
							<li>
								<a href="{{ route('admin.dashboard') }}" class="wave-effect"><i class="fa fa-home mr-2"></i>{{ __('Dashboard') }}</a>
							</li>
							@if(Auth::guard('admin')->user()->IsSuper())
							@include('includes.admin.roles.super')
							@else
							@include('includes.admin.roles.normal')
							@endif

						</ul>
					@if(Auth::guard('admin')->user()->IsSuper())
					<p class="version-name"> {{ __('Version') }}: 2.1</p>
					@endif
					</nav>
					<!-- Main Content Area Start -->
					@yield('content')
					<!-- Main Content Area End -->
					</div>
				</div>
			</div>

			@php
				$curr = \App\Models\Currency::where('is_default','=',1)->first();
			@endphp
			<script type="text/javascript">
			  var mainurl = "{{url('/')}}";
			  var admin_loader = {{ $gs->is_admin_loader }};
			  var whole_sell = {{ $gs->wholesell }};
			  var getattrUrl = '{{ route('admin-prod-getattributes') }}';
			  var curr = {!! json_encode($curr) !!};
				// console.log(curr);
			</script>

		<!-- Dashboard Core -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" ></script>


    <script src="{{asset('assets/admin/js/vendors/vue.js')}}"></script>
		<script src="{{asset('assets/admin/js/vendors/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
		<!-- Fullside-menu Js-->
		<script src="{{asset('assets/admin/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
		<script src="{{asset('assets/admin/plugins/fullside-menu/waves.min.js')}}"></script>

		<script src="{{asset('assets/admin/js/plugin.js')}}"></script>
		<script src="{{asset('assets/admin/js/Chart.min.js')}}"></script>
		<script src="{{asset('assets/admin/js/tag-it.js')}}"></script>
		<script src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
        <script src="{{asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{asset('assets/admin/js/notify.js') }}"></script>

        <script src="{{asset('assets/admin/js/jquery.canvasjs.min.js')}}"></script>

		<script src="{{asset('assets/admin/js/load.js')}}"></script>
		<!-- Custom Js-->
		<script src="{{asset('assets/admin/js/custom.js')}}"></script>
		<!-- AJAX Js-->
		<script src="{{asset('assets/admin/js/myscript.js')}}"></script>

		<script src="{{asset('assets/admin/js/addProduct.js')}}"></script>
		<script src="{{asset('assets/front/js/toastr.js')}}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
		<script>
			$(document).on("change",".toggle_check",function(){
		// alert($(this).is(':checked'));
			id = $(this).attr('data-prod');
			check = $(this).is(':checked');

				$.ajax({
				type: "GET",
				url :"{{route('admin-stock-status')}}",
				data: {
					'id':id,
					'check':check
				},
				success:function(){
						$('#geniustable').DataTable().ajax.reload();
				}

				})
			})
			// Order Status Update
			$(document).on('click','#status_update',function () {
				var ischeck = $('.check_status:checked').length;
				if (ischeck == 0) {
					alert("Please Select Atleast One Order To Update Status");
				}
				else{
					var id = [];
					var orderStatus = $('#order_status').val();
					$('.check_status:checked').each(function(i,e){
						id.push($(e).attr('data-id'));
					})
					$.ajax({
						type: 'GET',
						url: "{{route('order-status')}}",
						data: {
							'orderStatus' : orderStatus,
							'id':id,
						},
						success:function () {
							$('#allcheck').prop('checked',false);
							$('#geniustable').DataTable().ajax.reload();
						}
					})
				}
			})
			// Product Duplication
			$(document).on('click','#add_duplicate',function() {
				var ischeck = $('.check_duplicate:checked').length;
				if (ischeck == 0) {
					alert("Please Select Atleast One Product");
				}
				else
				{
					var id = [];
					$('.check_duplicate:checked').each(function(i,e) {
						id.push($(e).attr('data-id'));
					})
					$.ajax({
						type: 'GET',
						url: "{{route('duplicate-product')}}",
						data: {
							'id':id,
						},
						success:function (res) {
							$('#allcheckDupli').prop('checked',false);
							// toastr.success('res');
							$('#geniustable').DataTable().ajax.reload();
						}
					})
				}
			})
            // Product Delete
            $(document).on('click','#delete_product',function() {
				var ischeck = $('.check_duplicate:checked').length;
				if (ischeck == 0) {
					alert("Please Select Atleast One Product");
				}
				else
				{
					var id = [];
					$('.check_duplicate:checked').each(function(i,e) {
						id.push($(e).attr('data-id'));
					})
					$.ajax({
						type: 'GET',
						url: "{{route('delete-product')}}",
						data: {
							'id':id,
						},
						success:function (res) {
							$('#allcheckDupli').prop('checked',false);
							// toastr.success('res');
							$('#geniustable').DataTable().ajax.reload();
						}
					})
				}
			})
		</script>
		<script>
			$("#allcheck").click(function(){
    				$('.check_status').not(this).prop('checked', this.checked);
			});
		</script>
		<script>
			$("#allcheckDupli").click(function(){
    				$('.check_duplicate').not(this).prop('checked', this.checked);
			});
		</script>
		<script>
    $(document).on('dblclick','.folder',function() {
    var path = $(this).find('.path').attr('path');
    $.ajax({
            url:"{{route('get-cur-folder')}}",
            type:'get',
            data:{

                'path':path
            },
            success:function(response){
              $('#folders-section').html(response);
            },
    })
  })
  $(document).on('click','#create-folder',function(){
    $('#folder-modal').modal('show');
  })
  $(document).on('click','#upload-img',function(){
    $('#upload-modal').modal('show');
  })
  $(document).on('click','.file',function() {
    if($(this).find('.check-delete').is(':checked'))
    {
      $(this).find('.check-delete').prop('checked',false).css({"display":"none"});
    }
    else
    {
      $(this).find('.check-delete').prop('checked',true).css({"display":"block"});
    }
  })
  $(document).on('click','#delete-img',function() {
      var ischeck = $('.check-delete:checked').length;
      if (ischeck == 0) {
        toastr.error("Please Select Image");
      }
      else{
        var path = [];
        $('.check-delete:checked').each(function(i,e){
          path.push($(e).attr('data-path'));
        })
        $.ajax({
          type: 'get',
          url: "{{route('delete-img')}}",
          data:{
            'path':path
            },
          success:function (response) {
            location.reload();
            toastr.success(response.status);
          }
        })
      }
  })
</script>
		@yield('scripts')

@if($gs->is_admin_loader == 0)
<style>
	div#geniustable_processing {
		display: none !important;
	}
</style>
@endif

	</body>

</html>
