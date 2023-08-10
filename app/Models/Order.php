<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Freelancer;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_description',
        'size',
        'quantity',
        'unit_price',
        'total_price',
        'vendor_name',
        'status',
        'status_description'
    ];
}
