<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'q_bought',
        't_price'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
    

    public function Product() {
        return $this->belongsTo(Product::class);
    }
}
