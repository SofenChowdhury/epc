@extends('backEnd.master')

@section('mainContent')
    <div class="row">
        <div class=" col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Transaction Record</h5>
                    <button class="btn btn-success" onclick="printDiv('printTransaction')" style="float: right; padding: 6px 50px;">Print</button>
                </div>
                <div class="card-block" id="printTransaction">
                    <div class="row logo" id="logo" style="display:none;">
                        <div class="col-md-4" style="padding:3% 0 3% 5%;">
                            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                        </div>
                        <div class="col-md-12" style="text-align: center; margin-top: -140px; font-weight: bold; padding:3% 0 3% 5%;">
                            <p style="font-size: 26px; ">Transaction Records of</p>
                            <p style="font-size: 22px; ">voucher Number {{ $transaction->voucher_no }}</p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label style="color: #5e95ff"><b>Transaction date : </b>{{ date('F d, Y', strtotime($transaction->transaction_date)) }}</label>
{{--                                <h5 style="font-size: medium">{{ date('F d, Y', strtotime($transaction->transaction_date)) }}</h5>--}}
{{--                                <input type="" class="form-control" name="transaction_date" readonly value="{{ date('F d, Y', strtotime($transaction->transaction_date)) }}">--}}
                            </div>
                            <div class="form-group col-md-4">
                                <label style="color: #5e95ff"><b>Reference No : </b>{{ $transaction->voucher_no }}</label>
{{--                                <h5 style="font-size: medium">{{ $transaction->voucher_no }}</h5>--}}
{{--                                <input type="" class="form-control" name="voucher_no" readonly value="{{ $transaction->voucher_no }}">--}}
                            </div>
                            <div class="form-group col-md-4">
                                <label style="color: #5e95ff"><b>Recorded By : </b>
{{--                                <input type="" class="form-control" name="voucher_no" readonly--}}
                                    @if(isset($users))
                                        @foreach($users as $user)
                                            @if($transaction->created_by == $user->id)
{{--                                                <h5 style="font-size: medium">{{ $user->name }}</h5>--}}
                                                {{ $user->name }}
                                </label>
                                            @endif
                                        @endforeach
                                    @endif
{{--                                >--}}

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <lable style="color: #5e95ff"><b>Recorded At : </b>{{ date('F d, Y H:i:s', strtotime($transaction->created_at)) }}</lable>
                                {{--                                <h5 style="font-size: medium">{{ date('F d, Y H:i:s', strtotime($transaction->created_at)) }}</h5>--}}
                                {{-- <input type="" class="form-control" name="transaction_date" readonly value="{{ date('F d, Y', strtotime($transaction->transaction_date)) }}">--}}
                            </div>
                            <div class="form-group col-md-8">
                                <label style="color: #5e95ff"><b>Description : </b></label>
                                <h5 style="font-size: medium">{{ $transaction->description }}</h5>
{{--                                <textarea class="form-control" readonly name="description">{{ $transaction->description }}</textarea>--}}
                            </div>
                        </div>
                    </div>
                    <br><hr>
                    <div> {{--class="table table-responsive"--}}
                        <table class="table"> {{--id="transaction_table"--}}
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">REFERENCE NO.</th>
                                    <th scope="col">ACCOUNT</th>
                                    <th scope="col">DEBIT</th>
                                    <th scope="col">CREDIT</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction->transactionDetail as $transaction)
                                <tr style="font-size: larger" >
                                    <th><a href="{{ url('single_account', $transaction->coa_id) }}">{{ $transaction->account->coa_reference_no }}</a></th>
                                    <th>{{ $transaction->account->coa_name }}</th>
                                    <th>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</th>
                                    <th>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</th>
                                </tr>
                            @endforeach
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
        document.title='Transaction Record';
        window.print();
        history.go(0);
    }
</script>
@endsection
