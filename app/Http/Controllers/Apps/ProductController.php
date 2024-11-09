<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ProductInReportExport;
use App\Exports\ProductOutReportExport;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UnitOfMeasurement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get products
        $products = Product::when(request()->q, function($products) {
            $products = $products->where('title', 'like', '%'. request()->q . '%');
        })->with('unit_of_measurement')->latest()->paginate(10);

        //return inertia
        return Inertia::render('Apps/Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get unit of measurement
        $unitofmeasurements = UnitOfMeasurement::all();

        //return inertia
        return Inertia::render('Apps/Products/Create', [
            'unit_of_measurements' => $unitofmeasurements
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * validate
         */
        $this->validate($request, [
            'barcode'               => 'required|unique:products',
            'title'                 => 'required',
            'description'           => 'required',
            'unit_of_measurement_id'=> 'required',
            'buy_price'             => 'required',
            'sell_price_reseller'   => 'required',
            'sell_price_umum'       => 'required',
            'stock'                 => 'required',
        ]);

        //create product
        Product::create([
            'barcode'                   => $request->barcode,
            'title'                     => $request->title,
            'description'               => $request->description,
            'unit_of_measurement_id'    => $request->unit_of_measurement_id,
            'buy_price'                 => $request->buy_price,
            'sell_price_reseller'       => $request->sell_price_reseller,
            'sell_price_umum'           => $request->sell_price_umum,
            'stock'                     => $request->stock,
            'is_favorite'               => $request->is_favorite,
            'stock_minimal'             => $request->stock_minimal
        ]);

        //redirect
        return redirect()->route('apps.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //get categories
        $unitofmeasurements = UnitOfMeasurement::all();

        return Inertia::render('Apps/Products/Edit', [
            'product' => $product,
            'unit_of_measurements' => $unitofmeasurements
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        /**
         * validate
         */
        $this->validate($request, [
            'barcode'               => 'required|unique:products,barcode,'.$product->id,
            'title'                 => 'required',
            'description'           => 'required',
            'unit_of_measurement_id'=> 'required',
            'buy_price'             => 'required',
            'sell_price_reseller'   => 'required',
            'sell_price_umum'       => 'required',
            'stock'                 => 'required',
        ]);

        //update product
        $product->update([
            'barcode'                   => $request->barcode,
            'title'                     => $request->title,
            'description'               => $request->description,
            'unit_of_measurement_id'    => $request->unit_of_measurement_id,
            'buy_price'                 => $request->buy_price,
            'sell_price_reseller'       => $request->sell_price_reseller,
            'sell_price_umum'           => $request->sell_price_umum,
            'stock'                     => $request->stock,
            'is_favorite'               => $request->is_favorite,
            'stock_minimal'             => $request->stock_minimal,
        ]);

        //redirect
        return redirect()->route('apps.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find by ID
        $product = Product::findOrFail($id);

        //delete
        $product->delete();

        //redirect
        return redirect()->route('apps.products.index');
    }

    /*
     * History In the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productIn($id)
    {

        $products = Product::with([
            'purchase_transaction_details' => function($q) {
                $q->with([
                    'purchase_transaction' => function($q) {
                        $q->with([
                            'supplier'
                        ]);
                    }
                ]);
            }
        ])->findOrFail($id);

        return Inertia::render('Apps/Products/In', [
            'products' => $products,
        ]);
    }


    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filterIn($id, Request $request)
    {
        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        $products = Product::with([
            'purchase_transaction_details' => function($q) use ($request) {
                $q->with([
                    'purchase_transaction' => function($q){
                        $q->with([
                            'supplier'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            }
        ])->findOrFail($id);

        return Inertia::render('Apps/Products/In', [
            'products' => $products,
        ]);
    }

    /**
     * export
     *
     * @param  mixed $request
     * @return void
     */
    public function exportIn($id, Request $request)
    {

        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        return Excel::download(new ProductInReportExport($id, $request->start_date, $request->end_date), 'report_product_in : '.$request->start_date.' — '.$request->end_date.'.xlsx');
    }

    /**
     * pdf
     *
     * @param  mixed $request
     * @return void
     */
    public function pdfIn($id, Request $request)
    {

        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        $products = Product::with([
            'purchase_transaction_details' => function($q) use ($request) {
                $q->with([
                    'purchase_transaction' => function($q){
                        $q->with([
                            'supplier'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            }
        ])->findOrFail($id);

        $pdf = PDF::loadView('exports.reports_product_in', compact('products'));

        return $pdf->download('report_product_in : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }

    /*
     * History Out the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productOut($id, Request $request)
    {

        $products = Product::with([
            'reseller_transaction_details' => function($q) use ($request) {
                $q->with([
                    'reseller_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ]);
            },
            'umum_transaction_details' => function($q) use ($request) {
                $q->with([
                    'umum_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ]);
            },
        ])->findOrFail($id);

        return Inertia::render('Apps/Products/Out', [
            'products' => $products,
        ]);
    }

        /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filterOut($id, Request $request)
    {
        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        $products = Product::with([
            'reseller_transaction_details' => function($q) use ($request) {
                $q->with([
                    'reseller_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            },
            'umum_transaction_details' => function($q) use ($request) {
                $q->with([
                    'umum_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            },
        ])->findOrFail($id);

        return Inertia::render('Apps/Products/Out', [
            'products' => $products,
        ]);
    }

    /**
     * export
     *
     * @param  mixed $request
     * @return void
     */
    public function exportOut($id, Request $request)
    {

        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        return Excel::download(new ProductOutReportExport($id, $request->start_date, $request->end_date), 'report_product_out : '.$request->start_date.' — '.$request->end_date.'.xlsx');
    }


    /**
     * pdf
     *
     * @param  mixed $request
     * @return void
     */
    public function pdfOut($id, Request $request)
    {

        $this->validate($request, [
            'start_date'   => 'required',
            'end_date'   => 'required'
        ]);

        $products = Product::with([
            'reseller_transaction_details' => function($q) use ($request) {
                $q->with([
                    'reseller_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            },
            'umum_transaction_details' => function($q) use ($request) {
                $q->with([
                    'umum_transaction' => function($q){
                        $q->with([
                            'customer'
                        ]);
                    }
                ])
                ->whereDate('created_at', '>=', $request->start_date)
                ->whereDate('created_at', '<=', $request->end_date);
            },
        ])->findOrFail($id);

        $pdf = PDF::loadView('exports.reports_product_out', compact('products'));

        return $pdf->download('report_product_out : '.$request->start_date.' — '.$request->end_date.'.pdf');
    }

}
