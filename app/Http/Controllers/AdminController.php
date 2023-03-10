<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//importing the model
use App\Models\Category;

class AdminController extends Controller
{
    //
    public function view_category()
    {
        //fetching all records from the database
        $data = Category::all(); 

        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request)
    {
        $data = new Category;

        $data->category_name = $request->category;

        $data->save();

        return redirect()->back()->with('message', 'Category Added Successfully');

    }

    public function delete_category($id)
    {
        $data = category::find($id);
        $data->delete();

        return redirect()->back()->with('message','Category Deleted Successfully');
    }
}
