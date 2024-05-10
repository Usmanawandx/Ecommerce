<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Models\User','vendor_id');
    }
}
