<?php

namespace App\Http\Controllers;

use App\Models\User; 
//Import the user model class
use Illuminate\Http\Request;
//Import the auth Facade
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index()
    {
        return view('home.userpage');
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
        
            return view('dashboard');
        
        }
    }
}
