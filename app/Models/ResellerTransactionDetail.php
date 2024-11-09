<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerTransactionDetail extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'reseller_transaction_id',
        'product_id',
        'price_per_qty',
        'qty',
        'price'
    ];

    /**
     * transaction
     *
     * @return void
     */
    public function reseller_transaction()
    {
        return $this->belongsTo(ResellerTransaction::class);
    }

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
