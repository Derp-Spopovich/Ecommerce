<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Rating;
use App\Models\Category;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if (request('category')) {
            // $products = Category::where('name', request('category'))->firstOrFail()->products;
            $products = Product::with('category')->whereHas('category',function($query){
                $query->where('name',request()->category);  //view products by category
            });
        } else {
            $products = Product::take(9);
        }
        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate(9);
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc')->paginate(9);
        } else {
            $products = $products->inRandomOrder()->paginate(9);
        }

        return view('products.index')->with([
            'categories' => $categories,
            'products' => $products
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('seller-users')) { //cant create a product if you are not an seller role
            abort(403);                         //see AuthServiceProvider for code in gate
        }
        $categories = Category::all();
        return view('products.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'detail' => 'required|min:2',
            'price' => 'required|alpha_num',
            'category' => 'required',
            'photo' => 'required|image',
        ]);

         //handle file upload

        //Get file with the extension
        $fileNameWithExt = $request->file('photo')->getClientOriginalName();
        //Get just filename
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //Get just extension
        $extension = $request->file('photo')->getClientOriginalExtension();
        //Filename to store to make it unique para d ma delete if naay kaparihas ngan ang e upload
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        //upload image to public directory
        $path = $request->file('photo')->move(public_path('/products_photos'), $fileNameToStore);

        $product = New Product;
        $product->user_id = auth()->user()->id;
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->price = $request->price;
        $product->category_id = $request->category;
        $product->photo = $fileNameToStore;
        $product->save();

        return redirect()->route('products.index')->with('success', 'product successfully published');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $ratings = $product->ratings()->latest()->get();
        return view('products.show')->with([
            'product' => $product,
            'ratings' => $ratings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        $categories = Category::all();
        return view('products.edit')->with([
            'product' => $product,
            'categories' => $categories
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:2',
            'detail' => 'required|min:2',
            'price' => 'required|alpha_num',
            'photo' => 'image',
        ]);

        //handle file upload

        if ($request->hasFile('photo')) {
            //Get file with the extension
            $fileNameWithExt = $request->file('photo')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('photo')->getClientOriginalExtension();
            //Filename to store to make it unique para d ma delete if naay kaparihas ngan ang e upload
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('photo')->move(public_path('/products_photos'), $fileNameToStore);
        }

        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->price = $request->price;
        $product->category_id = $request->category;
        if ($request->hasFile('photo')) { 
            File::delete(public_path('products_photos/'. $product->photo)); //delete the file if the user has updated it
            $product->photo = $fileNameToStore;
        }
        $product->update();
        return redirect()->route('users.show', auth()->user())->with('success', 'product successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('deleted','Product successfully deleted');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%$query%")->latest()->paginate(5);
        return view('products.search')->with('products', $products);
    }
}
