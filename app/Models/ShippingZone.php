<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $table = 'shipping_zones';
    // protected $fillable = ['country_id', 'weight', 'price'];

    public $timestamps = false;

    // public function country()
    // {
    //     return $this->belongsTo(Country::class,'country_id');
    // }
}
