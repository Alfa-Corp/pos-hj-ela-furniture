<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_of_measurement_id',
        'barcode',
        'title',
        'description',
        'buy_price',
        'sell_price_reseller',
        'sell_price_umum',
        'stock',
        'is_favorite',
        'stock_minimal'
    ];

    /**
     * unit_of_measurement
     *
     * @return void
     */
    public function unit_of_measurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }


    /**
     * purchase_transaction_details
     *
     * @return void
     */
    public function purchase_transaction_details()
    {
        return $this->hasMany(PurchaseTransactionDetail::class);
    }

    /**
     * reseller_transaction_details
     *
     * @return void
     */
    public function reseller_transaction_details()
    {
        return $this->hasMany(ResellerTransactionDetail::class);
    }

    /**
     * umum_transaction_details
     *
     * @return void
     */
    public function umum_transaction_details()
    {
        return $this->hasMany(UmumTransactionDetail::class);
    }

}
