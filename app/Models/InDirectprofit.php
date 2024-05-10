<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InDirectprofit extends Model
{
    //
    protected  $table = "indirect_profit";
    protected $fillable = ['user_id','deposit_id','commission_percent','amount'];
    public $timestamps = false;
}
