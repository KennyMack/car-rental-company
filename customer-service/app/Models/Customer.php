<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'Customers';

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'id',
        'name',
        'email',
        'document',
        'phone',
        'address',
        'city',
        'state',
        'zipCode',
        'enabled'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
