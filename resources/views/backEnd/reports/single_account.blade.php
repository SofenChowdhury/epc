@extends('backEnd.master')

@section('mainContent')
<div class="row">
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 style="font-size: larger">{{ $coa->coa_reference_no }} . {{ $coa->coa_name }}</h5>
                <button class="btn btn-success" onclick="printDiv('printTransaction')" style="float: right; padding: 6px 50px;">Print</button>
            </div>
            <div class="card-block" id="printTransaction">
                <div class="row logo" id="logo" style="display:none;">
                    <div class="col-md-4" style="padding:3% 0 3% 5%;">
                        <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                    </div>
                    <div class="col-md-4" style="text-align: center; margin-top: 25px; font-weight: bold; padding:3% 0 3% 5%;">
                        <p style="font-size: 26px; ">Transaction Records of Account</p>
                        <p style="font-size: 22px; ">{{ $coa->coa_reference_no }} . {{ $coa->coa_name }}</p>
                    </div>
                </div>
                <br>
                <div class="table table-responsive">
                    <table class="table" id="transaction_table">
                        <thead>
                            <tr>
                                <th scope="col">Account</th>
                                <th scope="col">Voucher No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Debit</th>
                                <th scope="col">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                        @dd($coa);--}}
                        @if($children != '')
                            @foreach( $children as $child)
                                @foreach($transactions as $transaction)
                                    @if($transaction->coa_id == $child->id)
                                        <tr>
                                            <td><a href="{{ url('single_transaction', $transaction->transaction_id) }}">{{ $child->coa_name }}</a></td>
                                            <td>{{ $transaction->transaction->voucher_no }}</td>
                                            <td>{{ date('F d, Y', strtotime($transaction->transaction->transaction_date)) }}</td>
                                            <th>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</th>
                                            <th>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</th>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @else
                            @foreach($transactions as $transaction)
                                <tr style="font-size: larger" >
                                    <td><a href="{{ url('single_transaction', $transaction->transaction_id) }}">{{ $transaction->account->coa_name }}</a></td>
                                    <td>{{ $transaction->transaction->voucher_no }}</td>
                                    <td>{{ date('F d, Y', strtotime($transaction->transaction->transaction_date)) }}</td>
                                    <th>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</th>
                                    <th>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</th>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                    <div class="row">
                        <div class="col">
                            <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"> </p>
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
@endsection
