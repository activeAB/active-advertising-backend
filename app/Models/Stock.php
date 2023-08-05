<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable=[
        'item_description',
        'quantity',
        'unit_price',
        'total_price',
        'unit_measurement',
        'purchase_date',
        'expire_date',
        'dealer_name',
    ];
}
