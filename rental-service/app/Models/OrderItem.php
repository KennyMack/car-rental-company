<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'OrderItems';

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'qtd',
        'price',
        'total'
    ];

    protected $casts = [
        'qtd' => 'int',
        'total' => 'float'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function adjustTotalValueAndPrice()
    {
        // throw '0';
        $total = $this->price * $this->qtd;
        if (($this->price != $this->product->price && isset($this->product->price)) ||
            $total != $this->total)
        {
            $this->price = ($this->product->price) ?? 0;
            $this->total = $this->price * $this->qtd;
            $this->save();
        }

        // $this->price = $item->product->price;
        // $this->total = 15;

        // $totalPrice = $this->product->price * $this->qtd;
        //
        // if ($totalPrice != $this->total) {
        //     $this->price = $this->product->price;
        //     $this->total = $this->product->price * $this->qtd;
        //     $this->save();
        // }

        /*
        $price = $this->product->price;
        if ($this->price != $price)
            $this->price = $this->product->price;

        $totalValue = $this->price * $this->qtd;
        if ($totalValue != $this->total) {
            $this->total = $this->price * $this->qtd;
            $this->save();
        }
        */
    }
}
