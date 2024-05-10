@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <div class="content-area">

              <div class="mr-breadcrumb">
                <div class="row">
                  <div class="col-lg-12">
                      <h4 class="heading">{{ __('Add New CMS Page') }} <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{ __("Back") }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Menu Page Settings') }} </a>
                        </li>
                        <li>
                          <a href="{{ route('admin-cmspage-index') }}">{{ __('CMS Pages') }}</a>
                        </li>
                        <li>
                          <a href="{{ route('admin-page-create') }}">{{ __('Add') }}</a>
                        </li>
                      </ul>
                  </div>
                </div>
              </div>

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">

                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                        @include('includes.admin.form-both')

                      <form id="geniusform" action="{{route('admin-cmspage-store')}}" method="POST" enctype="multipart/form-data">

                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Page Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="title" placeholder="{{ __('Title') }}" required="" >
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Page Slug') }} *</h4>
                                  <p class="sub-heading">{{ __('(In English)') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="slug" placeholder="{{ __('Slug') }}" required="">
                            </div>
                          </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Top Sliders') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="sliders[]" placeholder="{{ __('Top Sliders') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="slider_status" id="slider_status" value="1">
                                <label for="slider_status">{{ __('Allow Top Sliders') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 1 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block1title" placeholder="{{ __('Block 1 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 1 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block1[]" id="block1" class="block1" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 1') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner1[]" placeholder="{{ __('Banner 1') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block1_status" id="block1_status" value="1">
                                <label for="block1_status">{{ __('Allow Block 1') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 2 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block2title" placeholder="{{ __('Block 2 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 2 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block2[]" id="block2" class="block2" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 2') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner2[]" placeholder="{{ __('Banner 2') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block2_status" id="block2_status" value="1">
                                <label for="block2_status">{{ __('Allow Block 2') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 3 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block3title" placeholder="{{ __('Block 3 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 3 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block3[]" id="block3" class="block3" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 3') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner3[]" placeholder="{{ __('Banner 3') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block3_status" id="block3_status" value="1">
                                <label for="block3_status">{{ __('Allow Block 3') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 4 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block4title" placeholder="{{ __('Block 4 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 4 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block4[]" id="block4" class="block4" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 4') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner4[]" placeholder="{{ __('Banner 4') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block4_status" id="block4_status" value="1">
                                <label for="block4_status">{{ __('Allow Block 4') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 5 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block5title" placeholder="{{ __('Block 5 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 5 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block5[]" id="block5" class="block5" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 5') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner5[]" placeholder="{{ __('Banner 5') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block5_status" id="block5_status" value="1">
                                <label for="block5_status">{{ __('Allow Block 5') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Block 6 Title') }} *</h4>
                                  <p class="sub-heading">{{ __('In Any Language') }}</p>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="text" class="input-field" name="block6title" placeholder="{{ __('Block 6 Title') }}" required="" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __("Block 6 Sku's") }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                                <select name="block6[]" id="block6" class="block6" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Banner 6') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <input type="file" class="form-control-file" name="banner6[]" placeholder="{{ __('Banner 6') }}" required="" multiple>
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="block6_status" id="block6_status" value="1">
                                <label for="block6_status">{{ __('Allow Block 6') }}</label>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-7">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" name="secheck" class="checkclick" id="allowProductSEO" value="1">
                                    <label for="allowProductSEO">{{ __('Allow Page SEO') }}</label>
                                  </div>
                            </div>
                        </div>
                        <div class="showbox">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{ __('Meta Tags') }} *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <ul id="metatags" class="myTags">
                              </ul>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">
                                    {{ __('Meta Description') }} *
                                </h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="text-editor">
                                <textarea name="meta_description" class="input-field" placeholder="{{ __('Meta Description') }}"></textarea>
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
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Page') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">

{{-- TAGIT --}}

          $("#metatags").tagit({
          fieldName: "meta_tag[]",
          allowSpaces: true
          });

{{-- TAGIT ENDS--}}
</script>
<script>
    $(document).ready(function() {
    $('.block1, .block2, .block3, .block4, .block5, .block6').select2({
        ajax: {
    url: "{{route('admin-cmspage-getproduct')}}",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.results,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a sku',
  minimumInputLength: 3,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
   "<option value='"+repo.id+"'>"+repo.text+"<option>"
  );
  return $container;
}

function formatRepoSelection (repo) {
  return repo.text;
}
</script>
@endsection
