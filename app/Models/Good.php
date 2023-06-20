<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Good extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => OrderStatus::class,
    ];
}
