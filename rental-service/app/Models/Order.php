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
        'down_payment',
        'discount',
        'delivery_fee',
        'late_fee',
        'total',
        'balance',
        'order_date',
        'return_date'
    ];

    protected $casts = [
        'order_date' => 'date',
        'return_date' => 'date',
        'down_payment' => 'float',
        'discount' => 'float',
        'delivery_fee' => 'float',
        'late_fee' => 'float',
        'total' => 'float',
        'balance' => 'float',
    ];

    public function items()
    {
        return $this->hasMany('\App\Models\OrderItem');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotal()
    {
        return $this->itemsTotal() +
            $this->late_fee +
            $this->delivery_fee -
            $this->discount;
    }

    public function totalPayments()
    {
        $totalItems = 0;
        foreach ($this->payments as $item){
            $totalItems += $item->amount;
        }

        return $totalItems;
    }

    public function adjustTotal()
    {
        $totalFinal = $this->getTotal();

        if ($this->total != $totalFinal)
        {
            $this->total = $totalFinal;
            $this->save();
        }
    }

    public function adjustBalance()
    {
        $totalPayment = $this->totalPayments();
        $totalFinal = $this->getTotal();

        if ($this->balance != $totalFinal - $totalPayment)
        {
            $this->balance = $totalFinal - $totalPayment;
            $this->save();
        }
    }

    public function itemsTotal()
    {
        $totalItems = 0;
        foreach ($this->items as $item)
        {
            $totalItems += $item->price * $item->qtd;
        }

        return $totalItems;
    }
}
