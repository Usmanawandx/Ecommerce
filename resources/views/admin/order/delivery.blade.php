@extends('layouts.load')




@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')
                      <form id="geniusformdata" action="{{route('admin-order-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Payment Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="payment_status" required="">
                                <option value="Pending" {{$data->payment_status == 'Pending' ? "selected":""}}>{{ __('Unpaid') }}</option>
                                <option value="Completed" {{$data->payment_status == 'Completed' ? "selected":""}}>{{ __('Paid') }}</option>
                              </select>
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Delivery Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="status" required="">
                                <option value="New" {{ $data->status == "New" ? "selected":"" }}>{{ __('New') }}</option>
                                <option value="processing" {{ $data->status == "processing" ? "selected":"" }}>{{ __('Processing') }}</option>
                                <option value="on delivery" {{ $data->status == "on delivery" ? "selected":"" }}>{{ __('On Delivery') }}</option>
                                <option value="completed" {{ $data->status == "completed" ? "selected":"" }}>{{ __('Completed') }}</option>
                                <option value="Cancelled" {{ $data->status == "Cancelled" ? "selected":"" }}>{{ __('Cancelled') }}</option>
                                <option value="Express" {{ $data->status == "Express" ? "selected":"" }}>{{ __('Express') }}</option>
                                 <option value="QC Failed" {{ $data->status == "QC Failed" ? "selected":"" }}>{{ __('QC Failed') }}</option>

                                  <option value="Return to vendor" {{ $data->status == "Return to vendor" ? "selected":"" }}>{{ __('Return to vendor') }}</option>
                                   <option value="Shipped- LCS" {{ $data->status == "Shipped- LCS" ? "selected":"" }}>{{ __('Shipped-LCS') }}</option>
                                    <option value="Shipped- ECP" {{ $data->status == "Shipped- ECP" ? "selected":"" }}>{{ __('Shipped-ECP') }}</option>
                                     <option value="Delivered" {{ $data->status == "Delivered" ? "selected":"" }}>{{ __('Delivered') }}</option>
                              </select>
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Track Note') }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <textarea class="input-field" name="track_text" placeholder="{{ __('Enter Track Note Here') }}"></textarea>
                          </div>
                        </div>



                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-note" tabindex="-1" role="dialog" aria-labelledby="modal-note" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                                            <div class="submit-loader">
                                                    <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
                                            </div>
                                        <div class="modal-header">
                                        <h5 class="modal-title"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">

                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                        </div>
                    </div>
                </div>

            </div>
@endsection

@section('scripts')





@endsection

