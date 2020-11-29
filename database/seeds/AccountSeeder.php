<?php

use Illuminate\Database\Seeder;
use App\ErpAccountsCategory;
use App\ErpAccountsClass;
use App\ErpChartOfAccounts;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ErpAccountsCategory::create([
            'category_name' => 'Equity',
            'active_status' => 1,
        ]);
        ErpAccountsCategory::create([
            'category_name' => 'Asset',
            'active_status' => 1,
        ]);
        ErpAccountsCategory::create([
            'category_name' => 'Liability',
            'active_status' => 1,
        ]);
        ErpAccountsCategory::create([
            'category_name' => 'Income',
            'active_status' => 1,
        ]);
        ErpAccountsCategory::create([
            'category_name' => 'Expense',
            'active_status' => 1,
        ]);
    }
}
