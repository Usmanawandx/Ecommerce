<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'price','maximum_discount', 'times','childcategories_id','users_id','brands_id','min_amount','max_amount', 'start_date','end_date'];
    public $timestamps = false;

    public function childcategories(){
        return $this->belongsTo('App\Models\Childcategory','childcategories_id');
    }
    public function brands(){
        return $this->belongsTo('App\Models\Brands','brands_id');
    }
    public function users(){
        return $this->belongsTo('App\Models\User','users_id');
    }
    public function coupons_sku(){
        return $this->hasMany('App\Models\coupons_sku','coupons_id');
    }
}
