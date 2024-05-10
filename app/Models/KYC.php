<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KYC extends Model
{
    //
    protected  $table = "kyc";
    protected $fillable = ['cnic','name','dob','nic_front','nic_back','address','father_name'];
    public $timestamps = false;
}
