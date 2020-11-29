<div class="tab-pane" id="expenses" role="tabpanel">
    <div class="logo row" id="logo" style="display:none;">
        <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
        </div>
        <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
            <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Project Payment Details</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            @if( isset($editData->project_name) )
                <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
            @else
                <h5 class="card-header-text">No Project Name</h5>
            @endif
            <br>
            <button class="btn btn-success printBtn" onclick="printPaymentsDiv('expenses')" style="float: right; padding: 0.4em;" target="_blank">Print Payment Details</button>
        </div>
        <div class="card-block">
            @if(isset($distinct_phases))
                @foreach( $distinct_phases as $distinct_phase)
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                @foreach($phases as $phase)
                                    @if( $distinct_phase->project_phase == $phase->defined_id )
                                        PHASE - 00{{$phase->defined_id}} {{$phase->name}}
                                    @endif
                                @endforeach
                            </strong>
                        </div>
                        <div class="card-block">
                            @php $total_debit = $total_credit = 0 @endphp
                            <div class="table-responsive">
                                <table id="payment_table" class="table table-striped table-bordered payment_table">
                                    <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Date</th>
                                        <th>COA ID</th>
                                        <th>Voucher No</th>
                                        <th>Recorded By</th>
                                        <th>Description</th>
                                        <th>Debit Amount</th>
                                        <th>Credit Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($editData->payments))
                                        @php $i = 1 @endphp
                                        @foreach($editData->payments as $payment)
                                            @php $debit = $credit = 0 @endphp
                                            @if($payment->project_phase == $distinct_phase->project_phase)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        @if(isset($payment->transaction))
                                                            {{ date('d-M-Y', strtotime($payment->transaction->transaction_date)) }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($payment->account))
                                                            {{ $payment->account->coa_reference_no }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($payment->transaction))
                                                            {{ $payment->transaction->voucher_no }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @foreach($users as $creator)
                                                            @if( $payment->created_by == $creator->id )
                                                                {{$creator->name}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @if(isset($payment->transaction))
                                                            {{ $payment->transaction->description }}
                                                        @else
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($payment->detail))
                                                            @php $debit = $payment->detail->debit_amount @endphp
                                                            {{ $debit }}
                                                        @else
                                                            0
                                                        @endif
                                                        @php $total_debit += $debit @endphp
                                                    </td>
                                                    <td>
                                                        @if(isset($payment->detail))
                                                            @php $credit = $payment->detail->credit_amount @endphp
                                                            {{ $credit }}
                                                        @else
                                                            0
                                                        @endif
                                                        @php $total_credit += $credit @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    @endif
                                    </tbody>
                                    <tr>
                                        <th colspan="6" style="text-align: right;">Total</th>
                                        <th>{{ $total_debit }}</th>
                                        <th>{{ $total_credit }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
        <div class="row">
            <div class="col">
                <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime2"> </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.payment_table').DataTable();
    } );

    function printPaymentsDiv(payments)
    {
        $('.printBtn').hide();
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();
        var dt = new Date();
        document.getElementById("datetime2").innerHTML = dt.toLocaleString();

        var printContents = document.getElementById(expenses).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title=project_name + ' Payment Details';
        window.print();
        window.location.href = "/epc/project/"+project_id;
    }
</script>

