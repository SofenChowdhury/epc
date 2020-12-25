@extends('backEnd.master')

@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Monthly Expense Report</h5>
        </div>

        <div class="card-block" align="center">
            @if(isset($to_date))
                {{ Form::open(['class' => '', 'files' => true, 'url' => 'monthly_expense', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <div class="row input-daterange mb-3" width="60%">
                    <div class="col-md-4 offset-md-1 pt-2">
                        <input type="text" class="form-control datepicker" name="from_date" id="from_date"  placeholder="Expense Report From Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-4 pt-2">
                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"  placeholder="Expense Report To Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-2 col-sm-6 pt-1">
                        <button type="submit" name="submit" class="btn btn-primary mr-3">Filter</button>
                    </div>
                </div>
                {{ Form::close() }}
            @else
                <div class="">
                    <div class="mb-2" style="overflow: auto;">
                        <a href="{{ url('monthly_expense_date') }}" class="btn btn-success" style="float: left; padding: 6px 50px; color: white;">Back </a>
                        <button class="btn btn-success" onclick="printDiv('report')" style="float: right; padding: 6px 50px;" target="_blank">Print</button>
                    </div>
                    <input type="text" id="from_date" value="{{ date('dMY', strtotime($from_month)) }}" hidden>
                    <input type="text" id="to_date" value="{{ date('dMY', strtotime($to_month)) }}" hidden>

                    <div class="table-responsive" id="report">

                        <div class="" id="logo" style="display:none;">
                            <div class="" style="padding-left:3%; background-color: #f2f2f2; padding-top:1%;padding-bottom:1%;">
                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                            </div>
                        </div>

                        <table class="col-md-10" align="center">
                            <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="4">{{ $setup->company_name }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: center; font-size: 18px; font-weight: bold;" colspan="4">Monthly Expense Report</th>
                            </tr>
                            <tr>
                                <th class="pb-4" style="text-align: center; font-size: 14px; font-weight: bold;" colspan="4">From {{ date('F d, Y', strtotime($from_month)) }} To {{ date('F d, Y', strtotime($to_month)) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" scope="row">    </th>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 20%; font-weight: bolder">Code</th>
                                <th scope="row" style="width: 40%; font-weight: bolder">Account Name</th>
                                <th scope="row" style="width: 20%; font-weight: bolder">Debit (Tk)</th>
                                <th scope="row" style="width: 20%; font-weight: bolder">Credit (Tk)</th>
                            </tr>
                            <tr>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $total_debit = 0; $total_credit = 0 @endphp
                            @foreach($accounts as $account)
                                <tr>
                                    <td colspan="2" style="font-weight: bold;">{{ $account->category_name }}</td>
                                </tr>
                                @foreach($account->header as $header)
                                    @foreach($header->coa as $coa)
                                        @php
                                            $debit = null;
                                            $credit = null;
                                        @endphp
                                        @if($coa->child == 1)
                                            <tr class="table-bordered" style="text-align: left">
                                                <td style="text-align: center; font-weight: bold;">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left; font-weight: bold;">{{ $coa->coa_name }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @foreach($coa->children as $child)
                                                <tr class="table-bordered" style="text-align: left">
                                                    <td style="text-align: center">{{ $child->coa_reference_no }}</td>
                                                    <td><a href="{{ url('single_account', $child->id) }}">{{ $child->coa_name }}</a></td>
                                                    @foreach($transactions as $transaction)
                                                        @foreach($transaction->transactionDetail as $detail)
                                                            @if($detail->coa_id == $child->id)
                                                                @if($detail->type == 'D')
                                                                    @php
                                                                        $debit += $detail->debit_amount;
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $credit += $detail->credit_amount;
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                    <td>
                                                        @if($child->account_type == 'debit' && $credit > 0)
                                                            @php $debit -= $credit; $credit = null @endphp
                                                        @elseif($child->account_type == 'debit' && $credit < 0)
                                                            @php $debit += $credit; $credit = null @endphp
                                                        @endif
                                                        @if($debit < 0)
                                                            ( {{ abs($debit) }} )
                                                        @else
                                                            {{ $debit }}
                                                        @endif
                                                        @php $total_debit += $debit @endphp
                                                    </td>
                                                    <td>
                                                        @if($child->account_type == 'credit' && $debit > 0)
                                                            @php $credit -= $debit; $debit = null @endphp
                                                        @elseif($child->account_type == 'credit' && $debit < 0)
                                                            @php $credit += $debit; $debit = null @endphp
                                                        @endif
                                                        @if($credit < 0)
                                                            ( {{ abs($credit) }} )
                                                        @else
                                                            {{ $credit }}
                                                        @endif
                                                        @php $total_credit += $credit @endphp
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="table-bordered" style="text-align: left">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td><a href="{{ url('single_account', $coa->id) }}">{{ $coa->coa_name }}</a></td>
                                                @foreach($transactions as $transaction)
                                                    @foreach($transaction->transactionDetail as $detail)
                                                        @if($detail->coa_id == $coa->id)
                                                            @if($detail->type == 'D')
                                                                @php
                                                                    $debit += $detail->debit_amount;
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $credit += $detail->credit_amount;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                <td>
                                                    @if($coa->account_type == 'debit' && $credit > 0)
                                                        @php $debit -= $credit; $credit = null @endphp
                                                    @elseif($coa->account_type == 'debit' && $credit < 0)
                                                        @php $debit += $credit; $credit = null @endphp
                                                    @endif
                                                    @if($debit < 0)
                                                        ( {{ abs($debit) }} )
                                                    @else
                                                        {{ $debit }}
                                                    @endif
                                                    @php $total_debit += $debit @endphp
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit' && $debit > 0)
                                                        @php $credit -= $debit; $debit = null @endphp
                                                    @elseif($coa->account_type == 'credit' && $debit < 0)
                                                        @php $credit += $debit; $debit = null @endphp
                                                    @endif
                                                    @if($credit < 0)
                                                        ( {{ abs($credit) }} )
                                                    @else
                                                        {{ $credit }}
                                                    @endif
                                                    @php $total_credit += $credit @endphp
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                            <tr style="font-weight: bold;">
                                <td></td>
                                <td class="pt-3">Total</td>
                                <td class="pt-3">
                                    @if($total_debit<0) ( {{ abs($total_debit) }} )
                                    @else {{ $total_debit }}
                                    @endif
                                </td>
                                <td class="pt-3">
                                    @if($total_credit<0) ( {{ abs($total_credit) }} )
                                    @else {{ $total_credit }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="text-bottom text-center pt-5 mt-5" style="display: none" id="footer">
                            <div class="row">
                                <div class="col">
                                    <p class=" " style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | {{ \Carbon\Carbon::now()->toDateTimeString() }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        function printDiv(report)
        {
            document.getElementById('logo').style.display = "block";
            document.getElementById('footer').style.display = "block";

            var printContents = document.getElementById(report).innerHTML;
            var from_date = document.getElementById('from_date').value;
            var to_date = document.getElementById('to_date').value;
            document.body.innerHTML = printContents;
            document.title='Monthly Expense Report '+from_date + ' - ' + to_date;
            window.print();
            window.location.href = "/epc/monthly_expense_date";
        }
    </script>
@endsection
