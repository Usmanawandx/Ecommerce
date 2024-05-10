@extends('layouts.load')

@section('styles')

<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

@endsection

@section('content')

						<div class="content-area">

							<div class="add-product-content">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
											@include('includes.admin.form-error')
											<form id="geniusformdata" action="{{route('admin-prod-boosting',$data->id)}}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

												<div class="row">
													<div class="col-lg-5">
														<div class="left-area">
																<h4 class="heading">{{ __("Category Page") }}*</h4>
														</div>
													</div>
									                  <div class="col-sm-7">
                                                        <select name="category_boost" class="form-control">
                                                            <option value="0" {{$data->category_boost == 0 ? 'selected' : ''}}>no booting</option>
                                                            <option value="1" {{$data->category_boost == 1 ? 'selected' : ''}}>level 1</option>
                                                            <option value="2" {{$data->category_boost == 2 ? 'selected' : ''}}>level 2</option>
                                                            <option value="3" {{$data->category_boost == 3 ? 'selected' : ''}}>level 3</option>
                                                            <option value="4" {{$data->category_boost == 4 ? 'selected' : ''}}>level 4</option>
                                                            <option value="5" {{$data->category_boost == 5 ? 'selected' : ''}}>level 5</option>
                                                        </select>
									                  </div>
												</div>
                                                <div class="row">
													<div class="col-lg-5">
														<div class="left-area">
																<h4 class="heading">{{ __("Brand Page") }}*</h4>
														</div>
													</div>
									                  <div class="col-sm-7">
                                                        <select name="brand_boost" class="form-control">
                                                            <option value="0" {{$data->brand_boost == 0 ? 'selected' : ''}}>no booting</option>
                                                            <option value="1" {{$data->brand_boost == 1 ? 'selected' : ''}}>level 1</option>
                                                            <option value="2" {{$data->brand_boost == 2 ? 'selected' : ''}}>level 2</option>
                                                            <option value="3" {{$data->brand_boost == 3 ? 'selected' : ''}}>level 3</option>
                                                            <option value="4" {{$data->brand_boost == 4 ? 'selected' : ''}}>level 4</option>
                                                            <option value="5" {{$data->brand_boost == 5 ? 'selected' : ''}}>level 5</option>
                                                        </select>
									                  </div>
												</div>
                                                <div class="row">
													<div class="col-lg-5">
														<div class="left-area">
																<h4 class="heading">{{ __("Store Page") }}*</h4>
														</div>
													</div>
									                  <div class="col-sm-7">
                                                        <select name="vendor_boost" class="form-control">
                                                            <option value="0" {{$data->vendor_boost == 0 ? 'selected' : ''}}>no booting</option>
                                                            <option value="1" {{$data->vendor_boost == 1 ? 'selected' : ''}}>level 1</option>
                                                            <option value="2" {{$data->vendor_boost == 2 ? 'selected' : ''}}>level 2</option>
                                                            <option value="3" {{$data->vendor_boost == 3 ? 'selected' : ''}}>level 3</option>
                                                            <option value="4" {{$data->vendor_boost == 4 ? 'selected' : ''}}>level 4</option>
                                                            <option value="5" {{$data->vendor_boost == 5 ? 'selected' : ''}}>level 5</option>
                                                        </select>
									                  </div>
												</div>
                                                <div class="row">
													<div class="col-lg-5">
														<div class="left-area">

														</div>
													</div>
													<div class="col-lg-7">
														<button class="addProductSubmit-btn" type="submit">{{ __("Submit") }}</button>
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

