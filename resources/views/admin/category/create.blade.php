@extends('layouts.load')

@section('content')
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#category" class="nav-link active" data-toggle="tab">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#subcategory" class="nav-link" data-toggle="tab">Sub Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#childcategory" class="nav-link" data-toggle="tab">Child Categories</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="category">
                    <div class="content-area">

                        <div class="add-product-content1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-description">
                                        <div class="body-area">
                                            @include('includes.admin.form-error')
                                            <form id="geniusformdata" action="{{route('admin-cat-create')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Name') }} *</h4>
                                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Name') }}" required="" value="">
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
                                                        <input type="text" class="input-field" name="slug" placeholder="{{ __('Enter Slug') }}" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Title') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-7">
                                                            <div class="tawk-area">
                                                               <input type="text" required class="input-field" name="title" placeholder="Enter Title">
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Meta Description') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tawk-area">
                                                            <textarea class="form-control" required  name="meta_description"></textarea>
                                                        </div>
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
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="checkbox-wrapper">
                                                            <input type="checkbox" name="is_featured" class="checkclick" id="is_featured" value="1">
                                                            <label for="is_featured">{{ __('Allow Featured Category') }}</label>
                                                        </div>

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

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Set Slider') }} *</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="img-upload">
                                                            <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                                                <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Slider') }}</label>
                                                                <input type="file" name="slider" class="img-upload" id="image-upload">
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
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <button class="addProductSubmit-btn" type="submit">{{ __('Create Category') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="subcategory">
                    <div class="content-area">

                        <div class="add-product-content1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-description">
                                        <div class="body-area">
                                            @include('includes.admin.form-error')
                                            <form id="geniusformdata" action="{{route('admin-subcat-create')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __("Category") }}*</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select  name="category_id" required="">
                                                            <option value="">{{ __("Select Category") }}</option>
                                                            @foreach($cats as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __("Name") }} *</h4>
                                                            <p class="sub-heading">{{ __("(In Any Language)") }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="input-field" name="name" placeholder="{{ __("Enter Name") }}" required="" value="">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __("Slug") }} *</h4>
                                                            <p class="sub-heading">{{ __("(In English)") }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="input-field" name="slug" placeholder="{{ __("Enter Slug") }}" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Title') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="tawk-area">
                                                            <input type="text" required class="input-field" name="title" placeholder="Enter Title">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Meta Description') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tawk-area">
                                                            <textarea class="form-control" required  name="meta_description"></textarea>
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
                                                        <button class="addProductSubmit-btn" type="submit">{{ __("Create") }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="childcategory">
                    <div class="content-area">

                        <div class="add-product-content1">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product-description">
                                        <div class="body-area">
                                            @include('includes.admin.form-error')
                                            <form id="geniusformdata" action="{{route('admin-childcat-create')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Category') }} *</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select id="cat" required="">
                                                            <option value="">{{ __('Select Category') }}</option>
                                                            @foreach($cats as $cat)
                                                                <option data-href="{{ route('admin-subcat-load',$cat->id) }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Sub Category') }} *</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select id="subcat" name="subcategory_id" required="" disabled=""></select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Name') }} *</h4>
                                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Name') }}" required="" value="">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Slug') }} *</h4>
                                                            <p class="sub-heading">{{ __('(In English)') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <input type="text" class="input-field" name="slug" placeholder="{{ __('Enter Slug') }}" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Title') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="tawk-area">
                                                            <input type="text" required class="input-field" name="title" placeholder="Enter Title">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">
                                                            <h4 class="heading">{{ __('Meta Description') }} *</h4>
                                                            <p class="sub-heading">{{ __('In English') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="tawk-area">
                                                            <textarea class="form-control" required  name="meta_description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                      <div class="left-area">
                                                          <h4 class="heading">{{ __('Commision') }} *</h4>
                                                          <p class="sub-heading">{{ __('(In English)') }}</p>
                                                      </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                      <input type="text" class="input-field" name="comission" placeholder="comission" required="" value="">
                                                    </div>
                                                  </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="left-area">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <button class="addProductSubmit-btn" type="submit">{{ __('Create') }}</button>
                                                    </div>
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
@endsection
