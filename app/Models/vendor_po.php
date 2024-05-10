<?php

namespace App\Models;


use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class vendor_po extends Model
{
    protected $fillable=[
        'po_number','vendor_id','total_amount'
    ];

    public function po_items(){
        return $this->hasMany('App\Models\po_product','vendor_pos_id');
    }
    public function vendor(){
        return $this->belongsTo('App\Models\User','vendor_id');
    }
}
