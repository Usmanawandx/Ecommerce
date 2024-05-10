@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')
                      <form id="geniusformdata" action="{{route('admin-brand-store')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Name') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" id="name" name="name" placeholder="{{ __('Enter Name') }}" required="" value="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Slug') }} *</h4>
                                <p class="sub-heading">{{ __('In English') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" id="slug" name="slug" placeholder="{{ __('Enter Slug') }}" required="" value="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Set Icon') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Icon') }}</label>
                                    <input type="file" name="photo" class="img-upload" id="image-upload">
                                  </div>
                            </div>

                          </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">{{ __('Set Slider') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                  <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Slider') }}</label>
                                  <input type="file" name="slider" class="img-upload">
                                </div>
                              </div>
                            </div>
                          </div>
<div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Link') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="link" placeholder="{{ __('Enter Slider Link') }}" >
                          </div>
                        </div>
                        <div class="row">
						<div class="col-lg-4">
							<div class="left-area">
							</div>
						</div>
						<div class="col-lg-7">
                            <div class="checkbox-wrapper">
                              <input type="checkbox" name="slider_status" id="slider_status" value="1">
                              <label for="slider_status">{{ __('Allow Slider') }}</label>
                            </div>

						</div>
					</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
														</div>
													</div>
													<div class="col-lg-7">
{{--							              <div class="checkbox-wrapper">--}}
{{--							                <input type="checkbox" name="is_featured" class="checkclick" id="is_featured" value="1">--}}
{{--							                <label for="is_featured">{{ __('Allow Featured Category') }}</label>--}}
{{--							              </div>--}}

													</div>
												</div>

						            <div class="showbox">

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">{{ __('Set Feature Image') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                  <label for="image-upload" class="img-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                  <input type="file" name="image" class="img-upload">
                                </div>
                              </div>
                            </div>
                          </div>

						            </div>


                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Brand') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<script>
    $(document).on('input','#name',function(){
        var name = $(this).val();
        var slug = name.replace(/\W+/g, '-').toLowerCase();
        $('#slug').val(slug);
    })
</script>
@endsection
