<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//importing the model
use App\Models\Category;

use App\Models\Product;

use App\Models\Order;

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

    public function view_product()
    {
        $category = Category::all();

        return view('admin.product', compact('category'));
    }

    //inserting records to the products table
    public function add_product(Request $request)
    {
        $product = new Product;

        $product->title = $request->title;

        $product->description = $request->description;

        $product->price = $request->price;

        $product->quantity = $request->quantity;

        $product->category = $request->category;

        $product->discount = $request->dis_price;

        //saving the product image
        $image = $request->image;

        $imageName = time(). '' .  $image->getClientOriginalExtension();

        $request->image->move('product', $imageName);

        $product->image = $imageName;

        $product->save();

        return redirect()->back()->with('message', 'Product Saved Successfully');
    }

    public function show_product()
    {
        $product = product::all();
        return view('admin.show_product', compact('product'));

    }

    public function delete_product($id)
    {
        $product = product::find($id);

        $product->delete();

        return redirect()->back()->with('message', 'Product deleted successfully');
    
    }

    public function update_product($id)
    {
        $product = product::find($id);

        $category = category::all();

        //finding a specific product based on the id
        return view('admin.update_product', compact('product', 'category'));
    }

    public function update_product_confirm(Request $request,  $id)
    {
        $product = product::find($id);

        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->category=$request->quantity;
        $product->discount=$request->dis_price;
        $product->quantity=$request->quantity;

        $image=$request->image;

        if($image)
        {
        $imageName = time(). '.' . $image->getClientOriginalExtension();

        $request->image->move('product', $imageName);

        $product->image = $imageName;
        }


        $product->save();

        return redirect()->back()->with('message', 'Product updated successfully');
    }


    // Displaying all records in the order table
    public function order()
    {
        $order = order::all();

        return view('admin.order', compact('order'));
    }

    //adding the delivered function
    public function delivered($id)
    {

        //finding the id of the particular record to be delivered
        $order = order::find($id);

        //change the delivery status when the delivered button is clicked
        $order->delivery_status = "delivered";

        //change the payment status when the delivered button is clicked
        $order->payment_status = "Paid";

        $order->save();

        return redirect()->back();
    }

}
