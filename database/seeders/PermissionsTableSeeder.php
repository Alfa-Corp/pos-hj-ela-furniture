<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission dashboard
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        // Dashboard Reseller
        Permission::create(['name' => 'dashboard.sales_chart_reseller', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_today_reseller', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_month_reseller', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profits_today_reseller', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profits_month_reseller', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.best_reseller_selling_product', 'guard_name' => 'web']);

        // Dashboard Umum
        Permission::create(['name' => 'dashboard.sales_chart_umum', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_today_umum', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.sales_month_umum', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profits_today_umum', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profits_month_umum', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.best_umum_selling_product', 'guard_name' => 'web']);

        // Dashboard
        Permission::create(['name' => 'dashboard.sales_all_transaction_month', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profit_all_transaction_month', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.assets', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.profit_net_month', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.cost_month', 'guard_name' => 'web']);
        Permission::create(['name' => 'dashboard.product_stock', 'guard_name' => 'web']);

        // Permission users
        Permission::create(['name' => 'users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);

        // Permission roles
        Permission::create(['name' => 'roles.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.delete', 'guard_name' => 'web']);

        // Permission permissions
        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web']);

        // Permission Unit of Measurement (UoM)
        Permission::create(['name' => 'unit_of_measurement.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'unit_of_measurement.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'unit_of_measurement.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'unit_of_measurement.delete', 'guard_name' => 'web']);

        // Permission products
        Permission::create(['name' => 'products.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.in', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.out', 'guard_name' => 'web']);
        Permission::create(['name' => 'products.buy_price', 'guard_name' => 'web']);

        // Permission Suppliers
        Permission::create(['name' => 'suppliers.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'suppliers.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'suppliers.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'suppliers.delete', 'guard_name' => 'web']);

        // Permission customers
        Permission::create(['name' => 'customers.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'customers.delete', 'guard_name' => 'web']);

        // Permissions Purchase
        Permission::create(['name' => 'purchase_transactions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'purchase_transactions.order', 'guard_name' => 'web']);
        Permission::create(['name' => 'purchase_transactions.retur', 'guard_name' => 'web']);

        // Permissions Cost Report
        Permission::create(['name' => 'purchase_report.index', 'guard_name' => 'web']);

        // Permission Cost transactions
        Permission::create(['name' => 'cost_transactions.index', 'guard_name' => 'web']);

        // Permissions Cost Report
        Permission::create(['name' => 'cost_report.index', 'guard_name' => 'web']);

        // Permission reseller transactions
        Permission::create(['name' => 'reseller_transactions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'reseller_transactions.order', 'guard_name' => 'web']);
        Permission::create(['name' => 'reseller_transactions.retur', 'guard_name' => 'web']);

        // Permissions transaction sales
        Permission::create(['name' => 'reseller_sales.index', 'guard_name' => 'web']);

        // Permissions profites
        Permission::create(['name' => 'reseller_profits.index', 'guard_name' => 'web']);

        // Permission umum transactions
        Permission::create(['name' => 'umum_transactions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'umum_transactions.order', 'guard_name' => 'web']);
        Permission::create(['name' => 'umum_transactions.retur', 'guard_name' => 'web']);

        // Permissions transaction sales
        Permission::create(['name' => 'umum_sales.index', 'guard_name' => 'web']);

        // Permissions profites
        Permission::create(['name' => 'umum_profits.index', 'guard_name' => 'web']);

    }
}
