<!DOCTYPE html>
<html lang="en">
  
  <head>
    <base href="/public">
    @include('admin.css')

    <style>
      .title_deg{
        text-align: center;
        font-size: 25px;
        font-weight: bold
      }

      .table_deg{
        border: 2px solid white;
        width: 80%;
        margin: auto;
        text-align: center;
      }

      .th_deg{
        background-color: skyblue;
        color:black;
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
        <h1 class="title_deg">All Orders</h1>

        <div style="padding-left:400px; padding-bottom:30px">

          <form action="{{ url('search') }}" method="get">
            @csrf
            <input style="color:black;" type="text" name="search" placeholder="Search for Something">

            <input type="submit" value="Search" class="btn btn-outline-primary">
          </form>
        
        </div>

        <table class="table table_deg">
          <thead>
          <tr class="th_deg">
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Product Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Payment Status</th>
            <th>Delivery Status</th>
            <th>Image</th>
            <th>Delivered</th>
            <th>Print PDF</th>
            <th>Send Email</th>
          </tr>
        </thead>


        @forelse ($order as $order)
          <tr>
            <td>{{ $order->name }}</td>
            <td>{{ $order->email }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->product_title }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->price }}</td>
            <td>{{ $order->payment_status }}</td>
            <td>{{ $order->delivery_status }}</td>
            <td><img style="heigh:100px;" src="/product/{{ $order->image }}"></td>
            
            <td>
              @if($order->delivery_status == 'processing')
              <a href="{{ url('delivered',$order->id) }}" onclick="return confirm('Are you sure this Product is Delivered!!')" class="btn btn-primary">Delivered</a>

              @else
              <p style="color:green;">Delivered</p>
              @endif
            </td>

            <td><a href="{{ url('print_PDF',$order->id) }}" class="btn btn-secondary">Print PDF</a></td>

            {{-- adding the id allows you to get the particular id of the record. --}}
            <td><a href="{{ url('send_email', $order->id) }}" class="btn btn-info">Send Email</a></td>

          </tr>

        @empty
        <tr>
          <td style="text-align:center" cols="1">
            <p>No Data Found</p>
          </td>
        </tr>
        
        

        @endforelse

        </table>

      </div>
    </div>
      
    @include('admin.script')
  </body>
</html>