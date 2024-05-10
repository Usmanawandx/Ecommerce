<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    //
    protected  $table = "withdraw_request";
    protected $fillable = ['date','bank_name','account_title','iban','amount','user_id'];
    public $timestamps = false;
}
