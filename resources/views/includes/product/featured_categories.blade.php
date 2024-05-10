    <div class="col-sm-12">
       <a href="{{ route('front.category', $prod->slug) }}" class="item">
        <div class="item-img">
                <div class="extra-list">
                    <ul>
                        <li>
                        </li>
                    </ul>
                </div>
            <img class="img-fluid" style="width: 100%;" src="{{ $prod->photo ? asset('assets/images/categories/'.$prod->photo):asset('assets/images/noimage.png') }}" alt="">
        </div>
        <div class="item-content">
            <h4 class="h6 text-compress text-secondary text-center">{{$prod->name}}</h4>
            <!--<h4 class="h6 text-compress text-secondary text-center"> Disover  {{count($prod->products)}} Products</h4>-->
        </div>
    </a>
   </div>

