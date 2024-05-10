<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //
    protected  $table = "deposit";
    protected $fillable = ['deposit_date','bank_name','account_title','account_no','iban_no','amount','slip_no','remarks','payment_mode','epin','status'];
    public $timestamps = false;
}
