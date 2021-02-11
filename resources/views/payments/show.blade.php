@extends('layouts.app')
@section('content')
  <div class="container">
    <p class="display-4">Orders Details</p>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Product</th>
          <th scope="col">Product Name</th>
          <th scope="col">Full Name</th>
          <th scope="col">Delivery Address</th>
          <th scope="col">ContactNumber</th>
          <th scope="col">Mode Of Payment</th>
          <th scope="col">Product Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">Total Price</th>
          <th scope="col">Ordered Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($payments as $payment)
        <tr>
          <td><a href="{{route('products.show', $payment->product)}}"><img src="{{url('/products_photos/'.$payment->product->photo)}}" alt="product photo" style="height: 80px;"></a></td>
          <td>{{$payment->product->name}}</td>
          <td>{{$payment->fullname}}</td>
          <td>{{$payment->complete_address}}</td>
          <td>{{$payment->contact_number}}</td>
          <td><strong>{{$payment->mode_of_payment}}</strong></td>
          <td>{{$payment->product->price}}</td>
          <td>{{$payment->quantity}}</td>
          <td>{{$payment->total_price}}</td>
          <td>{{$payment->created_at->format('M/d/y')}}</td>
        </tr>
        @empty
        <p>No orders yet. <a href="/products/create">Create Products to post</a></p>
      @endforelse
      </tbody>
    </table>
   
  </div>
@endsection