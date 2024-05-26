<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $data)
    {
        // dd($data->all());
        $bill = $data->input('bill');
        $fullname = $data->input('fullname');
        $phone = $data->input('phone');
        $address = $data->input('address');
        return view('stripe', compact('bill', 'fullname', 'phone', 'address'));
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // dd($request->all());
        \Stripe\Charge::create ([
                "amount" => $request->input('bill') * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'),
                "description" => "New Order Payment Received successfully" 
        ]);
      
        Session::flash('success', 'Payment successful!');
        
        if(session()->has('id')){
            $order = new Order();
            $order->status="Paid";
            $order->customerId = session()->get('id');
            $order->bill=$request->input('bill');
            $order->address=$request->input('address');
            $order->fullname=$request->input('fullname');
            $order->phone=$request->input('phone');
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
            return redirect('/cart')->with('success', 'Order placed successfully!');
        }

        return back();
    }
}

