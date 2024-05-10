<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class coupons_sku extends Model
{
    protected $fillable=['sku','coupons_id'];
    public function coupons(){
        return $this->belongsTo('App\Models\Coupon','coupons_id');
    }
    public $timestamps = false;
}
