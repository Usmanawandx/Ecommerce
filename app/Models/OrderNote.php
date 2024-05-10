<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderNote extends Model
{
    protected $table = "order_notes";

    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }
}
