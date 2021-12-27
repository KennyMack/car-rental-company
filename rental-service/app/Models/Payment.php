<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'Payments';

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'id',
        'order_id',
        'customer_id',
        'payment_type',
        'description',
        'amount',
        'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'float'
    ];

    public $additional_attributes = ['customer'];

    public function getCustomerAttribute($value)
    {
        return $this->customer()->get('name');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
