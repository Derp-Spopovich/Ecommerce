@extends('layouts.app')
@section('content')
  <div class="container">
    <p class="display-4">Search Result</p>
    <p>{{$products->count()}} result(s) for {{request()->input('query')}}</p>
    <table class="table">
      <thead class="thead-dark">
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Product Name</th>
            <th scope="col">Details</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
        </tr>
      </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                <td><a href="{{route('products.show', $product)}}"><img src="{{url('/products_photos/'.$product->photo)}}" alt="product photo" style="height: 80px;"></a></td>
                <td>{{$product->name}}</td>
                <td>{{$product->detail}}</td>
                <td><a href="{{route('products.index', ['category' => $product->category->name]) }}">{{$product->category->name}}</td>
                <td>{{$product->price}}</td>
                </tr>
            @empty
                <p>No Products in search result
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
   
  </div>
@endsection