<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Products;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Terwind\Components\raw;

class MainController extends Controller
{
    //
    public function index(){
        $allProducts = Products::all();
        $newArrivals = Products::where('type','new-arrivals')->get();
        $hotSales = Products::where('type','sale')->get();
        $allProducts = Products::all();
        // $allProducts = Product::all();

        // dd($allProducts);
        return view('index', compact('allProducts', 'newArrivals', 'hotSales'));

    }
    public function cart(){
        $cartItems = DB::table('products')
            ->join('carts', 'carts.product_id', '=', 'products.id') // Corrected join condition
            ->select('products.title','products.quantity as pQuantity','products.price', 'products.picture', 'carts.*')
            ->where('carts.customer_id', session()->get('id'))
            ->get();
        return view('cart', compact('cartItems'));
    }
    
    public function checkout(Request $data){
        if(session()->has('id')){
            $order = new Order();
            $order->status="Pending";
            $order->customerId = session()->get('id');
            $order->bill=$data->input('bill');
            $order->address=$data->input('address');
            $order->fullname=$data->input('fullname');
            $order->phone=$data->input('phone');
            if($order->save()){
                $carts = Cart::where('customer_id', session()->get('id'))->get();
                foreach($carts as $item){
                    $product = Products::find($item->product_id);
                    $orderItem = new OrderItem();
                    $orderItem->product_id = $item->product_id;
                    $orderItem->quantity = $item->quantity;
                    $orderItem->price=$product->price;
                    $orderItem->order_id = $order->id;
                    $orderItem->save();
                    $item->delete();
                }
            }
            return redirect()->back()->with('success', 'Order placed successfully!');
        }else{
            return redirect('login')->with('error', 'Please login to place order.');
        }
        // return view('checkout');
    }
    public function shop(){
        return view('shop');
    }
    public function singleProduct($id){
        $product = Products::find($id);
        return view('singleProduct',compact('product'));
    }
    public function register(){
        return view('register');
    }
    public function login(){
        return view('login');
    }
    public function logout(){
        session()->forget('id');
        session()->forget('type');
        return redirect('/');
    }
    public function registerUser(Request $request)
    {
        $newUser = new User();
        if($request->hasFile('file')){
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }
        $request->validate([
            'fullname' => 'required|string|max:255',
            // Other fields...
        ]);
        
        $newUser->Fullname = $request->input('fullname');
        $newUser->Email = $request->input('email');
        $newUser->Password = Hash::make($request->input('password')); // Hash the password
        $newUser->picture = $request->file('file')->getClientOriginalName();
        $request->file('file')->move('uploads/profile/', $newUser->picture);
        $newUser->type = "Customer";

        if ($newUser->save()) {
            return redirect('login')->with('success', 'User Registered Successfully!');
        }

        // Optionally handle the case where the user isn't saved successfully...
        return redirect()->back()->with('error', 'Failed to register user.');
    }  
    public function loginUser(Request $request){
        $user = User::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
            // If the user exists and the password is correct
            session()->put('id', $user->id);
            session()->put('type', $user->type);
    
            if($user->type == "Customer") {
                return redirect('/');
            }
            // You might want to handle redirection for other user types here
        } else {
            return redirect()->back()->with('error', 'Invalid Email or Password');
        }
    }
  public function addToCart(Request $data)
  {
      if (session()->has('id')) {
          $item = new Cart();
          $item->quantity = $data->input('quantity'); // Corrected access to quantity
          $item->product_id = $data->input('id'); // Corrected access to product_id
          $item->customer_id = session()->get('id');
          $item->save();
          return redirect()->back()->with('success', 'Product added to cart successfully!');
      } else {
          return redirect('login')->with('error', 'Please login to add product to cart.');
      }
  }
  
  // In your controller method that returns the form page
    public function showFormPage()
    {
        return response()
            ->view('your_form_page')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
    public function deleteCartItem($id){
        $item = Cart::find($id);
        $item->delete();
        return redirect()->back()->with('success', '1 Product has been deleted from cart successfully!');
    }
    public function updateCart(Request $data){
        if(session()->has('id')){
            $item = Cart::find($data->input('id'));
            $item->quantity = $data->input('quantity');
            $item->save();
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }else{
            return redirect('login')->with('error', 'Please login to update cart.');
        }
    }
    public function profile(){
        if(session()->has('id')){
            $user = User::find(session()->get('id'));
            return view('profile',compact('user'));    
        }
        return redirect('login')->with('error', 'Please login to view profile.');      
      }
    public function updateUser(Request $request){
        $user = User::find(session()->get('id'));
        $user->Fullname = $request->input('fullname');
        $user->Password = Hash::make($request->input('password'));
        if($request->file('file')!=null){
            $user->picture = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('uploads/profile/', $user->picture);
        }
        if($user->save()){
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }else{
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }

}


