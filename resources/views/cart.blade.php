<x-header />
<script src="https://js.stripe.com/v2/"></script>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($cartItems as $item)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                        <img src="{{ URL::asset('uploads/profile/products/' . $item->picture) }}" width="100px" alt="">

                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$item->title}}</h6>
                                            <h5>${{$item->price}}</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <form action="{{URL::to('updateCart')}}" method="post">
                                            @csrf
                                        <div class="quantity">
                                            <input type="number" class="form-control" min = "1" max = "{{$item->pQuantity}}" name = "quantity" value="{{$item->quantity}}">
                                        </div>
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <input type="submit" name="update" class="btn btn-success btn-block" value="Update">
                                        </form>
                                    </td>
                                    <td class="cart__price">$ {{$item->price * $item->quantity}}</td>
                                    <td class="cart__close"><a href="{{URL::to('deleteCartItem/'.$item->id)}}"><i class="fa fa-close"></i></td>
                                </tr>
                                @php
                                    $total += $item->price * $item->quantity;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="#">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>$ {{$total}}</span></li>
                            <li>Total <span>$ {{$total}}</span></li>
                        </ul>
                        <form action="{{URL::to('stripe') }}" method="get">
                            @csrf
                            <input type = "text" name="fullname" class="form-control mt-2" placeholder="Enter Full Name" id="" required>
                            <input type = "text" name="phone" class="form-control mt-2" placeholder="Enter Phone" id="" required>
                            <input type = "text" name="address" class="form-control mt-2" placeholder="Enter Address" id="" required>
                            <input type = "hidden" name="bill" class="form-control mt-2" value="{{$total}}" placeholder="Enter Address" id=""> 
                            <input type = "submit" name="checkout" class="primary-btn mt-2 btn-block" value="Proceed to checkout" id="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

 <x-footer/>