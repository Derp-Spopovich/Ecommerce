<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Gate;

class CartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
       
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
    public function store(Request $request, Product $product)
    {
        if (auth()->user()->addedToCart($product)) {  //if the login user has added the product to cart already, (see in user model for the function)
            auth()->user()->carts()->detach($product);    //then remove the product in the cart
            return back()->with('deleted', 'Removed to Cart');
        } else {
            auth()->user()->carts()->attach($product); //else if not, then add the product to cart
            return back()->with('success', 'Added to Cart');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Gate::denies('buyer-admin-users')) { //cant view the payments if you are not an admin or a buyer
            abort(403);                         //see AuthServiceProvider for code in gate
        } elseif (auth()->user()->isNot($user)) { //else if, you cant view other users payments.
            \abort(403);
        }

        $carts = $user->carts()->paginate(5);
        return view('carts.show')->with([
            'carts' => $carts,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
