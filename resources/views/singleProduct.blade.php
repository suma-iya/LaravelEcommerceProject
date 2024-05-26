<x-header />

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{URL::asset('uploads/profile/products/'.$product->picture) }}" alt="">
                                </div>
                            </div>
                           
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{$product->title}}</h4>
                           
                            <h3>{{$product->price}}.00 </h3>
                            <p>{{$product->description}}</p>
                            <form action="{{URL::to('/addToCart') }}" method="POST">
                                @csrf
                                <div class="product__details__cart__option">
                                    <div class="quantity">
                                    <input type="number" name="quantity" class="form-control" min="1" max="{{$product->quantity}}" value="1">
                                    </div>
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <button type="submit" name="addToCart" class="primary-btn">add to cart</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
 
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
   
    <!-- Related Section End -->
<x-footer />