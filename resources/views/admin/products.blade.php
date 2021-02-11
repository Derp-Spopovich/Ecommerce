@extends('layouts.app')
@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Product Name</th>
                <th scope="col">Posted By</th>
                <th scope="col">Product Price</th>
                <th scope="col">Date Created</th>
                <th scope="col">Options</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><a href="{{route('products.show', $product)}}"><img src="{{url('products_photos/'.$product->photo)}}" alt="" style="height: 100px"></a></td>
                        <td>{{$product->name}}</td>
                        <td><a href="{{route('users.show',$product->user)}}">{{$product->user->name}}</a></td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->created_at->format('M/d/y')}}</td>
                        <td>
                            <a href="{{route('admin.edit_product', $product)}}"><button class="btn btn-outline-primary">Edit</button></a>
                            <form action="{{route('admin.delete_product', $product)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{ $products->links() }}
        </table>
    </div>
@endsection