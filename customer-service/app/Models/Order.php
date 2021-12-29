<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'Orders';

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'id',
        'customer_id',
        'status',
        'discount',
        'total',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'date',
        'total' => 'float',
        'discount' => 'float'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function delete()
    {
        $this->items()->delete();
        return parent::delete();
    }
}
