@extends('backEnd.master')

@section('mainContent')

<div class="row">
    <div class=" col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Journal entries </h4>
            </div>
            <div class="card-block">
                <div class="row input-daterange">
                    <div class="col-md-4">
                        <input type="text" class="form-control datepicker" name="from_date" id="from_date" placeholder="From Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control datepicker" name="to_date" id="to_date"  placeholder="To Date" readonly autocomplete="off"/>
                    </div>
                    <div class="col-md-4">
                        <button type="button" name="filter" id="filter" class="btn btn-primary mr-3">Filter</button>
                        <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                    </div>
                </div>
                <br>
                <div class="table table-responsive">
                    <table class="table" id="order_table">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">Voucher No.</th>
                                <th scope="col" width="15%">Date</th>
                                <th scope="col" width="15%">Ref. No.</th>
                                <th scope="col" width="30%">Account</th>
                                <th scope="col" width="15%">Debit</th>
                                <th scope="col" width="15%">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                            @foreach($transactions as $transaction)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $transaction->transaction->voucher_no }}</td>--}}
{{--                                    <td>{{ date('F d, Y', strtotime($transaction->transaction->created_at)) }}</td>--}}
{{--                                    <td>{{ $transaction->account->coa_name }}</td>--}}
{{--                                    <td>{{ $transaction->debit_amount > 0 ? $transaction->debit_amount : '' }}</td>--}}
{{--                                    <td>{{ $transaction->credit_amount > 0 ? $transaction->credit_amount : '' }}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                            <tr style="font-size: 1.2em">--}}
{{--                                <td colspan="2"></td>--}}
{{--                                <th>Total</th>--}}
{{--                                <th>{{ $total_debit_amount }}</th>--}}
{{--                                <th>{{ $total_credit_amount  }}</th>--}}
{{--                            </tr>--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function(){

            load_data();

            function load_data(from_date = '', to_date = '')
            {
                $('#order_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:'{{ url('journal_entry') }}',
                        data:{from_date:from_date, to_date:to_date}
                    },
                    columns: [
                        {
                            data:'voucher_no',
                            name:'voucher_no'
                        },
                        {
                            data:'transaction_date',
                            name:'transaction_date'
                        },
                        {
                            data:'coa_reference_no',
                            name:'coa_reference_no'
                        },
                        {
                            data:'coa_name',
                            name:'coa_name'
                        },
                        {
                            data:'debit_amount',
                            name:'debit_amount'
                        },
                        {
                            data:'credit_amount',
                            name:'credit_amount'
                        }
                    ]
                });
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
                var to_date = $('#to_date').datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
                if(from_date != '' &&  to_date != '')
                {
                    $('#order_table').DataTable().destroy();
                    load_data(from_date, to_date);
                }
                else
                {
                    alert('Both Date is required');
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#order_table').DataTable().destroy();
                load_data();
            });
        });
    </script>

@endsection
