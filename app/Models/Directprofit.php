<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Directprofit extends Model
{
    //
    protected  $table = "direct_profit";
    protected $fillable = ['user_id','deposit_id','commission_percent','amount'];
    public $timestamps = false;
}
