<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['user_id', 'cart', 'method','shipping', 'pickup_location', 'totalQty', 'pay_amount', 'txnid', 'charge_id', 'order_number', 'payment_status', 'customer_email', 'customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_zip','shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address','shipping_province', 'shipping_city', 'shipping_zip', 'order_note', 'status'];

    public function vendororders()
    {
        return $this->hasMany('App\Models\VendorOrder');
    }
    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItem','order_id');
    }
    public function order_notes()
    {
        return $this->hasMany('App\Models\OrderNote','order_id');
    }
    public function tracks()
    {
        return $this->hasMany('App\Models\OrderTrack','order_id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City','customer_city');
    }
    public function scity()
    {
        return $this->belongsTo('App\Models\City','shipping_city');
    }
    public function province()
    {
        return $this->belongsTo('App\Models\Country','customer_country');
    }
    public function sprovince()
    {
        return $this->belongsTo('App\Models\Country','shipping_province');
    }
}
