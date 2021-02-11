<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function carts()
    {
        return $this->belongsToMany('App\Models\Product', 'product_user', 'user_id', 'product_id')->withTimeStamps();
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'buyer_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Payment', 'seller_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) { //if this user has role in the given parameter
             return true;                                                //return true
        }
        return false;
    }

    //check if the user has anygive role like admin.
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function addedToCart(Product $product)
    {
        return $this->carts()->where('product_id', $product->id)->exists();
    }
    
}
