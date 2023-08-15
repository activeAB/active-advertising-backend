<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'totalOrder',
        'totalCustomer',
        'totalStock',
        'allocatedOrder',
        'approvedOrder',
        'completedOrder',
        'deliveredOrder',
        'totalCost',
        'totalProfit',
        'totalRevenue',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];
}
