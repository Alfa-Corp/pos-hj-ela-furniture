<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResellerTransaction extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'cashier_id',
        'customer_id',
        'invoice',
        'cash',
        'change',
        'discount',
        'grand_total'
    ];


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
     * customer
     *
     * @return void
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * cashier
     *
     * @return void
     */
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }


    /**
     * profits
     *
     * @return void
     */
    public function profits()
    {
        return $this->hasMany(ResellerProfit::class);
    }


    /**
     * createdAt
     *
     * @return Attribute
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i:s'),
        );
    }
}
