<?php

namespace App\Http\Controllers\Apps;


use App\Exports\ResellerProfitsExport;
use App\Http\Controllers\Controller;
use App\Models\ResellerProfit;
use App\Models\ResellerTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;

class ResellerProfitController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Apps/ResellerProfits/Index');
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
        $profits = ResellerProfit::with(['reseller_transaction' => function($q) {
                            $q->with([
                                'reseller_transaction_details',
                                'customer',
                                'cashier'
                            ]);
                        }])->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        //get total discount by range date
        $discount = ResellerTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('discount');

        //get total profit by range date
        $total = ResellerProfit::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('total');

        return Inertia::render('Apps/ResellerProfits/Index', [
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
        return Excel::download(new ResellerProfitsExport($request->start_date, $request->end_date), 'reseller_profits : '.$request->start_date.' — '.$request->end_date.'.xlsx');
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
        $profits = ResellerProfit::with('reseller_transaction')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        //get total discount by range date
        $discount = ResellerTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('discount');

        //get total profit by range date
        $total = ResellerProfit::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('total');

        //load view PDF with data
        $pdf = PDF::loadView('exports.profits_reseller', compact('profits', 'discount','total'));

        //download PDF
        return $pdf->download('reseller_profits : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }

}
