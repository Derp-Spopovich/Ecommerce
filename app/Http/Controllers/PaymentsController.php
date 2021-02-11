<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if (Gate::denies('buyer-admin-users')) { //cant view the payments if you are not an admin or a buyer
            abort(403);                         //see AuthServiceProvider for code in gate
        } elseif (auth()->user()->isNot($user)) { //else if, you cant view other users payments.
            \abort(403);
        }
        // if (auth()->user()->isNot($user)) {
        // }
        $payments = $user->payments()->get();
        return view('payments.index')->with([
            'user'=>$user,
            'payments'=>$payments
            ]);
            // return view('payments.index')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('payments.create')->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'fullName' => 'required|alpha_spaces|min:3',
            'contact' => 'required|alpha_num|min:11|max:12',
            'address' => 'required|min:5'
            ]);

        if (auth()->user()->addedToCart($product)) {  //if the login user has added the product to cart already, (see in user model for the function)
            auth()->user()->carts()->detach($product);    //then remove the product in the cart
        } 

        $payment = New Payment;
        $payment->buyer_id = auth()->user()->id;
        $payment->seller_id = $product->user_id;
        $payment->product_id = $product->id;
        $payment->fullname = $request->fullName;
        $payment->complete_address = $request->address;
        $payment->contact_number = $request->contact;
        $payment->mode_of_payment = $request->mop;
        $payment->quantity = $request->quantity;
        $payment->total_price = $product->price * $request->quantity;
        $payment->save();
        return redirect()->route('payments.index', auth()->user())->with('success', 'Product successfully ordered!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Gate::denies('seller-users')) { //cant view the payments if you are not an seller role
            abort(403);                         //see AuthServiceProvider for code in gate
        } elseif (auth()->user()->isNot($user)) { //else if, you cant view other users order details.
            \abort(403);
        }
        $payments = $user->orders()->get();
        return view('payments.show')->with('payments', $payments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
