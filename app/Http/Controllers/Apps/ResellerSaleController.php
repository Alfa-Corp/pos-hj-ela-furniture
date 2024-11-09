<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ResellerSalesExport;
use App\Http\Controllers\Controller;
use App\Models\ResellerTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ResellerSaleController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('Apps/ResellerSales/Index');
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        if($request->start_date != null && $request->end_date != null){
            //get data sales by range date
            $sales = ResellerTransaction::with('cashier', 'customer')
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->get();

            //get total sales by range date
            $total = ResellerTransaction::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                ->sum('grand_total');

            return Inertia::render('Apps/ResellerSales/Index', [
                'sales'    => $sales,
                'total'    => (int) $total
            ]);
        }

        if($request->invoice != null){
            //get data sales by range date
            $sales = ResellerTransaction::with('cashier', 'customer')
                ->where('invoice', '=', $request->invoice)
                ->get();

            //get total sales by range date
            $total = ResellerTransaction::where('invoice', '=', $request->invoice)
                ->sum('grand_total');

            return Inertia::render('Apps/ResellerSales/Index', [
                'sales'    => $sales,
                'total'    => (int) $total
            ]);
        }
    }


    /**
     * export
     *
     * @param  mixed $request
     * @return void
     */
    public function export(Request $request)
    {
        $result = Excel::download(new ResellerSalesExport($request->invoice, $request->start_date, $request->end_date), 'sales_reseller : '.$request->start_date.' — '.$request->end_date.'.xlsx');

        return $result;
    }

    /**
     * pdf
     *
     * @param  mixed $request
     * @return void
     */
    public function pdf(Request $request)
    {
        if($request->invoice != null){
            $sales = ResellerTransaction::with('cashier', 'customer')->where('invoice', '=', $request->invoice)->get();

            $total = ResellerTransaction::where('invoice', '=', $request->invoice)->sum('grand_total');
        }

        if($request->start_date != null && $request->end_date != null){
            //get sales by range date
            $sales = ResellerTransaction::with('cashier', 'customer')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

            //get total sales by range daate
            $total = ResellerTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('grand_total');
        }

        //load view PDF with data
        $pdf = PDF::loadView('exports.sales_reseller', compact('sales', 'total'));

        //return PDF for preview / download
        return $pdf->download('sales_reseller : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }


    /**
     * detail
     *
     * @param  mixed $request
     * @return void
     */
    public function detail_invoice($detail_invoice)
    {
        $transaction = ResellerTransaction::with(['reseller_transaction_details.product', 'cashier', 'customer'])->where('invoice', $detail_invoice)->firstOrFail();

        return Inertia::render('Apps/ResellerSales/Detail', [
            'transaction'         => $transaction,
        ]);
    }


}
