@extends('layouts.app')
@section('content')

<div class="container">
    <p class="display-4">Product Detail</p>
    <hr>
    <div class="row">
        <div class="col-sm">
            <a href="{{route('products.show',$product)}}">
                <img src="{{url('products_photos/'.$product->photo)}}" style="height: 100px" alt="">
            </a>
        </div>
        <div class="col-sm">
            <a href="">
                {{$product->name}}
            </a>
            <div class="row">
                <div class="col-sm">
                    <small class="form-text text-muted">{{$product->detail}}</small>
                </div>
            </div>
        </div>
        <div class="col-sm">
            {{$product->price}} php
        </div>
    </div>

    <hr>

    <br>

    <div class="card">
        <div class="card-header">
          Delivery Information
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('payments.store', $product)}}">
                @csrf
                <small class="form-text text-muted">Please provide the complete detail</small>
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label>Full Name</label>
                      <input type="text" name="fullName" value="{{ old('fullName') }}" class="form-control">
                        @error('fullName')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label>Contact Number</label>
                      <input type="number" name="contact" value="{{ old('contact') }}" class="form-control" placeholder="09xx" min="1">
                    @error('contact')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Complete Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control" placeholder="1234 Main St">
                    @error('address')
                    <p class="text-danger">{{$message}}</p>
                  @enderror
                </div>
                <div class="form-group">
                    <div class="col-7">
                        <label for="exampleFormControlSelect1">Payment Method</label>
                        <select class="form-control" name="mop">
                            <option>Cash On Delivery</option>
                            <option disabled>Credit/Debit Card</option>
                            <option disabled>Payment Center/E-wallet</option>
                            <option disabled>Over the counter</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-2">
                        <label for="exampleFormControlSelect1">Quantity</label>
                        <select class="form-control" name="quantity">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </div>
       
</div>
@endsection