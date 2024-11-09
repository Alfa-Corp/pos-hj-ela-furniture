<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductInReportExport implements FromView
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
            'purchase_transaction_details' => function($q) {
                $q->with([
                    'purchase_transaction' => function($q){
                        $q->with([
                            'supplier'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $this->start_date)
                ->whereDate('created_at', '<=', $this->end_date);
            }
        ])->findOrFail($this->id);

        return view('exports.reports_product_in', [
            'products' => $products
        ]);
    }
}
