@extends('backEnd.master')

@section('mainContent')
    @php
        $sub_total_debit = 0;
        $sub_total_credit = 0;
    @endphp
    <div class="card">
        <div class="card-header">
            <h5>Trial Balance</h5>
        </div>

        <div class="card-block" align="center">
            @if(isset($to_date))
                {{ Form::open(['class' => '', 'files' => true, 'url' => 'trial_balance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                <div class="row input-daterange mb-3" width="60%">
                    <div class="col-md-6 offset-md-2">
                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"  placeholder="Trial Balance To Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-primary mr-3">Filter</button>
                    </div>
                </div>
                {{ Form::close() }}
            @else
                <div class="">
                    <div class="mb-2" style="overflow: auto;">
                        <a href="{{ url('trial_balance_date') }}" class="btn btn-success" style="float: left; padding: 6px 50px; color: white;">Back </a>
                        <button class="btn btn-success" onclick="printDiv('report')" style="float: right; padding: 6px 50px;" target="_blank">Print</button>
                    </div>
                    <input type="text" id="to_date" value="{{ date('d-M-Y', strtotime($month)) }}" hidden>
                    <div class="table-responsive" id="report">
                        <div class="" id="logo" style="display:none;">
                            <div class="" style="padding-left:3%; background-color: #f2f2f2; padding-top:1%;padding-bottom:1%;">
                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                            </div>
                        </div>
                        <table class="col-md-10" align="center">
                            <thead>
                            <tr>
                                <th style="text-align: center; font-size: 16px; font-weight: bold;" colspan="8">{{ $setup->company_name }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: center; font-size: 18px; font-weight: bold;" colspan="8">Trial Balance</th>
                            </tr>
                            <tr>
                                <th class="pb-4" style="text-align: center; font-size: 14px; font-weight: bold;" colspan="8">As of {{ $month }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" scope="row">    </th>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 10%; font-weight: bolder">Code</th>
                                <th scope="row" style="width: 30%; font-weight: bolder">Account Name</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Opening Debit</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Opening Credit</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Debit</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Credit</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Ending Debit</th>
                                <th scope="row" style="width: 10%; font-weight: bolder; text-align: center">Ending Credit</th>
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
                                            $opening_debit = $ending_debit = $coa->opening_debit_amount;
                                            $opening_credit = $ending_credit = $coa->opening_credit_amount;
                                        @endphp
                                        @if($coa->child == 1)
                                            <tr class="table-bordered" style="text-align: right; font-weight: bold;">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left">{{ $coa->coa_name }}</td>
                                                <td>
                                                    @if($coa->account_type == 'debit')
                                                        @if($opening_debit<0) ( {{ abs($opening_debit) }} )
                                                        @else {{ $opening_debit }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit')
                                                        @if($opening_credit<0) ( {{ abs($opening_credit) }} )
                                                        @else {{ $opening_credit }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    @if($coa->account_type == 'debit')
                                                        @if($ending_debit<0) ( {{ abs($ending_debit) }} )
                                                        @else {{ $ending_debit }}
                                                        @endif
                                                    @endif
                                                    @php $total_debit += $ending_debit @endphp
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit')
                                                        @if($ending_credit<0) ( {{ abs($ending_credit) }} )
                                                        @else {{ $ending_credit }}
                                                        @endif
                                                    @endif
                                                    @php $total_credit += $ending_credit @endphp
                                                </td>
                                            </tr>
                                            @foreach($coa->children as $child)
                                                <tr class="table-bordered" style="text-align: right">
                                                    <td style="text-align: center">{{ $child->coa_reference_no }}</td>
                                                    <td style="text-align: left">
                                                        <a href="{{route('single_account',['id'=>$coa->id] )}}">{{ $child->coa_name }}</a>
                                                    </td>
                                                    @php
                                                        $debit = null;
                                                        $credit = null;
                                                        $opening_debit = $ending_debit = $child->opening_debit_amount;
                                                        $opening_credit = $ending_credit = $child->opening_credit_amount;
                                                    @endphp
                                                    <td>

                                                        @if($child->account_type == 'debit' && $opening_credit > 0)
                                                            @php $opening_debit -= $opening_credit; $ending_debit = $opening_debit; $ending_credit = $opening_credit = null; @endphp
                                                        @endif
                                                        @if($coa->account_type == 'debit')
                                                            @if($opening_debit < 0)
                                                                ( {{ abs($opening_debit) }} )
                                                            @else
                                                                {{ $opening_debit }}
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($child->account_type == 'credit' && $opening_debit > 0)
                                                            @php $opening_credit -= $opening_debit; $ending_credit = $opening_credit; $ending_debit = $opening_debit = null; @endphp
                                                        @endif
                                                        @if($coa->account_type == 'credit')
                                                            @if($opening_credit < 0)
                                                                ( {{ abs($opening_credit) }} )
                                                            @else
                                                                {{ $opening_credit }}
                                                            @endif
                                                        @endif
                                                    </td>
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
                                                        {{--  Dabit--}}
                                                        @if($child->account_type == 'debit' && $credit > 0)
                                                            @php
                                                                $debit -= $credit;
                                                                $credit = null
                                                            @endphp
                                                        @elseif($child->account_type == 'debit' && $credit < 0)
                                                            @php $debit += $credit; $credit = null @endphp
                                                        @endif
                                                        @if($coa->account_type == 'debit')
                                                            @if($debit < 0)
                                                                ( {{ abs($debit) }} )
                                                            @else
                                                                {{ $debit }}
                                                            @endif
                                                        @endif
                                                        @php
                                                            $ending_debit += $debit;
                                                            $sub_total_debit += $debit;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{--  credit--}}
                                                        @if($child->account_type == 'credit' && $debit > 0)
                                                            @php $credit -= $debit; $debit = null; @endphp
                                                        @elseif($child->account_type == 'credit' && $debit < 0)
                                                            @php $credit += $debit; $debit = null; @endphp
                                                        @endif
                                                        @if($coa->account_type == 'credit')
                                                            @if($credit < 0)
                                                                ( {{ abs($credit) }} )
                                                            @else
                                                                {{ $credit }}
                                                            @endif
                                                        @endif
                                                        @php
                                                            $ending_credit += $credit;
                                                            $sub_total_credit += $credit;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @if($coa->account_type == 'debit')
                                                            @if($ending_debit<0) ( {{ abs($ending_debit) }} )
                                                            @elseif($ending_debit == 0) {{ null }}
                                                            @else {{ $ending_debit }}
                                                            @endif
                                                        @endif
                                                        @php $total_debit += $ending_debit @endphp
                                                    </td>
                                                    <td>
                                                        @if($coa->account_type == 'credit')
                                                            @if($ending_credit<0) ( {{ abs($ending_credit) }} )
                                                            @elseif($ending_credit == 0) {{ null }}
                                                            @else {{ $ending_credit }}
                                                            @endif
                                                        @endif
                                                        @php $total_credit += $ending_credit @endphp
                                                    </td>
                                            @endforeach
                                        @else
                                            <tr class="table-bordered" style="text-align: right">
                                                <td style="text-align: center">{{ $coa->coa_reference_no }}</td>
                                                <td style="text-align: left">
                                                    <a href="{{route('single_account',['id'=>$coa->id] )}}">{{ $coa->coa_name }}</a>
                                                </td>
                                                <td>

                                                    @if($coa->account_type == 'debit' && $opening_credit > 0)
                                                        @php $opening_debit -= $opening_credit; $ending_debit = $opening_debit; $ending_credit = $opening_credit = null; @endphp
                                                    @endif
                                                    @if($coa->account_type == 'debit')
                                                        @if($opening_debit < 0)
                                                            ( {{ abs($opening_debit) }} )
                                                        @else
                                                            {{ $opening_debit }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit' && $opening_debit > 0)
                                                        @php $opening_credit -= $opening_debit; $ending_credit = $opening_credit; $ending_debit = $opening_debit = null; @endphp
                                                    @endif
                                                    @if($coa->account_type == 'credit')
                                                        @if($opening_credit < 0)
                                                            ( {{ abs($opening_credit) }} )
                                                        @else
                                                            {{ $opening_credit }}
                                                        @endif
                                                    @endif
                                                </td>

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
                                                        @php
                                                            $debit -= $credit;
                                                            $credit = null
                                                        @endphp
                                                    @elseif($coa->account_type == 'debit' && $credit < 0)
                                                        @php
                                                            $debit += $credit;
                                                            $credit = null
                                                        @endphp
                                                    @endif
                                                    @if($coa->account_type == 'debit')
                                                        @if($debit < 0)
                                                            ( {{ abs($debit) }} )
                                                        @else
                                                            {{ $debit }}
                                                        @endif
                                                    @endif
                                                    @php
                                                        $ending_debit += $debit;
                                                        $sub_total_debit += $debit;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit' && $debit > 0)
                                                        @php $credit -= $debit; $debit = null @endphp
                                                    @elseif($coa->account_type == 'credit' && $debit < 0)
                                                        @php $credit += $debit; $debit = null @endphp
                                                    @endif
                                                    @if($coa->account_type == 'credit')
                                                        @if($credit < 0)
                                                            ( {{ abs($credit) }} )
                                                        @else
                                                            {{ $credit }}
                                                        @endif
                                                    @endif
                                                    @php
                                                        $ending_credit += $credit;
                                                        $sub_total_credit += $credit;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'debit')
                                                        @if($ending_debit<0) ( {{ abs($ending_debit) }} )
                                                        @elseif($ending_debit == 0) {{ null }}
                                                        @else {{ $ending_debit }}
                                                        @endif
                                                    @endif
                                                    @php $total_debit += $ending_debit @endphp
                                                </td>
                                                <td>
                                                    @if($coa->account_type == 'credit')
                                                        @if($ending_credit<0) ( {{ abs($ending_credit) }} )
                                                        @elseif($ending_credit == 0) {{ null }}
                                                        @else {{ $ending_credit }}
                                                        @endif
                                                    @endif
                                                    @php
                                                        $total_credit += $ending_credit;
                                                    @endphp
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                            <tr class="table-bordered" style="font-weight: bold;">
                                                <td></td>
                                                <td colspan="3" class="pt-3">Total</td>
                                                <td class="pt-3">{{$sub_total_debit}}</td>
                                                <td class="pt-3">{{$sub_total_credit}}</td>
                                                <td class="pt-3" style="text-align: right">
                                                    @if($total_debit<0) ( {{ number_format(abs($total_debit),2,".",",") }} )
                                                    @else {{ number_format($total_debit,2,".",",") }}
                                                    @endif
                                                </td>
                                                <td class="pt-3" style="text-align: right">
                                                    @if($total_credit<0) ( {{ number_format(abs($total_credit),2,".",",") }} )
                                                    @else {{ number_format($total_credit,2,".",",") }}
                                                    @endif
                                                </td>
                                            </tr>
                            </tbody>
                        </table>

                        <div class="text-bottom text-center pt-5 mt-5" style="display: none" id="footer">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"> </p>
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
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(report).innerHTML;
            var to_date = document.getElementById('to_date').value;
            document.body.innerHTML = printContents;
            document.title='Trial Balance '+ to_date;
            window.print();
            window.location.href = "/epc/trial_balance_date";
        }
    </script>
@endsection
