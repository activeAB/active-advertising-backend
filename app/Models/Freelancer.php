<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;
    protected $fillable = [
        'freelancer_first_name',
        'freelancer_last_name',
        'freelancer_address',
        'freelancer_phone_number',
        'freelancer_email',
        'freelancer_image_url',
        'freelancer_portfolio_link',
        'freelancer_order_status',
        'delete_role',
        'status'
    ];
}
