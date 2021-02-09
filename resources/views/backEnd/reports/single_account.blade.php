@extends('backEnd.master')

@section('mainContent')

<div class="row">
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2">
                        <h5 style="font-size: larger">{{ $coa->coa_reference_no }} . {{ $coa->coa_name }}</h5>
                    </div>
                    <div class="col-md-9">
                        <form method="get" action="{{route('single_account_date_range')}}">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" name="start_date">
                                    <input type="hidden" class="form-control" name="id" value="{{$id}}">
                                </div>
                                <div class="col-md-5">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" name="end_date">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary" onclick="printDiv('printTransaction')" style="float: right; padding: 6px 50px;">Print</button>
                    </div>
                </div>
            </div>
            <div class="card-block" id="printTransaction">
                <div class="row logo" id="logo" style="display:none;">
                    <div class="col-md-4" style="text-align: left; padding:3% 0 3% 5%;">
                        <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                    </div>
                    <br>
                    <div class="col-md-12" style="text-align: center; margin-top: -140px; font-weight: bold; padding:3% 0 3% 5%;">
                        <p style="font-size: 26px; ">Transaction Records of Account</p>
                        <p style="font-size: 22px; ">{{ $coa->coa_reference_no }} . {{ $coa->coa_name }}</p>
                        <p style="font-size: 22px; ">Form Date: {{ $form_date }} - To Date: {{ $to_date }}</p>
                    </div>
                </div>
                <div>
                    <table class="table"> {{--id="example"  class="table table-responsive"  --}}
                        <thead>
                            <tr>
                                <th scope="col">Account</th>
                                <th scope="col">Voucher No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Debit</th>
                                <th scope="col">Credit</th>
                                <th scope="col">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                        @dd($coa);--}}
                        @php
                            $balence = $total_balance;
                            $total_debit = 0;
                            $total_credit = 0;
                        @endphp
                            <tr>
                                <td>OPENING</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{$total_balance}}</td>
                            </tr>
                        @if($children != '')
                            @foreach( $children as $child)

                                @foreach($transactions as $transaction)
                                    @php
                                        $get_transection    = DB::table('erp_transaction_details')
                                            ->leftjoin('erp_chart_of_accounts','erp_chart_of_accounts.id','erp_transaction_details.coa_id')
                                            ->where('transaction_id',$transaction->transaction_id)
                                            ->select('erp_chart_of_accounts.coa_name')
                                            ->get();
                                        $close = DB::table('erp_transactions')
                                            ->leftJoin('erp_transaction_details','erp_transaction_details.transaction_id','erp_transactions.id')
                                            ->where('erp_transaction_details.coa_id',183)
                                            ->where('erp_transactions.id',$transaction->transaction_id+1)
                                            ->select('credit_amount','debit_amount','transaction_date','total_transaction')
                                            ->get($loop->index+1);

                                    @endphp
                                    @if($transaction->coa_id == $child->id)
                                        <tr>
                                            <td>
                                                <a href="{{ url('single_transaction', $transaction->transaction_id) }}">
                                                    {{ $child->coa_name }}
                                                </a>
                                                @foreach($get_transection as $key)
                                                    @if($transaction->account->coa_name != $key->coa_name)
                                                        <p>{{$key->coa_name}}</p>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $transaction->transaction->voucher_no }}</td>
                                            <td>{{ date('F d, Y', strtotime($transaction->transaction->transaction_date)) }}</td>
                                            <td>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</td>
                                            <td>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</td>
                                            @php
                                                $total_debit += $transaction->debit_amount;
                                                $total_credit += $transaction->credit_amount;
                                                $balence += $transaction->debit_amount - $transaction->credit_amount;
                                            @endphp
                                            <td>
                                                {{$balence}}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @else
                            @foreach($transactions as $transaction)
                                @php
                                    $get_transection    = DB::table('erp_transaction_details')
                                        ->leftjoin('erp_chart_of_accounts','erp_chart_of_accounts.id','erp_transaction_details.coa_id')
                                        ->where('transaction_id',$transaction->transaction_id)
                                        ->select('erp_chart_of_accounts.coa_name')
                                        ->get();

                                @endphp
                                <tr style="font-size: larger" >
                                    <td>
                                        <a href="{{ url('single_transaction', $transaction->transaction_id) }}">{{ $transaction->account->coa_name }}</a>
                                        @foreach($get_transection as $key)
                                            @if($transaction->account->coa_name != $key->coa_name)
                                                <p>{{$key->coa_name}}</p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $transaction->transaction->voucher_no }}</td>
                                    <td>{{ date('F d, Y', strtotime($transaction->transaction->transaction_date)) }}</td>
                                    <th>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</th>
                                    <th>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</th>
                                    <th>
                                        {{$transaction->debit_amount }}
                                    </th>
                                    @php
                                        $total_debit += $transaction->debit_amount;
                                        $total_credit += $transaction->credit_amount;
                                    @endphp
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Total Debit: {{$total_debit}}</th>
                            <th scope="col">Total Credit: {{$total_credit}}</th>
                            <th scope="col"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                    <div class="row">
                        <div class="col">
                            <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"/> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#transaction_table').DataTable();
        } );
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        function printDiv(printTransaction)
        {
            document.getElementById('logo').style.display = "block";
            document.getElementById('footer').style.display = "block";
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(printTransaction).innerHTML;
            document.body.innerHTML = printContents;
            document.title='Transaction Records';
            window.print();
            history.go(0);
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#example').DataTable( {
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            } );
        } );
    </script>
@endsection
