<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Uuid;
    use HasFactory;

    protected $table = 'Products';

    public $incrementing = false;

    protected $keyType = "string";

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'qtdAvailable',
        'qtdTotal'
    ];
}
