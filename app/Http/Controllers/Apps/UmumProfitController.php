<?php

namespace App\Http\Controllers\Apps;

use App\Exports\UmumProfitsExport;
use App\Http\Controllers\Controller;
use App\Models\UmumProfit;
use App\Models\UmumTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class UmumProfitController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Apps/UmumProfits/Index');
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        $this->validate($request, [
            'start_date'  => 'required',
            'end_date'    => 'required',
        ]);

        //get data profits by range date
        $profits = UmumProfit::with([
                        'umum_transaction' => function($q) {
                            $q->with([
                                'umum_transaction_details',
                                'customer',
                                'cashier',
                            ]);
                        }
                    ])->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        //get total discount by range date
        $discount = UmumTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('discount');

        //get total profit by range date
        $total = UmumProfit::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('total');

        return Inertia::render('Apps/UmumProfits/Index', [
            'profits'   => $profits,
            'discount'  => (int) $discount,
            'total'     => (int) $total
        ]);
    }

    /**
     * export
     *
     * @param  mixed $request
     * @return void
     */
    public function export(Request $request)
    {
        return Excel::download(new UmumProfitsExport($request->start_date, $request->end_date), 'profits_umum : '.$request->start_date.' — '.$request->end_date.'.xlsx');
    }

    /**
     * pdf
     *
     * @param  mixed $request
     * @return void
     */
    public function pdf(Request $request)
    {
        //get data proftis by range date
        $profits = UmumProfit::with([
                        'umum_transaction' => function($q) {
                            $q->with([
                                'umum_transaction_details',
                                'customer',
                                'cashier',
                            ]);
                        }
                    ])->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        //get total profit by range date
        $total = UmumProfit::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('total');

        $discount = UmumTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('discount');

        //load view PDF with data
        $pdf = PDF::loadView('exports.profits_umum', compact('profits', 'discount', 'total'));

        //download PDF
        return $pdf->download('profits_umum : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }

}
