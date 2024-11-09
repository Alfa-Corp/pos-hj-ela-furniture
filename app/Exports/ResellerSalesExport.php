<?php

namespace App\Exports;

use App\Models\ResellerTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ResellerSalesExport implements FromView
{

    protected $invoice;
    protected $start_date;
    protected $end_date;

    /**
     * __construct
     *
     * @param  mixed $start_date
     * @param  mixed $end_date
     * @return void
     */
    public function __construct($invoice, $start_date, $end_date)
    {
        $this->invoice = $invoice;
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
        if($this->invoice != null){
            $sales = ResellerTransaction::with('cashier', 'customer')->where('invoice', '=', $this->invoice)->get();
            $total = ResellerTransaction::where('invoice', '=', $this->invoice)->sum('grand_total');
        }

        if($this->start_date != null && $this->end_date != null){
            $sales = ResellerTransaction::with('cashier', 'customer')->whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->get();
            $total = ResellerTransaction::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->sum('grand_total');
        }

        return view('exports.sales_reseller', [
            'sales' => $sales,
            'total' => $total
        ]);
    }
}
