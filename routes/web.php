<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', function () {
    return \Inertia\Inertia::render('Auth/Login');
})->middleware('guest');

// prefix "apps"
Route::prefix('apps')->group(function() {
    // middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
        // route dashboard
        Route::get('dashboard', App\Http\Controllers\Apps\DashboardController::class)->name('apps.dashboard');

        // route permissions
        Route::get('/permissions', \App\Http\Controllers\Apps\PermissionController::class)->name('apps.permissions.index')->middleware('permission:permissions.index');

        //route resource roles
        Route::resource('/roles', \App\Http\Controllers\Apps\RoleController::class, ['as' => 'apps'])
            ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

        //route resource users
        Route::resource('/users', \App\Http\Controllers\Apps\UserController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|users.delete');

        //route resource unit of measurent
        Route::resource('/unit_of_measurement', \App\Http\Controllers\Apps\UnitOfMeasurementsController::class, ['as' => 'apps'])
        ->middleware('permission:unit_of_measurement.index|unit_of_measurement.create|unit_of_measurement.edit|unit_of_measurement.delete');

        //route resource products
        Route::resource('/products', \App\Http\Controllers\Apps\ProductController::class, ['as' => 'apps'])
        ->middleware('permission:products.index|products.create|products.edit|products.delete');

        // route report in product
        Route::get('/products/{id}/in',  [\App\Http\Controllers\Apps\ProductController::class, 'productIn'])->name('apps.product_in_report.in');

        // route report filter in product
        Route::get('/products/{id}/in/filter', [\App\Http\Controllers\Apps\ProductController::class, 'filterIn'])->name('apps.product_in_report.filter');

        // route report in product export excel
        Route::get('/products/{id}/in/export', [\App\Http\Controllers\Apps\ProductController::class, 'exportIn'])->name('apps.product_in_report.export');

        // route report in product export pdf
        Route::get('/products/{id}/in/pdf', [\App\Http\Controllers\Apps\ProductController::class, 'pdfIn'])->name('apps.product_in_report.pdf');

        // route report in product
        Route::get('/products/{id}/out',  [\App\Http\Controllers\Apps\ProductController::class, 'productOut'])->name('apps.product_out_report.out');

        // route report filter out product
        Route::get('/products/{id}/out/filter', [\App\Http\Controllers\Apps\ProductController::class, 'filterOut'])->name('apps.product_out_report.filter');

        // route report in product export excel
        Route::get('/products/{id}/out/export', [\App\Http\Controllers\Apps\ProductController::class, 'exportOut'])->name('apps.product_out_report.export');

        // route report in product export pdf
        Route::get('/products/{id}/out/pdf', [\App\Http\Controllers\Apps\ProductController::class, 'pdfOut'])->name('apps.product_out_report.pdf');

        //route report export excel
        Route::get('/product_report/export', [\App\Http\Controllers\Apps\ProductReportController::class, 'export'])->name('apps.product_report.export');

        //route report print pdf
        Route::get('/product_report/pdf', [\App\Http\Controllers\Apps\ProductReportController::class, 'pdf'])->name('apps.product_report.pdf');

        //route resource suppliers
        Route::resource('/suppliers', \App\Http\Controllers\Apps\SupplierController::class, ['as' => 'apps'])
        ->middleware('permission:suppliers.index|suppliers.create|suppliers.edit|suppliers.delete');

        //route report export excel
        Route::get('/suppliers_report/export', [\App\Http\Controllers\Apps\SupplierReportController::class, 'export'])->name('apps.suppliers_report.export');

        //route report print pdf
        Route::get('/suppliers_report/pdf', [\App\Http\Controllers\Apps\SupplierReportController::class, 'pdf'])->name('apps.suppliers_report.pdf');

        //route resource customers
        Route::resource('/customers', \App\Http\Controllers\Apps\CustomerController::class, ['as' => 'apps'])
            ->middleware('permission:customers.index|customers.create|customers.edit|customers.delete');

        //route report export excel
        Route::get('/customers_report/export', [\App\Http\Controllers\Apps\CustomerReportController::class, 'export'])->name('apps.customers_report.export');

        //route report print pdf
        Route::get('/customers_report/pdf', [\App\Http\Controllers\Apps\CustomerReportController::class, 'pdf'])->name('apps.customers_report.pdf');

        // PURCHASE
        //route transaction
        Route::get('/purchase_transactions', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'index'])->name('apps.purchase_transactions.index');

        //route transaction searchProduct
        Route::post('/purchase_transactions/searchProduct', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'searchProduct'])->name('apps.purchase_transactions.searchProduct');

        //route transaction addToCart
        Route::post('/purchase_transactions/addToCart', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'addToCart'])->name('apps.purchase_transactions.addToCart');

        //route transaction destroyCart
        Route::post('/purchase_transactions/destroyCart', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'destroyCart'])->name('apps.purchase_transactions.destroyCart');

        //route transaction store
        Route::post('/purchase_transactions/store', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'store'])->name('apps.purchase_transactions.store');

        //route transaction print
        Route::get('/purchase_transactions/print', [\App\Http\Controllers\Apps\PurchaseTransactionController::class, 'print'])->name('apps.purchase_transactions.print');

        //route report index
        Route::get('/purchase_report', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'index'])->middleware('permission:purchase_report.index')->name('apps.purchase_report.index');

        // route report detail
        Route::get('/purchase_report/detail_purchase/{invoice}', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'detail_invoice'])->name('apps.purchase_report.detail_invoice');

        //route report filter
        Route::get('/purchase_report/filter', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'filter'])->name('apps.purchase_report.filter');

        //route report invoice purchase
        Route::get('/purchase_report/search', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'search'])->name('apps.purchase_report.search');

        //route report export excel
        Route::get('/purchase_report/export', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'export'])->name('apps.purchase_report.export');

        // //route report print pdf
        Route::get('/purchase_report/pdf', [\App\Http\Controllers\Apps\PurchaseReportController::class, 'pdf'])->name('apps.purchase_report.pdf');

        // COST
        //route transaction
        Route::get('/cost_transactions', [\App\Http\Controllers\Apps\CostOperationalController::class, 'index'])->name('apps.cost_transactions.index');

        //route transaction addToCart
        Route::post('/cost_transactions/addToCart', [\App\Http\Controllers\Apps\CostOperationalController::class, 'addToCart'])->name('apps.cost_transactions.addToCart');

        //route transaction destroyCart
        Route::post('/cost_transactions/destroyCart', [\App\Http\Controllers\Apps\CostOperationalController::class, 'destroyCart'])->name('apps.cost_transactions.destroyCart');

        //route transaction store
        Route::post('/cost_transactions/store', [\App\Http\Controllers\Apps\CostOperationalController::class, 'store'])->name('apps.cost_transactions.store');

        //route transaction print
        Route::get('/cost_transactions/print', [\App\Http\Controllers\Apps\CostOperationalController::class, 'print'])->name('apps.cost_transactions.print');

        //route report index
        Route::get('/cost_report', [\App\Http\Controllers\Apps\CostReportController::class, 'index'])->middleware('permission:cost_report.index')->name('apps.cost_report.index');

        // route report detail
        Route::get('/cost_report/detail_cost/{invoice}', [\App\Http\Controllers\Apps\CostReportController::class, 'detail_invoice'])->name('apps.cost_report.detail_invoice');

        //route report filter
        Route::get('/cost_report/filter', [\App\Http\Controllers\Apps\CostReportController::class, 'filter'])->name('apps.cost_report.filter');

        //route report invoice cost
        Route::get('/cost_report/search', [\App\Http\Controllers\Apps\CostReportController::class, 'search'])->name('apps.cost_report.search');

        //route report export excel
        Route::get('/cost_report/export', [\App\Http\Controllers\Apps\CostReportController::class, 'export'])->name('apps.cost_report.export');

        //route report print pdf
        Route::get('/cost_report/pdf', [\App\Http\Controllers\Apps\CostReportController::class, 'pdf'])->name('apps.cost_report.pdf');

        // RESELLER

        //route transaction
        Route::get('/reseller_transactions', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'index'])->name('apps.reseller_transactions.index');

        //route transaction searchProduct
        Route::post('/reseller_transactions/searchProduct', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'searchProduct'])->name('apps.reseller_transactions.searchProduct');

        //route transaction addToCart
        Route::post('/reseller_transactions/addToCart', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'addToCart'])->name('apps.reseller_transactions.addToCart');

        //route transaction destroyCart
        Route::post('/reseller_transactions/destroyCart', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'destroyCart'])->name('apps.reseller_transactions.destroyCart');

        //route transaction store
        Route::post('/reseller_transactions/store', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'store'])->name('apps.reseller_transactions.store');

        //route transaction print
        Route::get('/reseller_transactions/print', [\App\Http\Controllers\Apps\ResellerTransactionController::class, 'print'])->name('apps.reseller_transactions.print');

        //route sales index
        Route::get('/reseller_sales', [\App\Http\Controllers\Apps\ResellerSaleController::class, 'index'])->middleware('permission:reseller_sales.index')->name('apps.reseller_sales.index');

        // route sales detail
        Route::get('/reseller_sales/detail_sales/{invoice}', [\App\Http\Controllers\Apps\ResellerSaleController::class, 'detail_invoice'])->name('apps.reseller_sales.detail_invoice');

        //route sales filter
        Route::get('/reseller_sales/filter', [\App\Http\Controllers\Apps\ResellerSaleController::class, 'filter'])->name('apps.reseller_sales.filter');

        //route sales export excel
        Route::get('/reseller_sales/export', [\App\Http\Controllers\Apps\ResellerSaleController::class, 'export'])->name('apps.reseller_sales.export');

        // //route sales print pdf
        Route::get('/reseller_sales/pdf', [\App\Http\Controllers\Apps\ResellerSaleController::class, 'pdf'])->name('apps.reseller_sales.pdf');

        //route profits index
        Route::get('/reseller_profits', [\App\Http\Controllers\Apps\ResellerProfitController::class, 'index'])->middleware('permission:reseller_profits.index')->name('apps.reseller_profits.index');

        // //route profits filter
        Route::get('/reseller_profits/filter', [\App\Http\Controllers\Apps\ResellerProfitController::class, 'filter'])->name('apps.reseller_profits.filter');

        // //route profits export
        Route::get('/reseller_profits/export', [\App\Http\Controllers\Apps\ResellerProfitController::class, 'export'])->name('apps.reseller_profits.export');

        // //route profits pdf
        Route::get('/reseller_profits/pdf', [\App\Http\Controllers\Apps\ResellerProfitController::class, 'pdf'])->name('apps.reseller_profits.pdf');

        // UMUM

        //route transaction
        Route::get('/umum_transactions', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'index'])->name('apps.umum_transactions.index');

        //route transaction searchProduct
        Route::post('/umum_transactions/searchProduct', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'searchProduct'])->name('apps.umum_transactions.searchProduct');

        //route transaction addToCart
        Route::post('/umum_transactions/addToCart', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'addToCart'])->name('apps.umum_transactions.addToCart');

        //route transaction destroyCart
        Route::post('/umum_transactions/destroyCart', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'destroyCart'])->name('apps.umum_transactions.destroyCart');

        //route transaction store
        Route::post('/umum_transactions/store', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'store'])->name('apps.umum_transactions.store');

        //route transaction print
        Route::get('/umum_transactions/print', [\App\Http\Controllers\Apps\UmumTransactionController::class, 'print'])->name('apps.umum_transactions.print');

        //route sales index
        Route::get('/umum_sales', [\App\Http\Controllers\Apps\UmumSaleController::class, 'index'])->middleware('permission:umum_sales.index')->name('apps.umum_sales.index');

        // route sales detail
        Route::get('/umum_sales/detail_sales/{invoice}', [\App\Http\Controllers\Apps\UmumSaleController::class, 'detail_invoice'])->name('apps.umum_sales.detail_invoice');

        //route sales filter
        Route::get('/umum_sales/filter', [\App\Http\Controllers\Apps\UmumSaleController::class, 'filter'])->name('apps.umum_sales.filter');

        //route sales search by invoice
        Route::get('/umum_sales/search', [\App\Http\Controllers\Apps\UmumSaleController::class, 'search'])->name('apps.umum_sales.search');

        //route sales export excel
        Route::get('/umum_sales/export', [\App\Http\Controllers\Apps\UmumSaleController::class, 'export'])->name('apps.umum_sales.export');

        //route sales print pdf
        Route::get('/umum_sales/pdf', [\App\Http\Controllers\Apps\UmumSaleController::class, 'pdf'])->name('apps.umum_sales.pdf');

        //route profits index
        Route::get('/umum_profits', [\App\Http\Controllers\Apps\UmumProfitController::class, 'index'])->middleware('permission:umum_profits.index')->name('apps.umum_profits.index');

        //route profits filter
        Route::get('/umum_profits/filter', [\App\Http\Controllers\Apps\UmumProfitController::class, 'filter'])->name('apps.umum_profits.filter');

        //route profits export
        Route::get('/umum_profits/export', [\App\Http\Controllers\Apps\UmumProfitController::class, 'export'])->name('apps.umum_profits.export');

        //route profits pdf
        Route::get('/umum_profits/pdf', [\App\Http\Controllers\Apps\UmumProfitController::class, 'pdf'])->name('apps.umum_profits.pdf');

    });
});

