@extends('backEnd.master')

@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Balance Sheet</h5>
        </div>

        <div class="card-block" align="center">
            @if(isset($to_date))
                {{ Form::open(['class' => '', 'files' => true, 'url' => 'balance_sheet', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <div class="row input-daterange mb-3" width="60%">
                    <div class="col-md-6 offset-md-2">
                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"  placeholder="Balance Sheet As At" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-2 col-sm-6 pt-1">
                        <button type="submit" name="submit" class="btn btn-primary mr-3">Filter</button>
                    </div>
                </div>
                {{ Form::close() }}
            @else
                <div class="">
                    <div class="mb-2" style="overflow: auto;">
                        <a href="{{ url('balance_sheet_date') }}" class="btn btn-success" style="float: left; padding: 6px 50px; color: white;">Back </a>
                        <button class="btn btn-success" onclick="printDiv('report')" style="float: right; padding: 6px 50px;" target="_blank">Print</button>
                    </div>
                    <input type="text" id="to_date" value="{{ date('dMY', strtotime($month)) }}" hidden>
                    <div class="table-responsive" id="report">
                        <div class="" id="logo" style="display:none;">
                            <div class="" style="padding-left:3%; background-color: #f2f2f2; padding-top:1%;padding-bottom:1%;">
                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                            </div>
                        </div>
                        <table class="col-md-8" align="center">
                            <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="4">{{ $setup->company_name }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: center; font-size: 18px; font-weight: bold;" colspan="4">Balance Sheet</th>
                            </tr>
                            <tr>
                                <th class="pb-4" style="text-align: center; font-size: 14px; font-weight: bold;" colspan="4">As At {{ date('F d, Y', strtotime($month)) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" scope="row">    </th>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 20%; font-weight: bolder">Code</th>
                                <th scope="row" style="width: 40%; font-weight: bolder">Account Name</th>
                                <th scope="row" style="width: 20%; font-weight: bolder">Year : {{ date('Y', strtotime($month)) }}</th>
                                <th scope="row" style="width: 20%; font-weight: bolder">Year : {{ date('Y', strtotime("-1 year")) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            {{--                        ASSETS--}}
                            @php $total_asset = 0; $previous_asset = 0 @endphp
                            @foreach($accounts as $account)
                                @if($account->category_reference_no == 1502)
                                    <tr>
                                        <td colspan="2" style="font-weight: bold;">{{ $account->category_name }}</td>
                                    </tr>
                                    @foreach($account->header as $header)
                                        <tr>
                                            <td colspan="2" style="font-weight: bold;">{{ $header->header_name }}</td>
                                        </tr>
                                        @foreach($header->coa as $coa)
                                            @php
                                                $debit = null;
                                                $credit = null;
                                                $opening_debit = $coa->opening_debit_amount;
                                                $opening_credit = $coa->opening_credit_amount;
                                            @endphp
                                            <tr class="table-bordered" style="text-align: right">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left"><a href="{{ url('single_account', $coa->id) }}">{{ $coa->coa_name }}</a></td>
                                                {{--                                            // FOR COA WITH CHILD ACCOUNTS (LEVEL 4)--}}
                                                @if($coa->child == 1)
                                                    @foreach($coa->children as $child)
                                                        @php
                                                            $opening_debit += $child->opening_debit_amount;
                                                            $opening_credit += $child->opening_credit_amount;
                                                        @endphp
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
                                                    @endforeach
                                                    <td>
                                                        @if($credit > 0)
                                                            @php $debit -= $credit; $credit = null @endphp
                                                        @elseif($credit < 0)
                                                            @php $debit += $credit; $credit = null @endphp
                                                        @endif
                                                        @if($debit < 0)
                                                            ( {{ abs($debit) }} )
                                                        @else
                                                            {{ $debit }}
                                                        @endif
                                                        @php $total_asset += $debit @endphp
                                                    </td>
                                                    <td>
                                                        @php $previous = $opening_debit - $opening_credit @endphp
                                                        @if($previous<0) ( {{ abs($previous) }} )
                                                        @elseif($previous == 0) {{ null }}
                                                        @else {{ $previous }}
                                                        @endif
                                                        @php $previous_asset += $previous @endphp
                                                    </td>
                                                    {{-- // FOR COA WITHOUT CHILD ACCOUNTS (LEVEL 3)--}}
                                                @else
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
                                                        @if($credit > 0)
                                                            @php $debit -= $credit; $credit = null @endphp
                                                        @elseif($credit < 0)
                                                            @php $debit += $credit; $credit = null @endphp
                                                        @endif
                                                        @if($debit < 0)
                                                            ( {{ abs($debit) }} )
                                                        @else
                                                            {{ $debit }}
                                                        @endif
                                                        @php $total_asset += $debit @endphp
                                                    </td>
                                                    <td>
                                                        @php $previous = $opening_debit - $opening_credit @endphp
                                                        @if($previous<0) ( {{ abs($previous) }} )
                                                        @elseif($previous == 0) {{ null }}
                                                        @else {{ $previous }}
                                                        @endif
                                                        @php $previous_asset += $previous @endphp
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="2" style="font-weight: bold;">Accumulated Depreciation, Fixed Assets</td>
                                <td>{{ $total_dep }}</td>
                            </tr>
                            <tr class="" style="font-weight: bold;">
                                <td colspan="2" class="pt-3" style="color: darkred">Total Assets</td>
                                <td class="pt-3" style="color: darkred">
                                    @php $all_total_asset = $total_asset + $total_dep @endphp
                                    @if($all_total_asset<0)
                                        ( {{ number_format(abs($all_total_asset),2,".",",") }} )
                                    @else
                                        {{ number_format($all_total_asset,2,".",",") }}
                                    @endif
                                </td>
                                <td class="pt-3" style="color: darkred">
                                    @if($previous_asset<0)
                                        ( {{ number_format(abs($previous_asset),2,".",",") }} )
                                    @else
                                        {{ number_format($previous_asset,2,".",",") }}
                                    @endif
                                </td>
                            </tr>
                            {{--  ASSETS ENDS--}}
                            <tr><td>.</td></tr>

                            <tr><td>.</td></tr>
                            {{-- LIABILITIES--}}
                            <tr>
                                <td colspan="2" style="font-weight: bold;">Equity and Liabilities</td>
                            </tr>
                            @php $total_liability = 0; $previous_liability = 0 @endphp
                            @foreach($accounts as $account)
                                @if($account->category_reference_no == 1503)
                                    <tr>
                                        <td colspan="2" style="font-weight: bold;">{{ $account->category_name }}</td>
                                    </tr>
                                    @foreach($account->header as $header)
                                        <tr>
                                            <td colspan="2" style="font-weight: bold;">{{ $header->header_name }}</td>
                                        </tr>
                                        @foreach($header->coa as $coa)
                                            @php
                                                $debit = null;
                                                $credit = null;
                                                $opening_debit = $coa->opening_debit_amount;
                                                $opening_credit = $coa->opening_credit_amount;
                                            @endphp
                                            <tr class="table-bordered" style="text-align: right">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left"><a href="{{ url('single_account', $coa->id) }}">{{ $coa->coa_name }}</a></td>
                                                {{-- // FOR COA WITH CHILD ACCOUNTS (LEVEL 4)--}}
                                                @if($coa->child == 1)
                                                    @foreach($coa->children as $child)
                                                        @php
                                                            $opening_debit += $child->opening_debit_amount;
                                                            $opening_credit += $child->opening_credit_amount;
                                                        @endphp
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
                                                    @endforeach
                                                    <td>
                                                        @if($debit > 0)
                                                            @php $credit -= $debit; $debit = null @endphp
                                                        @elseif($debit < 0)
                                                            @php $credit += $debit; $debit = null @endphp
                                                        @endif
                                                        @if($credit < 0)
                                                            ( {{ abs($credit) }} )
                                                        @else
                                                            {{ $credit }}
                                                        @endif
                                                        @php $total_liability += $credit @endphp
                                                    </td>
                                                    <td>
                                                        @php $previous = $opening_credit- $opening_debit @endphp
                                                        @if($previous<0) ( {{ abs($previous) }} )
                                                        @elseif($previous == 0) {{ null }}
                                                        @else {{ $previous }}
                                                        @endif
                                                        @php $previous_liability += $previous @endphp
                                                    </td>
                                                    {{--// FOR COA WITHOUT CHILD ACCOUNTS (LEVEL 3)--}}
                                                @else
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
                                                        @if($debit > 0)
                                                            @php $credit -= $debit; $debit = null @endphp
                                                        @elseif($debit < 0)
                                                            @php $credit += $debit; $debit = null @endphp
                                                        @endif
                                                        @if($credit < 0)
                                                            ( {{ abs($credit) }} )
                                                        @else
                                                            {{ $credit }}
                                                        @endif
                                                        @php $total_liability += $credit @endphp
                                                    </td>
                                                    <td>
                                                        @php $previous = $opening_credit- $opening_debit @endphp
                                                        @if($previous<0) ( {{ abs($previous) }} )
                                                        @elseif($previous == 0) {{ null }}
                                                        @else {{ $previous }}
                                                        @endif
                                                        @php $previous_liability += $previous @endphp
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                            <tr class="" style="font-weight: bold;">
                                <td colspan="2" class="pt-3">Total Liabilities</td>
                                <td class="pt-3">
                                    @if($total_liability<0)
                                        ( {{ number_format(abs($total_liability),2,".",",") }} )
                                    @else
                                        {{ number_format($total_liability,2,".",",") }}
                                    @endif
                                </td>
                                <td class="pt-3">
                                    @if($previous_liability<0)
                                        ( {{ number_format(abs($previous_liability),2,".",",") }} )
                                    @else
                                        {{ number_format($previous_liability,2,".",",") }}
                                    @endif
                                </td>
                            </tr>
                            {{-- LIABILITY ENDS--}}

                            <tr><td>.</td></tr>

                            {{-- EQUITY--}}
{{--                            PROFIT AND LOSS--}}
                            @php $opening_profit_debit = $opening_profit_credit = null; $total_debit = $total_credit = null @endphp
                            @foreach($profit_loss as $account)
                                @foreach($account->header as $header)
                                    @foreach($header->coa as $coa)
                                        @php
                                            $debit = null;
                                            $credit = null;
                                            $opening_debit = $coa->opening_debit_amount;
                                            $opening_credit = $coa->opening_credit_amount;
                                        @endphp
                                        @if($coa->account_type == 'debit')
                                            @if($opening_credit > 0)
                                                @php $opening_profit_debit -= $opening_credit; @endphp
                                            @else
                                                @php $opening_profit_debit += $opening_debit; @endphp
                                            @endif
                                        @endif
                                        @if($coa->account_type == 'credit')
                                            @if($opening_debit > 0)
                                                @php $opening_profit_credit -= $opening_debit; @endphp
                                            @else
                                                @php $opening_profit_credit += $opening_credit; @endphp
                                            @endif
                                        @endif
                                        @if($coa->child == 1)
                                            @foreach($coa->children as $child)
                                                @php
                                                    $opening_debit_child = $child->opening_debit_amount;
                                                    $opening_credit_child = $child->opening_credit_amount;
                                                @endphp
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
                                                @if($child->account_type == 'debit')
                                                    @if($opening_credit_child > 0)
                                                        @php $opening_profit_debit -= $opening_credit_child; @endphp
                                                    @else
                                                        @php $opening_profit_debit += $opening_debit_child; @endphp
                                                    @endif
                                                @endif
                                                @if($child->account_type == 'credit')
                                                    @if($opening_debit_child > 0)
                                                        @php $opening_profit_credit -= $opening_debit_child; @endphp
                                                    @else
                                                        @php $opening_profit_credit += $opening_credit_child; @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
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
                                        @endif
                                        @if($coa->account_type == 'debit')
                                            @if($credit > 0)
                                                @php $debit -= $credit; $credit = null; @endphp
                                            @endif
                                            @php $total_debit += $debit @endphp
                                        @elseif($coa->account_type == 'credit')
                                            @if($debit > 0)
                                                @php $credit -= $debit; $debit = null; @endphp
                                            @endif
                                            @php $total_credit += $credit @endphp
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                            @php $total_profit_loss = $total_credit - $total_debit + $total_dep @endphp
                           {{-- PROFIT LOSS ENDS--}}

                            @php $total_equity = 0; $previous_equity = 0 @endphp
                            @foreach($accounts as $account)
                                @if($account->category_reference_no == 1501)
                                    <tr>
                                        <td colspan="2" style="font-weight: bold;">{{ $account->category_name }}</td>
                                    </tr>
                                    @foreach($account->header as $header)
                                        @if($header->header_reference_no != 150103)
                                            <tr>
                                                <td colspan="2" style="font-weight: bold;">{{ $header->header_name }}</td>
                                            </tr>
                                            @foreach($header->coa as $coa)
                                                @php
                                                    $debit = null;
                                                    $credit = null;
                                                    $opening_debit = $coa->opening_debit_amount;
                                                    $opening_credit = $coa->opening_credit_amount;
                                                @endphp
                                                <tr class="table-bordered" style="text-align: right">
                                                    <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                    <td style="text-align: left"><a href="{{ url('single_account', $coa->id) }}">{{ $coa->coa_name }}</a></td>
  {{--                                            // FOR COA WITH CHILD ACCOUNTS (LEVEL 4)--}}
                                                    @if($coa->child == 1)
                                                        @foreach($coa->children as $child)
                                                            @php
                                                                $opening_debit += $child->opening_debit_amount;
                                                                $opening_credit += $child->opening_credit_amount;
                                                            @endphp
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
                                                        @endforeach
                                                        <td>
                                                            @if($debit > 0)
                                                                @php $credit -= $debit; $debit = null @endphp
                                                            @elseif($debit < 0)
                                                                @php $credit += $debit; $debit = null @endphp
                                                            @endif

                                                            @if($credit < 0)
                                                                ( {{ abs($credit) }} )
                                                            @else
                                                                {{ $credit }}
                                                            @endif
                                                            @php $total_equity += $credit @endphp
                                                        </td>
                                                        <td>
                                                            @php $previous = $opening_credit- $opening_debit @endphp
                                                            @if($previous<0) ( {{ abs($previous) }} )
                                                            @elseif($previous == 0) {{ null }}
                                                            @else {{ $previous }}
                                                            @endif
                                                            @php $previous_equity += $previous @endphp
                                                        </td>
                                                        {{-- // FOR COA WITHOUT CHILD ACCOUNTS (LEVEL 3)--}}
                                                    @else
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
                                                        @if($coa->coa_reference_no == '15010201')
                                                            @php $credit += $total_profit_loss;  @endphp
                                                            @php $previous = ($opening_credit- $opening_debit) + ($opening_profit_credit - $opening_profit_debit) @endphp
                                                        @else
                                                            @php $previous = ($opening_credit- $opening_debit) @endphp
                                                        @endif
                                                        <td>
                                                            @if($debit > 0)
                                                                @php $credit -= $debit; $debit = null @endphp
                                                            @elseif($debit < 0)
                                                                @php $credit += $debit; $debit = null @endphp
                                                            @endif
                                                            @if($credit < 0)
                                                                ( {{ abs($credit) }} )
                                                            @else
                                                                {{ $credit }}
                                                            @endif
                                                            @php $total_equity += $credit @endphp
                                                        </td>
                                                        <td>
                                                            @if($previous<0) ( {{ abs($previous) }} )
                                                            @elseif($previous == 0) {{ null }}
                                                            @else {{ $previous }}
                                                            @endif
                                                            @php $previous_equity += $previous @endphp
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <tr class="" style="font-weight: bold;">
{{--                                <td style="text-align: center"></td>--}}
{{--                                <td colspan="2" class="pt-3"><a href="#">Suspense</a> </td>--}}
                                <td colspan="2" class="pt-3">Suspense</td>
                                <td class="pt-3">
                                    @if( abs($total_liability + $total_equity) > abs($all_total_asset))
                                        @php $suspense = ($total_liability) + ($total_equity) - ($all_total_asset) @endphp
                                        @php $total_equity -= $suspense @endphp
                                    @else
                                        @php $suspense = $all_total_asset - ($total_liability) - ($total_equity) @endphp
                                        @php $total_equity += $suspense @endphp
                                    @endif
                                    {{ abs($suspense) }}
                                </td>
                                <td class="pt-3">
                                    @php $old_suspense = $previous_asset - $previous_liability - $previous_equity @endphp
                                    {{ abs($old_suspense) }}
                                </td>
                            </tr>
                            <tr class="" style="font-weight: bold;">
                                <td colspan="2" class="pt-3">Total Equity</td>
                                <td class="pt-3">
                                    @if($total_equity<0)
                                        ( {{ number_format(abs($total_equity),2,".",",") }} )
                                    @else
                                        {{ number_format($total_equity,2,".",",") }}
                                    @endif
                                </td>
                                <td class="pt-3">
                                    @php $total_previous_equity = $previous_equity + $old_suspense @endphp
                                    @if($total_previous_equity<0)
                                        ( {{ number_format(abs($total_previous_equity),2,".",",") }} )
                                    @else
                                        {{ number_format($total_previous_equity,2,".",",") }}
                                    @endif
                                </td>
                            </tr>
                            {{--                            EQUITY ENDS--}}

                            {{--                                TOTAL EQUITY AND LIABILITIES--}}
                            <tr class="" style="font-weight: bold;">
                                <td colspan="2" class="pt-3" style="color: darkred">Total Liabilities and Equity</td>
                                <td class="pt-3" style="color: darkred">
                                    @php $all_equity_liability = $total_equity + $total_liability @endphp
                                    @if($all_equity_liability<0)
                                        ( {{ number_format(abs($all_equity_liability),2,".",",") }} )
                                    @else
                                        {{ number_format($all_equity_liability,2,".",",") }}
                                    @endif
                                </td>
                                <td class="pt-3" style="color: darkred">
                                    @php $previous_equity_liability = $previous_liability + $previous_equity + $old_suspense @endphp
                                    @if($previous_equity_liability<0)
                                        ( {{ number_format(abs($previous_equity_liability),2,".",",") }} )
                                    @else
                                        {{ number_format($previous_equity_liability,2,".",",") }}
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
            var to_date = document.getElementById('to_date').value;
            document.body.innerHTML = printContents;
            document.title='Balance Sheet ' + ' - ' + to_date;
            window.print();
            window.location.href = "/epc/balance_sheet_date";
        }
    </script>
@endsection
