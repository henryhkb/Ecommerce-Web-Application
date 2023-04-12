<?php

namespace App\Http\Controllers;

use Stripe;
//Import the user model class
use Session;
//Import the auth Facade
use App\Models\Cart;

use App\Models\Order;

use App\Models\Reply;

use App\Models\User; 

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index()
    {
        $product = Product::paginate(6);
        //returning all the comments from the comment table
        $comment = comment::all();

        $reply = reply::all();

        return view('home.userpage', compact('product', 'comment', 'reply'));
    }
    
    
    
    //function for redirect
    public function redirect()
    {
        //when the user is trying to login check the user type
        $usertype = Auth::user()->usertype;

        if($usertype == '1'){

            // always the singular of the table (Getting the total products in a table)
            $total_product = product::all()->count();

            //getting the total orders made
            $total_orders = order::all()->count();

            //getting the total number of users
            $total_users = order::all()->count();

            //getting the total revenue by suming up all the records in the price field
            $orders = order::all();

            $total_revenue = 0;

            foreach($orders as $orders){
                $total_revenue = $total_revenue + $orders->price;
            }
            //end of getting the sum of total revenue from the orders table. 

            //getting the total number of delivery_status that says delivered
            $total_delivered = order::where('delivery_status', '=', 'delivered')->get()->count();

            //getting the total number of delivery_status that says processing
            $order_processing = order::where('delivery_status', '=', 'processing')->get()->count();

            return view('admin.home', compact('total_product', 'total_orders', 'total_users', 'total_revenue','total_delivered','order_processing'));
        
        }

        else{
            $product = Product::paginate(6);

            //returning all the comments from the comment table
            $comment = comment::orderby('id', 'desc')->get();

            $reply = reply::orderby('id', 'desc')->get();

            return view('home.userpage', compact('product', 'comment', 'reply'));
        
        }

 
    }


    //getting the id of the products
    public function product_details($id)
    {

        $product = product::find($id);

        return view('home.product_details', compact('product'));
    }



    public function add_cart(Request $request, $id)
    {
        //first checking if the user is logged in before adding to cart
        //else redirecting the user to the login page.
        if(Auth::id())
        {
            //return redirect()->back();
            
            //storing the user data here.
            $user = Auth::user();

            $product = product::find($id);

            $userid = $user->id;

            $product_exist_id = cart::where('Product_id', '=', $id)->where('user_id', '=', $userid)->get('id')->first();

            if($product_exist_id)
            {
                $cart = Cart::find($product_exist_id)->first();
                
                $quantity = $cart->quantity;
                
                $cart->quantity = $quantity + $request->quantity;

                if($product->discount !=null){

                    $cart->price = $product->discount * $cart->quantity;     
                if($product->discount !=null){

                $cart->price = $product->discount * $request->quantity;     
            
            }else{

                $cart->price = $product->price * $request->quantity;
            }
                }else{
    
                    $cart->price = $product->price * $cart->quantity;
                }

                $cart->save();
                
                return redirect()->back()->with('message', 'Product added successfully');
            }

            else{

            $cart = new Cart;

            //displaying product and cart input to the web page
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            
            
            $cart->user_id = $user->id;
            $cart->product_title = $product->title;

            //checking if the product has a discount price
            if($product->discount !=null){

                $cart->price = $product->discount * $request->quantity;     
            
            }else{

                $cart->price = $product->price * $request->quantity;
            }

            //$cart->price = $product->price;
            $cart->image = $product->image;
            $cart->Product_id = $product->id;

            //requesting input from the user
            $cart->quantity = $request->quantity;



            $cart->save();

            return redirect()->back()->with('message', 'Product added successfully');
            }

            $cart = new Cart;

            //displaying product and cart input to the web page
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            
            
            $cart->user_id = $user->id;
            $cart->product_title = $product->title;

            //checking if the product has a discount price
            if($product->discount !=null){

                $cart->price = $product->discount * $request->quantity;     
            
            }else{

                $cart->price = $product->price * $request->quantity;
            }

            //$cart->price = $product->price;
            $cart->image = $product->image;
            $cart->Product_id = $product->id;

            //requesting input from the user
            $cart->quantity = $request->quantity;



            $cart->save();

            return redirect()->back()->with('message', 'Product added successfully');

            


        }

        else{
            return redirect('login');
        }
    }

    public function showcart()
    {
        //checking to see if a user is logged in
        
        if(Auth::id()){
        
        //getting the user id to display the products in the cart
        $id = Auth::user()->id;
        
        $cart = cart::where('user_id', '=',  $id)->get();
        
        return view('home.showcart', compact('cart'));
        
        }
        
        else
    
        {
            return redirect('login');
        }

        
    }

    public function remove_cart($id)
    {
        $cart = cart::find($id);
        
        $cart->delete();

        return redirect()->back();
    }

    public function cash_order()
    {
        //find out which user is currrently logged in
        $user = Auth::user();

        $userid = $user->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach($data as $data)
        {

            $order = new order;

            $order->name = $data->name;

            $order->email = $data->email;

            $order->phone = $data->phone;

            $order->address = $data->address;

            $order->user_id = $data->user_id;


            $order->product_title = $data->product_title;
            
            $order->price = $data->price;

            $order->quantity = $data->quantity;

            $order->image = $data->image;

            $order->Product_id = $data->Product_id;


            $order->payment_status = 'cash on delivery';

            $order->delivery_status = 'processing';

            $order->save();

            //getting the id from the cart table and storing it in a variable
            $cart_id = $data->id;

            $cart = cart::find($cart_id);

            $cart->delete();


        }

        return redirect()->back()->with('message', 'We Received Your Oder, We will connect with you soon...');
        
    }



    public function stripe($totalPrice)
    {
        return view('home.stripe', compact('totalPrice'));
    }


    public function stripePost(Request $request, $totalPrice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalPrice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment" 
        ]);

        //moving the products to the order table after payment has been made.
        $user = Auth::user();

        $userid = $user->id;

        $data = cart::where('user_id', '=', $userid)->get();

        foreach($data as $data)
        {

            $order = new order;

            $order->name = $data->name;

            $order->email = $data->email;

            $order->phone = $data->phone;

            $order->address = $data->address;

            $order->user_id = $data->user_id;


            $order->product_title = $data->product_title;
            
            $order->price = $data->price;

            $order->quantity = $data->quantity;

            $order->image = $data->image;

            $order->Product_id = $data->Product_id;


            $order->payment_status = 'Paid';

            $order->delivery_status = 'processing';

            $order->save();

            //getting the id from the cart table and storing it in a variable
            $cart_id = $data->id;

            $cart = cart::find($cart_id);

            $cart->delete();


        }

        
      
        //Session::flash('success', 'Payment successful!');
              
        return back();
    }

    public function add_comment(Request $request)
    {
        //upload data to the comment table
        if(Auth::id())
        {
            //variable and the table name
            $comment = new Comment;

            //variable and the field of the table heading
            $comment->name = Auth::user()->name;
            
            $comment->user_id = Auth::user()->id;

            $comment->comment = $request->comment;

            $comment->save();

            //redirecting the use back after the comment has been added.
            return redirect()->back();
        }

        else{
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if(Auth::user())
        {
            $reply = new Reply;

            $reply->name=Auth::user()->name;

            $reply->user_id = Auth::user()->id;

            $reply->comment_id = $request->commentId;
            
            $reply->reply = $request->reply;

            $reply->save();

            return redirect()->back();
        }

        else{
            return redirect('login');
        }
    }


    public function product_search()
    {
        //searching product by the product name and by the product price
    }
    
    
}
