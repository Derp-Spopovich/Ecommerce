@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="post" action="{{route('admin.update_product', $product->id)}}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" name="name" class="form-control" value="{{$product->name}}">
              @error('name')
                <p class="text-danger">{{$message}}</p>
              @enderror
            </div>
            <div class="form-group">
              <label>Product Detail</label>
              <textarea class="form-control" name="detail" rows="3">{{$product->detail}}</textarea>
              @error('detail')
                <p class="text-danger">{{$message}}</p>
              @enderror
            </div>
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="price" class="form-control" min="1" value="{{$product->price}}">
              @error('price')
                <p class="text-danger">{{$message}}</p>
              @enderror
            </div>
            <div class="form-group row">
                <label>Category</label>
                <div class="col-md-6">
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="{{$category->id}}"
                            {{ ($product->category_id == $category->id) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{$category->name}}
                            </label>
                       </div>
                    @endforeach
                  <small class="form-text text-muted">Please Provide an accurate category so your customers can easily see your product</small>
                </div>
            </div>
            <div class="form-group">
                <label>Product Image</label>
                  <input type="file" name="photo" value="{{$product->photo}}">
                  @error('photo')
                    <p class="text-danger">{{$message}}</p>
                  @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
@endsection