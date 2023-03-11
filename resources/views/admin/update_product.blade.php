<!DOCTYPE html>
<html lang="en">
  <head>

    <base href="/public">

    @include('admin.css')

    <style type="text/css">
        .div_center{
            text-align: center;
            padding-top: 40px;
        }

        .font_size{
            font-size: 40px;
            padding-top: 40px;
        }

        .text_color{
            color: black;
            padding-bottom: 20px;
        }

        label{
            display: inline-block;
            width: 200px; 
        }

        .div_design{
            padding-bottom: 15px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
      <!-- partial -->

    @include('admin.header')

    <div class="main-panel">
        <div class="content-wrapper">
             <div class="div_center">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session()->get('message') }}
                </div>
            @endif

                <h1 class="font_size">Update Product</h1>
            <form action="{{ url('/update_product_confirm', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="div_design">
                    <label for="title">Product Title:</label>
                    <input type="text" name="title" id="title" value="{{ $product->title }}" class="text_color" required>
                </div>
                
                <div class="div_design">
                    <label for="title">Product Description:</label>
                    <input type="text" name="description" id="description" value="{{ $product->description }}" class="text_color" required>
                </div>

                <div class="div_design">
                    <label for="title">Product Price:</label>
                    <input type="text" name="price" value="{{ $product->price }}" class="text_color" required> 
                </div>
                
                <div class="div_design">
                    <label for="title">Product Quantity</label>
                    <input type="number" name="quantity" min="0" value="{{ $product->quantity }}" class="text_color" required>
                </div>
                
                <div class="div_design">
                    <label for="title">Product Category:</label>
                    <select name="category" class="text_color">
                        <option value="{{ $product->category }}" selected="">{{ $product->category }}</option>

                        @foreach($category as $category)
                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="div_design">
                    <label for="title">Current Product Image:</label>
                    <img style="margin: auto" height="100" width="100" src="/product/{{ $product->image }}">
                </div>


                <div class="div_design">
                    <label for="title">Change Product Image:</label>
                    <input type="file" name="image" id="title" class="text_color">
                </div>

                <div class="div_design">
                    <label for="title">Discount Price:</label>
                    <input type="number" name="dis_price" value="{{ $product->discount }}" class="text_color" required>
                </div>

                <div class="div_design">
                    <input type="submit" value="Update Product" class="btn btn-primary">
                </div>
            </form>
            </div>
        </div>
    </div>
        <!-- partial -->
      
    @include('admin.script')
  </body>
</html>