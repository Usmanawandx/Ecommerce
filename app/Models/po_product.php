<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class po_product extends Model
{
    protected $fillable=[
        'vendor_pos_id','order_no','product_sku','product_name','size','color','quantity','amount'
    ];
    public function vendor_po(){
        return $this->belongsTo('App\Models\vendor_po','vendor_pos_id');
    }
}
