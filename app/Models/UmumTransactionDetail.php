<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmumTransactionDetail extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'umum_transaction_id',
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
    public function umum_transaction()
    {
        return $this->belongsTo(UmumTransaction::class);
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
