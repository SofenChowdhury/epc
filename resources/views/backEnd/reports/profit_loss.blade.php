@extends('backEnd.master')

@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Income Statement</h5>
        </div>

        <div class="card-block" align="center">
            @if(isset($to_date))
                {{ Form::open(['class' => '', 'files' => true, 'url' => 'income_statement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <div class="row input-daterange mb-3" width="60%">
                    <div class="col-md-4 offset-md-1 pt-2">
                        <input type="text" class="form-control datepicker" name="from_date" id="from_date"  placeholder="Income Statement From Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-4 pt-2">
                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"  placeholder="Income Statement To Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-2 col-sm-6 pt-1">
                        <button type="submit" name="submit" class="btn btn-primary mr-3">Filter</button>
                    </div>
                </div>
                {{ Form::close() }}
            @else
                <div class="">
                    <div class="mb-2" style="overflow: auto;">
                        <a href="{{ url('income_statement_date') }}" class="btn btn-success" style="float: left; padding: 6px 50px; color: white;">Back </a>
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

                        <table class="col-md-6" align="center">
                            <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="4">{{ $setup->company_name }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: center; font-size: 18px; font-weight: bold;" colspan="4">Income Statement</th>
                            </tr>
                            <tr>
                                <th class="pb-4" style="text-align: center; font-size: 14px; font-weight: bold;" colspan="4">For the Period from {{ date('F d, Y', strtotime($from_month)) }} To {{ date('F d, Y', strtotime($to_month)) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" scope="row">    </th>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <th scope="row" style="font-weight: bolder; text-align: right">{{ date('d-m-Y', strtotime($to_month)) }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php $total_debit = $total_credit = null @endphp
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
                                            <tr class="table-bordered" style="text-align: left; font-weight: bold;">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left">{{ $coa->coa_name }}</td>
                                                <td style="text-align: right; font-weight: bold;">TK</td>
                                            </tr>
                                            @foreach($coa->children as $child)
                                                <tr class="table-bordered" style="text-align: left;">
                                                    <td style="text-align: center;">{{ $child->coa_reference_no }}</td>
                                                    <td style="text-align: left;"><a href="{{ url('single_account', $child->id) }}">{{ $child->coa_name }}</a></td>
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
                                                    <td style="text-align: right; font-weight: bold;">
                                                        @if($child->account_type == 'debit')
                                                            @if($credit > 0)
                                                                @php $debit -= $credit; $credit = null; @endphp
                                                            @endif
                                                            @php $total_debit += $debit @endphp

                                                            @if($debit < 0)
                                                                ( {{ abs($debit) }} )
                                                            @else
                                                                {{ $debit }}
                                                            @endif

                                                        @elseif($child->account_type == 'credit')
                                                            @if($debit > 0)
                                                                @php $credit -= $debit; $debit = null; @endphp
                                                            @endif
                                                            @php $total_credit += $credit @endphp

                                                            @if($credit < 0)
                                                                ( {{ abs($credit) }} )
                                                            @else
                                                                {{ $credit }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="table-bordered" style="text-align: left;">
                                                <td style="text-align: center;">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left;"><a href="{{ url('single_account', $coa->id) }}">{{ $coa->coa_name }}</a></td>
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
                                                <td style="text-align: right; font-weight: bold;">
                                                    @if($coa->account_type == 'debit')
                                                        @if($credit > 0)
                                                            @php $debit -= $credit; $credit = null; @endphp
                                                        @endif
                                                        @php $total_debit += $debit @endphp

                                                        @if($debit < 0)
                                                            ( {{ abs($debit) }} )
                                                        @else
                                                            {{ $debit }}
                                                        @endif

                                                    @elseif($coa->account_type == 'credit')
                                                        @if($debit > 0)
                                                            @php $credit -= $debit; $debit = null; @endphp
                                                        @endif
                                                        @php $total_credit += $credit @endphp

                                                        @if($credit < 0)
                                                            ( {{ abs($credit) }} )
                                                        @else
                                                            {{ $credit }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                <tr>
                                    @if($account->category_reference_no == 1505)
                                        <th colspan="2" class="pt-2 pb-3" style="font-weight: bold;">Total - Income</th>
                                        <th class="pt-2 pb-3" style="font-weight: bold; text-align: right">
                                            @if($total_credit < 0)
                                                ( {{ abs($total_credit) }} )
                                            @else
                                                {{ $total_credit }}
                                            @endif
                                        </th>
                                    @elseif($account->category_reference_no == 1506)
                                        <th colspan="2" class="pt-2 pb-3" style="font-weight: bold;">Total - Expenses</th>
                                        <th class="pt-2 pb-3" style="font-weight: bold; text-align: right">
                                            @if($total_debit < 0)
                                                ( {{ abs($total_debit) }} )
                                            @else
                                                {{ $total_debit }}
                                            @endif
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                            @php $total = $total_credit - $total_debit @endphp
                            <tr class="" style="font-weight: bold;">
                                <td colspan="2" class="pt-3">
                                    @if($total<0) Net Profit ( Loss )
                                    @else Net Profit ( Profit )
                                    @endif
                                </td>
                                <td class="pt-3" align="right">
                                    @if($total<0) ({{ abs($total) }})
                                    @else {{ $total }}
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
            document.title='Profit Loss Statement '+from_date + ' - ' + to_date;
            window.print();
            window.location.href = "/epc/income_statement_date";
        }
    </script>
@endsection
