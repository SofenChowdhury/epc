<?php

namespace App\Http\Controllers;

use App\ErpAccountsCategory as Category;
use App\ErpChartOfAccounts;
use App\ErpProject as Project;
use App\ErpTransaction as Transaction;
use App\Http\Resources\categoryResource;
use App\Http\Resources\projectResource;
use Illuminate\Http\Request;

class ApiTransactionController extends Controller
{
    public function project() {
        return projectResource::collection(Project::latest()->get());
    }

    public function category(Request $request) {
        if (!empty($request->keywords)){
            return categoryResource::collection(ErpChartOfAccounts::where('child', '=', NULL)
                ->where('coa_name', 'like', '%'.$request->keywords.'%')
                ->orWhere('coa_reference_no', 'like', '%'.$request->keywords.'%')
                ->get());
        }
//       return categoryResource::collection(Category::orderBy('id', 'DESC')->get());
        return categoryResource::collection(ErpChartOfAccounts::where('child', '=', NULL)->get());
    }

    public function vouchar() {
        $voucherNo = 1;
        $lastTransaction = Transaction::latest()->first();
        if($lastTransaction) {
            $voucherNo = ++$lastTransaction->voucher_no;
        }
        return $voucherNo;
    }
}
