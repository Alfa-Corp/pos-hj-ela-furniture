<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductOutReportExport implements FromView
{
    protected $id;
    protected $start_date;
    protected $end_date;

    /**
     * __construct
     *
     * @param  mixed $start_date
     * @param  mixed $end_date
     * @return void
     */
    public function __construct($id, $start_date, $end_date)
    {
        $this->id = $id;
        $this->start_date = $start_date;
        $this->end_date   = $end_date;
    }

    /**
     * view
     *
     * @return View
     */
    public function view(): View
    {

        $products = Product::with([
            'reseller_transaction_details' => function($q){
                $q->with([
                    'reseller_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
            },
            'umum_transaction_details' => function($q){
                $q->with([
                    'umum_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
            },
        ])->findOrFail($this->id);

        return view('exports.reports_product_out', [
            'products' => $products
        ]);
    }
}
