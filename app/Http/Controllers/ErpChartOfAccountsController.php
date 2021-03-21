<?php

namespace App\Http\Controllers;

use App\ErpCoaHeader;
use Illuminate\Http\Request;
use App\ErpAccountsCategory;
use App\ErpChartOfAccounts;
use App\ErpProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpChartOfAccountsController extends Controller
{
    public function coa_view() {
        $categories = ErpAccountsCategory::orderBy('category_reference_no')->get();
        $children = ErpChartOfAccounts::where('coa_parent', '!=', null)->where('active_status', 1)->get();

        return view('backEnd.chart_of_accounts.coa_view', compact('categories', 'children'));
    }
    public function accountList(){
        $coas = ErpChartOfAccounts::all();
        return view('backEnd.chart_of_accounts.accountList', compact('coas'));
    }

    public function addNewCoaHeader(){
        $category = ErpCoaHeader::all();
        $coas = ErpChartOfAccounts::where('active_status', 1)->get();
        return view('backEnd.chart_of_accounts.addNewCoaHeader', compact('category', 'coas'));
    }

    public function saveCoaHeader(Request $request){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
//            'coa_reference_no' => 'required | unique:erp_chart_of_accounts,coa_reference_no,'.$request->get('coa_reference_no'),
            'coa_name' => "required|string|min:1|max:150",
            'account_type' => "required",
        ]);

        $coa = new ErpChartOfAccounts();
        $coa_category = $coa->coa_header_id = $request->get('coa_category');

        $latest = ErpChartOfAccounts::select('coa_reference_no')->where('coa_header_id','=',$coa_category)->latest()->first();
        if($latest){
            $coa_last=$latest->coa_reference_no+1;
        }else{
            $coa_last= $coa_category.'01';
        }
        $coa->coa_reference_no = $coa_last;
        $coa->coa_name = $request->get('coa_name');
        $coa->account_type = $request->get('account_type');

        if($request->debit_credit_amount) {
            $debit_credit_checked = $request->debit_credit_amount;

            if ($debit_credit_checked == 'debit') {
                $coa->opening_debit = 1;
                if (($request->opening_debit_amount)) {
                    $coa->opening_debit_amount = $request->opening_debit_amount;
                }

            } else {
                $coa->opening_credit = 1;
                if ($request->opening_credit_amount != '' || $request->opening_credit_amount != NULL) {
                    $coa->opening_credit_amount = $request->opening_credit_amount;
                }
            }
        }

        $coa->save();
        return back()->with('message-success', 'New Chart of Accounts has been added successfully');
    }

    public function editCoaHeader($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpChartOfAccounts::find($id);
        $category = ErpCoaHeader::all();
        $coas = ErpChartOfAccounts::all();
        return view('backEnd.chart_of_accounts.addNewCoaHeader', compact('editData', 'category', 'coas'));
    }

    public function updateCoaHeader(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'coa_name' => "required|string|min:1|max:150",
        ]);

        $coa = ErpChartOfAccounts::find($id);
        $coa->coa_name = $request->get('coa_name');

        if($request->debit_credit_amount) {
            $debit_credit_checked = $request->debit_credit_amount;

            if ($debit_credit_checked == 'debit') {
                $coa->opening_debit = 1;
                if (($request->opening_debit_amount)) {
                    $coa->opening_debit_amount = $request->opening_debit_amount;
                }

            } else {
                $coa->opening_credit = 1;
                if ($request->opening_credit_amount) {
                    $coa->opening_credit_amount = $request->opening_credit_amount;
                }
            }
        }

        $results = $coa->update();

       if($results){
           return redirect('/add-new-coa-header')->with('message-success', 'Account Head has been updated successfully');
       }else{
           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
       }
    }

    public function createCOA(){
        $category = ErpCoaHeader::all();
        $coas = ErpChartOfAccounts::where('active_status', 1)->get();

        return view('backEnd.chart_of_accounts.createCOA', compact('category',  'coas'));
    }

    public function storeCOA(Request $request){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'coa_parent' => "required",
//            'coa_reference_no' => 'required | unique:erp_chart_of_accounts,coa_reference_no,'.$request->get('coa_reference_no'),
            'coa_name' => "required|string|min:1|max:150",
//            'account_type' => "required",
        ]);

        $coa = new ErpChartOfAccounts();
        $coa_parent = $coa->coa_parent = $request->get('coa_parent');
        $latest = ErpChartOfAccounts::select('coa_reference_no')->where('coa_parent','=',$coa_parent)->latest()->first();
        if($latest){
            $coa_last=$latest->coa_reference_no+1;
        }else{
            $coa_last= $coa_parent.'01';
            $coa_last-=1500000000;
        }
        $coa->coa_reference_no = $coa_last;
        $coa->coa_name = $request->get('coa_name');
        $coa->account_type = $request->get('account_type');

        if($request->debit_credit_amount) {
            $debit_credit_checked = $request->debit_credit_amount;

            if ($debit_credit_checked == 'debit') {
                $coa->opening_debit = 1;
                if (($request->opening_debit_amount)) {
                    $coa->opening_debit_amount = $request->opening_debit_amount;
                }

            } else {
                $coa->opening_credit = 1;
                if ($request->opening_credit_amount != '' || $request->opening_credit_amount != NULL) {
                    $coa->opening_credit_amount = $request->opening_credit_amount;
                }
            }
        }
        $results = $coa->save();

        $parent = ErpChartOfAccounts::where('coa_reference_no', '=', $request->coa_parent)->first();
        $parent->child = 1;
        $parent->update();

        if($results){
            return back()->with('message-success', 'New Chart of Accounts has been added successfully');
        }else{
            return back()->with('message-danger', 'Something went wrong, please try again');
        }
    }

    public function editCOA($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpChartOfAccounts::find($id);
        $coas = ErpChartOfAccounts::where('active_status', 1)->get();
        $coa_self = ErpChartOfAccounts::where('coa_parent', '!=', null)->where('active_status', 1)->get();

        return view('backEnd.chart_of_accounts.createCOA', compact('editData', 'coas', 'coa_self'));
    }

    public function updateCOA(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'coa_name' => "required|string|min:1|max:150",
        ]);

        $coa = ErpChartOfAccounts::find($id);
        $coa->coa_name = $request->get('coa_name');

        if($request->debit_credit_amount) {
            $debit_credit_checked = $request->debit_credit_amount;

            if ($debit_credit_checked == 'debit') {
                $coa->opening_debit = 1;
                if (($request->opening_debit_amount)) {
                    $coa->opening_debit_amount = $request->opening_debit_amount;
                }

            } else {
                $coa->opening_credit = 1;
                if ($request->opening_credit_amount != '' || $request->opening_credit_amount != NULL) {
                    $coa->opening_credit_amount = $request->opening_credit_amount;
                }
            }
        }

        $results = $coa->update();

        if($results){
            return redirect('/create-coa')->with('message-success', 'Chart of Account updated successfully');
        }else{
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }

   public function showAddAccountModal($parentId = null) {
        return view('backEnd.addAccountModal', [
            'parentId' => $parentId,
            'categories' => ErpAccountsCategory::all(),
            'projects' => ErpProject::all()
        ]);
   }
}
