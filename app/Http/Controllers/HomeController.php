<?php

namespace App\Http\Controllers;

use App\Models\User; 
//Import the user model class
use Illuminate\Http\Request;
//Import the auth Facade
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class HomeController extends Controller
{
    
    public function index()
    {
        $product = Product::paginate(5);
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
        
          $product = Product::paginate(5);
        return view('home.userpage', compact('product'));
        
        }
    }


    //getting the id of the products
    public function product_details($id)
    {

        $product = product::find($id);

        return view('home.product_details', compact('product'));
    }
    
}
