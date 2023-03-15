<?php

namespace App\Http\Controllers;

use App\Models\User; 
//Import the user model class
use Illuminate\Http\Request;
//Import the auth Facade
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

use App\Models\Cart;

class HomeController extends Controller
{
    
    public function index()
    {
        $product = Product::paginate(6);
        return view('home.userpage', compact('product'));
    }
    
    
    
    //function for redirect
    public function redirect()
    {
        //when the user is trying to login check the user type
        $usertype = Auth::user()->usertype;

        if($usertype == '1'){

            return view('admin.home');
        
        }

        else{
        
            $product = Product::paginate(6);
            return view('home.userpage', compact('product'));
        
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

            $cart->price = $product->price;
            $cart->image = $product->image;
            $cart->Product_id = $product->id;

            //requesting input from the user
            $cart->quantity = $request->quantity;



            $cart->save();

            return redirect()->back();

            


        }

        else{
            return redirect('login');
        }
    }
    
}
