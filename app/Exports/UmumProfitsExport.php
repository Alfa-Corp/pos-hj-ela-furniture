<?php

namespace App\Exports;

use App\Models\UmumProfit;
use App\Models\UmumTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UmumProfitsExport implements FromView
{
    protected $start_date;
    protected $end_date;

    /**
     * __construct
     *
     * @param  mixed $start_date
     * @param  mixed $end_date
     * @return void
     */
    public function __construct($start_date, $end_date)
    {
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
        return view('exports.profits_umum', [
            'profits' => UmumProfit::with('umum_transaction')->whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->get(),
            'discount' => UmumTransaction::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->sum('discount'),
            'total' => UmumProfit::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->sum('total')
        ]);
    }
}
