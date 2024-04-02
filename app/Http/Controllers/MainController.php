<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Products;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        return view('cart');
    }
    public function checkout(){
        return view('checkout');
    }
    public function shop(){
        return view('shop');
    }
    public function singleProduct(){
        return view('singleProduct');
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
}
