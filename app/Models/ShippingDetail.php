<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Childcategory;
use App\Models\ShippingZone;
class ShippingDetail extends Model
{
    protected $table = 'Shipping_Details';
    // protected $fillable = ['country_id', 'weight', 'price'];

    public $timestamps = false;

    public function child()
    {
        return $this->belongsTo(Childcategory::class,'child_id');
    }
    public function zone()
    {
        return $this->belongsTo(ShippingZone::class,'zone_id');
    }
}
