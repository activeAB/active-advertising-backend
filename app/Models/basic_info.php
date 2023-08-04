<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basic_info extends Model
{
    use HasFactory;
    protected $fillable = [
        "active_tin_nUmber",
        "active_account_number",
        "active_vat",
        "active_phone_number",
        "active_email",
    ];
}
