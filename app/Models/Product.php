<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','product_user', 'user_id', 'product_id')->withTimeStamps();
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function hasCategory($category)
    {
        if ($this->category()->where('name', $category)->first()) {
            return true;
        }
        return false;
    }

}
