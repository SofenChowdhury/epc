<?php

namespace App\Services;

use App\ErpTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AddTransactionsService {

    public function createTransactions($request) {
        
            $totalTransactions = $request->totalRow;

            $erpTransaction = ErpTransaction::create([

            'transaction_date' => Carbon::createFromFormat('d-m-Y',$request->transaction_date)->format('Y-m-d'),

            'voucher_no' => $request->voucher_no,

            'total_transaction' => $request->total_debit,

            'project' => $request->project,

            'description' => $request->description,

            'created_by' => Auth::id()

        ]);


        $record = 0;
        $i = 0;

        while (true) {

            $dataForDetail = [];

            if($request["debit$i"] || $request["credit$i"]) {

                $dataForDetail['coa_parent'] = $request["coa_parent$i"];

                $dataForDetail['debit_amount'] = $request["debit$i"];

                $dataForDetail['credit_amount'] = $request["credit$i"];

                if($dataForDetail['credit_amount'] > 0) {

                    $dataForDetail['type'] = 'C';

                } else {

                    $dataForDetail['type'] = 'D';

                }

                $erpTransaction->addTransactionDetail($dataForDetail);

                if($record == $totalTransactions) break;

                $record++;
            }

            $i++;

        }
        
        return $erpTransaction;

    }

}