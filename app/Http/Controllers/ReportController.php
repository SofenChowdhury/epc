<?php

namespace App\Http\Controllers;

use App\ErpChartOfAccounts;
use App\ErpDepreciation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ErpAccountsCategory;
use App\ErpSetup;
use App\ErpTransaction;
use App\ErpTransactionDetails;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function singleAccountTransactions(Request $request,$id) {
        $form_date = '';
        $to_date = '';
        $trnDtl = ErpTransactionDetails::get();
        $coa = ErpChartOfAccounts::find($id);
        
        if($coa->child == 1){
            $children = ErpChartOfAccounts::where('coa_parent', '=', $coa->coa_reference_no)->get();
            $transactions = ErpTransactionDetails::get();
            $total_balance = 0;
        }else{
            $children = ErpChartOfAccounts::where('coa_reference_no', '=', $coa->coa_reference_no)->get();
            $transactions = ErpTransactionDetails::where('erp_transaction_details.coa_id', $id)
                ->get();
            $total_balance = $children[0]->opening_debit_amount;
        }
        $setup = ErpSetup::latest()->first();
        
        return view('backEnd.reports.single_account', compact( 'transactions', 'coa', 'children', 'setup','id','total_balance','form_date','to_date'));
    }
    public function single_account_date_range(Request $request) {
        $id = $request->id;
        $form_date  = $request->start_date;
        $prev_date = date('Y-m-d', strtotime($form_date .' -1 day'));
        $st_date    = '2000-01-01';
        $to_date    = $request->end_date;
        
        $coa = ErpChartOfAccounts::find($id);
        
        if($coa->child == 1){
            $children = ErpChartOfAccounts::where('coa_parent', '=', $coa->coa_reference_no)->get();
            $transactions = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($form_date,$to_date))
                ->get();
            $child_id = $children[0]->id;
            $debit_amount = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($st_date,$prev_date))
                ->where('coa_id',$child_id)
                ->sum('debit_amount');
            $credit_amount = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($st_date,$prev_date))
                ->where('coa_id',$child_id)
                ->sum('credit_amount');
        }else{
            $children = ErpChartOfAccounts::where('id', '=', $id)->get();
            $transactions = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($form_date,$to_date))
                ->where('erp_transaction_details.coa_id', $id)
                ->get();
            $child_id = $children[0]->id;
            $debit_amount = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($st_date,$prev_date))
                ->where('erp_transaction_details.coa_id',$child_id)
                ->sum('debit_amount');
            $credit_amount = ErpTransactionDetails::leftjoin('erp_transactions','erp_transactions.id','erp_transaction_details.transaction_id')
                ->whereBetween('transaction_date',array($st_date,$prev_date))
                ->where('coa_id',$child_id)
                ->sum('credit_amount');
        }
        $setup = ErpSetup::latest()->first();
        
    
        $total_balance = $children[0]->opening_debit_amount + $debit_amount - $credit_amount;
        return view('backEnd.reports.single_account', compact( 'transactions', 'coa', 'children', 'setup','id','total_balance','form_date','to_date'));
    }
    
    public function singleTransaction(Request $request, $id) {
    
        $transaction = ErpTransaction::find($id);
        $setup = ErpSetup::latest()->first();
        $users = User::all();

        return view('backEnd.reports.single_transaction', compact( 'transaction', 'setup', 'users'));
    }

    public function journalEntry(Request $request) {

        $month = Carbon::now()->format('F Y');

        if(request()->ajax())
        {
            if(!empty($request->from_date))
            {
                $data = DB::table('erp_transaction_details as d')
                    ->join('erp_transactions as t', 'd.transaction_id', '=', 't.id')
                    ->join('erp_chart_of_accounts as coa', 'd.coa_id', '=', 'coa.id')
                    ->whereBetween('t.transaction_date', array(date('Y-m-d', strtotime($request->from_date)), date('Y-m-d', strtotime($request->to_date))))
                    ->select('t.voucher_no', 't.transaction_date', 't.id', 'coa.coa_name', 'coa.coa_reference_no', 'd.debit_amount', 'd.credit_amount')
                    ->get();
            }
            else
            {
                $data = DB::table('erp_transaction_details as d')
                    ->join('erp_transactions as t', 'd.transaction_id', '=', 't.id')
                    ->join('erp_chart_of_accounts as coa', 'd.coa_id', '=', 'coa.id')
                    ->whereDay('t.transaction_date',Carbon::now()->day)
                    ->select('t.voucher_no', 't.transaction_date', 't.id', 'coa.coa_name', 'coa.coa_reference_no', 'd.debit_amount', 'd.credit_amount')
                    ->get();
            }
            return datatables()->of($data)->make(true);
        }

        return view('backEnd.reports.journal_entry',[
            'month' => $month,
        ]);
    }

    public function generalLedger() {

        $transactions = ErpTransactionDetails::whereMonth('created_at',Carbon::now()->month)->get();
        $totalDebit = $transactions->sum('debit_amount');
        $totalCredit = $transactions->sum('credit_amount');

        return view('backEnd.reports.trial_balance',[
            'transactions' => $transactions,
            'total_debit_amount' => $totalDebit,
            'total_credit_amount' => $totalCredit
        ]);
    }

    public function monthlyExpenseDate(){
        $to_date = 0;
        return view('backEnd.reports.monthly_expense', compact( 'to_date'));
    }

    public function generateMonthlyExpense(Request $request) {

        $from_month = date('Y-m-d', strtotime($request->from_date));
        $to_month = date('Y-m-d', strtotime($request->to_date));

        $accounts = ErpAccountsCategory::all();
        $transactions = ErpTransaction::where('transaction_date', '>=', $from_month)->where('transaction_date', '<=', $to_month)->get();
        $setup = ErpSetup::latest()->first();

        return view('backEnd.reports.monthly_expense', compact( 'accounts','transactions', 'from_month', 'to_month', 'setup'));
    }

    public function trialBalanceDate(){
        $to_date = 0;
        return view('backEnd.reports.trial_balance', compact( 'to_date'));
    }

    public function generateTrialBalance(Request $request) {

        $to_date = date('Y-m-d', strtotime($request->to_date));

        $accounts = ErpAccountsCategory::all();
        $transactions = ErpTransaction::where('transaction_date', '<=', $to_date)->get();
        $month = date('F d, Y', strtotime($request->to_date));
        $setup = ErpSetup::latest()->first();

        return view('backEnd.reports.trial_balance', compact( 'accounts','transactions', 'month', 'setup'));
    }

    public function incomeStatementsDate(){
        $to_date = 0;
        return view('backEnd.reports.profit_loss', compact( 'to_date'));
    }

    public function generateIncomeStatement(Request $request) {

        $from_month = date('Y-m-d', strtotime($request->from_date));
        $to_month = date('Y-m-d', strtotime($request->to_date));

        $accounts = ErpAccountsCategory::where('category_reference_no', '=', 1505)->orWhere('category_reference_no', '=', 1506)->get();
        $transactions = ErpTransaction::where('transaction_date', '>=', $from_month)->where('transaction_date', '<=', $to_month)->get();
        $setup = ErpSetup::latest()->first();

        return view('backEnd.reports.profit_loss', compact( 'accounts','transactions', 'from_month', 'to_month', 'setup'));
    }

    public function balanceSheetDate(){
        $to_date = 0;
        return view('backEnd.reports.balance_sheet', compact( 'to_date'));
    }

    public function generateBalanceSheet(Request $request) {
        $month = date('F d, Y', strtotime($request->to_date));

        $accounts = ErpAccountsCategory::all();
        $profit_loss = ErpAccountsCategory::where('category_reference_no', '=', 1505)->orWhere('category_reference_no', '=', 1506)->get();
        $transactions = ErpTransaction::where('transaction_date', '>=', $month)->get();
        $setup = ErpSetup::latest()->first();

        ErpDepreciation::depreciation_calculate();
        $assets = ErpDepreciation::all();

        $total_dep = $assets->sum('current_year_dep');

        return view('backEnd.reports.balance_sheet', compact('accounts', 'profit_loss','transactions','month', 'setup', 'total_dep'));
    }
}
