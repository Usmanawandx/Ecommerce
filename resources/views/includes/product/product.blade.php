
									<div class="col-lg-4 col-md-4 col-6 remove-padding">


										<a href="{{ route('front.product', $prod->slug) }}" class="item">
											<div class="item-img">
												@if(!empty($prod->features))
													<div class="sell-area">
													  @foreach($prod->features as $key => $data1)
														<span class="sale" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
														@endforeach
													</div>
												@endif
													<div class="extra-list">
														<ul>
															<li>
																@if(Auth::guard('web')->check())

																<span class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																@else

																<span rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																	<i class="icofont-heart-alt"></i>
																</span>

																@endif
															</li>
															<li>
															<span class="quick-view" rel-toggle="tooltip" title="{{ $langg->lang55 }}" href="javascript:;" data-href="{{ route('product.quick',$prod->id) }}" data-toggle="modal" data-target="#quickview" data-placement="right"> <i class="icofont-eye"></i>
															</span>
															</li>
															<li>
																<span class="add-to-compare" data-href="{{ route('product.compare.add',$prod->id) }}"  data-toggle="tooltip" data-placement="right" title="{{ $langg->lang57 }}" data-placement="right">
																	<i class="icofont-exchange"></i>
																</span>
															</li>
														</ul>
													</div>
													@if($prod->thumbnail == null)
													    @if($prod->photo != null && file_exists(public_path().'assets/images/products/'.$prod->photo))
													    <img class="img-fluid" loading="lazy"  style="height: 200px;width: 200px;"  src="{{asset('assets/images/products/'.$prod->photo) }}" alt="">
													    @else
													    <img class="img-fluid" loading="lazy" style="height: 200px;width: 200px;"  src="{{asset('assets/images/noimage.png') }}" alt="">
													    @endif
													@elseif(file_exists(public_path().'assets/images/thumbnails/'.$prod->thumbnail))
													    <img class="img-fluid" loading="lazy" style="height: 200px;width: 200px;"  src="{{asset('assets/images/thumbnails/'.$prod->thumbnail) }}" alt="">
													@else
													    @if($prod->photo != null && file_exists(public_path().'assets/images/products/'.$prod->photo))
													    <img class="img-fluid" loading="lazy" style="height: 200px;width: 200px;"  src="{{asset('assets/images/products/'.$prod->photo) }}" alt="">
													    @else
													    <img class="img-fluid" loading="lazy" style="height: 200px;width: 200px;"  src="{{asset('assets/images/noimage.png') }}" alt="">
													    @endif
													@endif
												<!--<img class="img-fluid" style="height: 200px;width: 200px;" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="">-->
											</div>
											<div class="info">
												<div class="stars">
                            <div class="ratings">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
                            </div>
												</div>
												<h4 class="price">{{ $prod->setCurrency() }} <del><small>{{ $prod->showPreviousPrice() }}</small></del> <small class="text-success">{{$prod->discountPercent()}}</small></h4>
														<h5 class="name">{{ $prod->showName() }}</h5>
														<div class="item-cart-area">
															@if($prod->product_type == "affiliate")
																<span class="add-to-cart-btn affilate-btn"
																	data-href="{{ route('affiliate.product', $prod->slug) }}"><i class="icofont-cart"></i>
																	{{ $langg->lang251 }}
																</span>
															@else
																@if($prod->emptyStock())
																<span class="add-to-cart-btn cart-out-of-stock">
																	<i class="icofont-close-circled"></i> {{ $langg->lang78 }}
																</span>
																@else
																<span class="add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}">
																	<i class="icofont-cart"></i> {{ $langg->lang56 }}
																</span>
																<span class="add-to-cart-quick add-to-cart-btn"
																	data-href="{{ route('product.cart.quickadd',$prod->id) }}">
																	<i class="icofont-cart"></i> {{ $langg->lang251 }}
																</span>
																@endif
															@endif
														</div>
											</div>
										</a>

									</div>
