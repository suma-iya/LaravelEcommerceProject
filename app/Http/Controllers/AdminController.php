<?php

namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;

use App\Models\OrderItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    //
    public function index(){
        if(session()->get('type')=='Admin'){
            return view('Dashboard.index');
        }
        else{
            return redirect()->back();
        }
    }
    public function products(){
        if(session()->get('type')=='Admin'){
            $products = Products::all();
            return view('Dashboard.products', compact('products'));
        }
        else{
            return redirect()->back();
        }
    }
    public function AddNewProduct(Request $request){
        if(session()->get('type')=='Admin'){
            $products = new Products();
            $products->title = $request->title;
            $products->price = $request->price;
            $products->quantity = $request->quantity;
            $products->description = $request->description;
            $products->category = $request->category;
            $products->type = $request->type;
            $products->picture = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('uploads/profile/products/', $products->picture);
            $products->save();
            return redirect()->back()->with('success', 'Product Added Successfully!');
        }
        else{
            return redirect()->back();
        }
    }
    public function UpdateProduct(Request $request){
      if(session()->get('type')=='Admin'){
        $products = Products::find($request->id);
        $products->title = $request->title;
        $products->price = $request->price;
        $products->quantity = $request->quantity;
        $products->description = $request->description;
        $products->category = $request->category;
        $products->type = $request->type;
        $products->picture = $request->file('file')->getClientOriginalName();
        $request->file('file')->move('uploads/profile/products/', $products->picture);
        $products->save();
      }
      else{
        return redirect()->back();
      }
    }
    public function deleteProduct($id){
        if(session()->get('type')=='Admin'){
        $products = products::find($id);
        $products->delete();
        }
        return redirect()->back()->with('success', 'Product Deleted Successfully!');
    }
    public function profile(){
        if(session()->get('type')=='Admin'){
            $user = User::find(session()->get('id'));
            return view('Dashboard.profile',compact('user'));
        }
        else{
            return redirect()->back()->with('success', 'Profile Updated Successfully!');
        }
    }
    public function customers(){
        if(session()->get('type')=='Admin'){
            $customers = User::where('type', 'Customer')->get();
            return view('Dashboard.customers', compact('customers'));
        } else {
            return redirect()->back();
        }
    }
    public function orders(){
        if(session()->get('type')=='Admin'){
            $orders = DB::table('users')
            ->join('orders', 'orders.customerId', '=', 'users.id')
            ->select('orders.*', 'users.fullname','users.email')
            ->get();    
            return view('Dashboard.orders', compact('orders'));
        }else { 
            return redirect()->back();
        }
    }

    public function changeOrderStatus($status, $id){
       
        if(session()->get('type')=='Admin'){
            $order = Order::find($id);
            $order->status = $status;
            $order->save();
            return redirect()->back()->with('success', 'Order Status Updated Successfully!');
        }else{
            return redirect()->back();
        }
    }
}
