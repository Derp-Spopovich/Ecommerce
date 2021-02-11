<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Role;
use App\Models\Category;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('admin-users')) {
            abort(403);
        }
        $users = User::all();
        return view('admin.index')->with('users', $users);
    }

    //show all products, if role is admin.
    public function indexProducts()
    {
        if (Gate::denies('admin-users')) {
            abort(403);
        }
        $products = Product::latest()->paginate(10);
        return view('admin.products')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $products = $user->products()->get();
        return view('users.show')->with([
            'user' => $user,
            'products' => $products
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (auth()->user()->isNot($user)) {
            abort(403);
        }
        $roles = Role::all();
        return view('users.edit')->with([
            'user'=>$user,
            'roles'=>$roles
            ]);
    }

    //only admin role can edit all users
    public function userEdit(User $user)
    {
        $roles = Role::all();
        return view('admin.edit')->with([
            'user'=>$user,
            'roles'=>$roles
            ]);
    }

    //only admin role can edit all products
    public function productEdit(Product $product)
    {
        $categories = Category::all();
        return view('admin.productsEdit')->with([
            'product' => $product,
            'categories' => $categories
            ]);
    }

    //only admin role can update users
    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($user)],
        'bio' => ['nullable','string', 'min:5']
        ]);
        
        $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->update();
        return redirect()->route('admin.index_users')->with('success', 'User ' . $user->name . ' updated');
    }

    //only admin role can update products
    public function productUpdate(Request $request, Product $product)
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

        return redirect()->route('admin.index_products')->with('success', 'Product successfully updated by admin');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($user)],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'bio' => ['nullable','string', 'min:5']
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->bio = $request->bio;
        $user->update();
        return redirect()->route('users.show', $user->id)->with('success', 'Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User Successfully deleted');
    }

    public function productDestroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product Successfully deleted by admin');
    }
}
