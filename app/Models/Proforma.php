<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;
    protected $fillable = [
        "invoice_date",
        "payment_request_number",

        "active_tin_nUmber",
        "active_account_number",
        "active_vat",
        "active_phone_number",
        "active_email",

        "client_name",
        "client_tin_number",
        "client_phone_number",

        "price_validity",
        "payment_method",
        "contact_person",
        "total_price",
        "status",
        "total_profit",
        "description"
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function updateStatus()
    {
        $orderStatuses = $this->orders()->pluck('status')->toArray();

        if (count($orderStatuses) > 0 && !in_array('Unallocated', $orderStatuses) && !in_array('Allocated', $orderStatuses)) {
            $this->status = "Completed";
            $this->save();
        }
    }
}
