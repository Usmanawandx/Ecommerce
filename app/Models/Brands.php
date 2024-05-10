<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    //
    protected $fillable = ['name','photo','slug','slider','slider_status','link'];
    public $timestamps = false;


    public function coupon(){
        return $this->hasMany('App\Models\Coupon','brands_id');
    }
}
