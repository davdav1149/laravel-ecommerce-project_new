<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $primaryKey = "order_details_id";

    protected $fillable = [
        'order_details_id',
        'order_id',
        'product_id',
        'quantity',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class, "product_id", "product_id");
    }
}
