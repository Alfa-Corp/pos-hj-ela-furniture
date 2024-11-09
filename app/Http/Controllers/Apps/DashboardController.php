<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\CostTransaction;
use App\Models\ResellerProfit;
use App\Models\ResellerTransaction;
use App\Models\UmumProfit;
use App\Models\UmumTransaction;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // day
        $day    = Carbon::today();

        // week
        $week = Carbon::now()->subDays(7);

        // month
        $month = Carbon::now()->month;

        // year
        $year = Carbon::now()->year;

        // reseller
        // chart sales 7 days
        $chart_sales_reseller_week = DB::table('reseller_transactions')
            ->addSelect(DB::raw('DATE(created_at) as date, SUM(grand_total) as grand_total'))
            ->where('created_at', '>=', $week)
            ->groupBy('date')
            ->get();

        if (count($chart_sales_reseller_week)) {
            foreach($chart_sales_reseller_week as $result) {
                $sales_reseller_date[]   = $result->date;
                $reseller_grand_total[]  = (int)$result->grand_total;
            }
        } else {
            $sales_reseller_date[]   = "";
            $reseller_grand_total[]  = "";
        }

        // count sales today
        $count_sales_reseller_today = ResellerTransaction::whereDate('created_at', '=',  $day)->count();

        // count sales month
        $count_sales_reseller_month = ResellerTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        // sum sales today
        $sum_sales_reseller_today = ResellerTransaction::whereDate('created_at', '=', $day)->sum('grand_total');

        // sum sales month
        $sum_sales_reseller_month = ResellerTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('grand_total');

        // sum discount today
        $sum_sales_reseller_discount_today = ResellerTransaction::whereDate('created_at', '=', $day)->sum('discount');

        // sum discount month
        $sum_sales_reseller_discount_month = ResellerTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('discount');

        // sum profits today
        $sum_profits_reseller_today = ResellerProfit::whereDate('created_at', '=', $day)->sum('total');

        // sum profits month
        $sum_profits_reseller_month = ResellerProfit::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total');

        // sum profits month fix
        $sum_profits_reseller_month_fix = $sum_profits_reseller_month - $sum_sales_reseller_discount_month;

        // chart best selling product
        $chart_reseller_best_products = DB::table('reseller_transaction_details')
            ->addSelect(DB::raw('products.title as title, SUM(reseller_transaction_details.qty) as total'))
            ->join('products', 'products.id', '=', 'reseller_transaction_details.product_id')
            ->groupBy('reseller_transaction_details.product_id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        if (count($chart_reseller_best_products)) {
            foreach ($chart_reseller_best_products as $data) {
                $reseller_product[] = $data->title;
                $reseller_total[]   = (int)$data->total;
            }
        } else {
            $reseller_product[]  = "";
            $reseller_total[]    = "";
        }


        // umum
        // chart sales 7 days
        $chart_sales_umum_week = DB::table('umum_transactions')
            ->addSelect(DB::raw('DATE(created_at) as date, SUM(grand_total) as grand_total'))
            ->where('created_at', '>=', $week)
            ->groupBy('date')
            ->get();

        if (count($chart_sales_umum_week)) {
            foreach($chart_sales_umum_week as $result) {
                $sales_umum_date[]   = $result->date;
                $umum_grand_total[]  = (int)$result->grand_total;
            }
        } else {
            $sales_umum_date[]   = "";
            $umum_grand_total[]  = "";
        }

        // count sales today
        $count_sales_umum_today = UmumTransaction::whereDate('created_at', '=', $day)->count();

        // count sales month
        $count_sales_umum_month = UmumTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        // sum sales today
        $sum_sales_umum_today = UmumTransaction::whereDate('created_at', '=', $day)->sum('grand_total');

        // sum sales month
        $sum_sales_umum_month = UmumTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('grand_total');

        // sum discount today
        $sum_sales_umum_discount_today = UmumTransaction::whereDate('created_at', '=', $day)->sum('discount');

        // sum discount month
        $sum_sales_umum_discount_month = UmumTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('discount');

        // sum profits today
        $sum_profits_umum_today = UmumProfit::whereDate('created_at', '=', $day)->sum('total');

        // sum profits month
        $sum_profits_umum_month = UmumProfit::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total');

        // sum profits month fix
        $sum_profits_umum_month_fix = $sum_profits_umum_month - $sum_sales_umum_discount_month;

        // chart best selling product
        $chart_umum_best_products = DB::table('umum_transaction_details')
            ->addSelect(DB::raw('products.title as title, SUM(umum_transaction_details.qty) as total'))
            ->join('products', 'products.id', '=', 'umum_transaction_details.product_id')
            ->groupBy('umum_transaction_details.product_id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        if (count($chart_umum_best_products)) {
            foreach ($chart_umum_best_products as $data) {
                $umum_product[] = $data->title;
                $umum_total[]   = (int)$data->total;
            }
        } else {
            $umum_product[]  = "";
            $umum_total[]    = "";
        }

        // get product limit stock
        $products_limit_stock = Product::where(
            'is_favorite', true
            )->with('unit_of_measurement')->get();

        $assets = null;

        $products = Product::get();

        foreach($products as $product){
            $asset = $product->buy_price * $product->stock;
            $assets += $asset;
        }

        // sum sales all transaction month
        $sales_all_transaction_month    = $sum_sales_reseller_month + $sum_sales_umum_month;

        // sum profit transaction month
        $profit_all_transaction_month   = $sum_profits_reseller_month_fix + $sum_profits_umum_month_fix;

        // sum cost transaction month
        $cost_month = CostTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('grand_total');

        // sum profit net month
        $profit_net_month = $profit_all_transaction_month - $cost_month;


        return Inertia::render('Apps/Dashboard/Index', [
            // reseller
            'sales_reseller_date'            => $sales_reseller_date,
            'reseller_grand_total'           => $reseller_grand_total,
            'count_sales_reseller_today'     => (int) $count_sales_reseller_today,
            'count_sales_reseller_month'     => (int) $count_sales_reseller_month,
            'sum_sales_reseller_today'       => (int) $sum_sales_reseller_today,
            'sum_sales_reseller_month'       => (int) $sum_sales_reseller_month,
            'sum_profits_reseller_today'     => (int) $sum_profits_reseller_today - $sum_sales_reseller_discount_today,
            'sum_profits_reseller_month'     => (int) $sum_profits_reseller_month_fix,
            'reseller_product'               => $reseller_product,
            'reseller_total'                 => $reseller_total,
            // umum
            'sales_umum_date'            => $sales_umum_date,
            'umum_grand_total'           => $umum_grand_total,
            'count_sales_umum_today'     => (int) $count_sales_umum_today,
            'count_sales_umum_month'     => (int) $count_sales_umum_month,
            'sum_sales_umum_today'       => (int) $sum_sales_umum_today,
            'sum_sales_umum_month'       => (int) $sum_sales_umum_month,
            'sum_profits_umum_today'     => (int) $sum_profits_umum_today - $sum_sales_umum_discount_today,
            'sum_profits_umum_month'     => (int) $sum_profits_umum_month_fix,
            'umum_product'               => $umum_product,
            'umum_total'                 => $umum_total,

            'products_limit_stock'          => $products_limit_stock,
            'sales_all_transaction_month'   => (int) $sales_all_transaction_month,
            'profit_all_transaction_month'  => (int) $profit_all_transaction_month,
            'cost_month'                    => (int) $cost_month,
            'profit_net_month'              => (int) $profit_net_month,
            'assets'                        => $assets
        ]);



    }
}
