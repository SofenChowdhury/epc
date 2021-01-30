<?php

namespace App\Http\Controllers;

use App\ErpTransaction;
use App\ErpTransactionDetails;
use App\ErpChartOfAccounts;
use App\ErpProject;
use App\ErpProjectPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Notification;
use App\Notifications\TransactionApproval;
use App\User;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    public function index()
    {
        return view('backEnd.addTransactions');
    }

    public function addTransactions(Request $request) {
//        return $request;
        $transaction=new ErpTransaction;
        $transaction->transaction_date=$request->form['date'];
        $transaction->description=$request->form['description'];
        $transaction->voucher_no=$request->form['voucher'];
        $transaction->total_transaction=$request->form['allDebit'];
        $transaction->active_status=1;
        $transaction->created_by=$request->form['auth_id'];
        $transaction->save();
        
        $transaction_id=$transaction->id;
        $transaction_details=new ErpTransactionDetails;
        $transaction_details->transaction_id=$transaction_id;
        $transaction_details->coa_id=$request->form['type1'];
        $transaction_details->debit_amount=$request->form['debit1'];
        $transaction_details->credit_amount=$request->form['credit1'];
        $transaction_details->active_status=1;
        if ($request->form['debit1']!=0){
            $transaction_details->type='D';
        }
        else{
            $transaction_details->type='C';
        }

        $transaction_details->save();

        $coa1 = ErpChartOfAccounts::find($request->form['type1']);
        if($coa1->project_id){
            $project1 = ErpProject::find($coa1->project_id);

            $payment = new ErpProjectPayment;
            $payment->project_id = $project1->id;
            $payment->project_phase = $project1->project_phase;
            $payment->coa_id = $coa1->id;
            $payment->transaction_id = $transaction_id;
            $payment->transaction_detail_id = $transaction_details->id;
            $payment->type = $transaction_details->type;
            $payment->created_by=$request->form['auth_id'];
            $payment->save();
        }

        $transaction_details1=new ErpTransactionDetails;
        $transaction_details1->transaction_id=$transaction_id;
        $transaction_details1->coa_id=$request->form['type2'];
        $transaction_details1->debit_amount=$request->form['debit2'];
        $transaction_details1->credit_amount=$request->form['credit2'];
        $transaction_details1->active_status=1;
        if ($request->form['debit2']!=0){
            $transaction_details1->type='D';
        }
        else{
            $transaction_details1->type='C';
        }

        $transaction_details1->save();

        $coa2 = ErpChartOfAccounts::find($request->form['type2']);
        if($coa2->project_id){
            $project2 = ErpProject::find($coa2->project_id);

            $payment = new ErpProjectPayment;
            $payment->project_id = $project2->id;
            $payment->project_phase = $project2->project_phase;
            $payment->coa_id = $coa2->id;
            $payment->transaction_id = $transaction_id;
            $payment->transaction_detail_id = $transaction_details1->id;
            $payment->type = $transaction_details1->type;
            $payment->created_by=$request->form['auth_id'];
            $payment->save();
        }

        foreach ($request->fields as $field) {

            $transaction_details2 = new ErpTransactionDetails;
            $transaction_details2->transaction_id = $transaction_id;
            $transaction_details2->coa_id = $field['type'];
            $transaction_details2->debit_amount = $field['debit'];
            $transaction_details2->credit_amount = $field['credit'];
            $transaction_details2->active_status = 1;
            if ($field['debit'] != 0) {
                $transaction_details2->type = 'D';
            } else {
                $transaction_details2->type = 'C';
            }

            $transaction_details2->save();

            $coa = ErpChartOfAccounts::find($field['type']);
            if ($coa->project_id) {
                $project = ErpProject::find($coa->project_id);

                $payment = new ErpProjectPayment;
                $payment->project_id = $project->id;
                $payment->project_phase = $project->project_phase;
                $payment->coa_id = $coa->id;
                $payment->transaction_id = $transaction_id;
                $payment->transaction_detail_id = $transaction_details2->id;
                $payment->type = $transaction_details2->type;
                $payment->created_by = $request->form['auth_id'];
                $payment->save();
            }
        }

        if($transaction->total_transaction > 100000){
            $user = User::find(19);
            if ($user)
                $user->notify(new TransactionApproval($transaction));
        }else{
            $user = User::find(21);
            if ($user)
                $user->notify(new TransactionApproval($transaction));
        }
        return ['redirect' => url('/single_transaction/'.$transaction_id)];
    }
}
