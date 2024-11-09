<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmumCart extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'cashier_id',
        'product_id',
        'price_per_qty',
        'qty',
        'price'
    ];

    /**
     * product
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}