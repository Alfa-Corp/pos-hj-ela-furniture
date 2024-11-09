<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\UmumTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\UmumSalesExport;

class UmumSaleController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        return Inertia::render('Apps/UmumSales/Index');
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
            $sales = UmumTransaction::with('cashier', 'customer')
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                // ->orWhere('invoice', '=', $request->invoice)
                ->get();

            //get total sales by range date
            $total = UmumTransaction::whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)
                // ->orWhere('invoice', '=', $request->invoice)
                ->sum('grand_total');
        }

        if($request->invoice != null){
            //get data sales by range date
            $sales = UmumTransaction::with('cashier', 'customer')
                ->where('invoice', '=', $request->invoice)
                ->get();

            //get total sales by range date
            $total = UmumTransaction::where('invoice', '=', $request->invoice)
                ->sum('grand_total');
        }

        return Inertia::render('Apps/UmumSales/Index', [
            'sales'    => $sales,
            'total'    => (int) $total
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

        $result = Excel::download(new UmumSalesExport($request->invoice, $request->start_date, $request->end_date), 'sales_umum : '.$request->start_date.' — '.$request->end_date.'.xlsx');

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
            $sales = UmumTransaction::with('cashier', 'customer')->where('invoice', '=', $request->invoice)->get();

            $total = UmumTransaction::where('invoice', '=', $request->invoice)->sum('grand_total');
        }

        if($request->start_date != null && $request->end_date != null){
            //get sales by range date
            $sales = UmumTransaction::with('cashier', 'customer')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

            //get total sales by range daate
            $total = UmumTransaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('grand_total');
        }

        //load view PDF with data
        $pdf = PDF::loadView('exports.sales_umum', compact('sales', 'total'));

        //return PDF for preview / download
        return $pdf->download('sales_umum : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }

    /**
     * detail
     *
     * @param  mixed $request
     * @return void
     */
    public function detail_invoice($detail_invoice)
    {
        $transaction = UmumTransaction::with(['umum_transaction_details.product', 'cashier', 'customer'])->where('invoice', $detail_invoice)->firstOrFail();

        return Inertia::render('Apps/UmumSales/Detail', [
            'transaction'         => $transaction,
        ]);
    }

}
