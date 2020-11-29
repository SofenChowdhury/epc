@extends('backEnd.master')

@section('mainContent')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    @if( isset($editData->report_name) )
                        <h5 class="card-header-text">Deliverable : {{ $editData->report_name }}</h5>
                    @else
                        <h5 class="card-header-text">No Deliverable Name</h5>
                    @endif
                </div>
                <div class="card-block">
                    <div class="view-info">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="general-info">
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="table-responsive">
                                                <table class="table m-0">
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row">Project Name</th>
                                                        @if( isset($editData->project_id) )
                                                            <td>
                                                                <a href="{{ route('project.show',$editData->project->id) }}" style="font-size: 1em; text-decoration: underline;">{{ $editData->project->project_name }}</a>
                                                            </td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Project Phase</th>
                                                        @if( isset($editData->project_phase) )
                                                            <td>{{$editData->project_phase }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Deliverable Name</th>
                                                        @if( isset($editData->report_name) )
                                                            <td>{{$editData->report_name }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Amount Percentage</th>
                                                        @if( isset($editData->amount_percentage) )
                                                            <td>{{$editData->amount_percentage }}%</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Total Amount </th>
                                                        @if( isset($editData->total_amount) )
                                                            <td>{{  number_format($editData->total_amount,2,".",",") }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Receive Status</th>
                                                        @if( isset($editData->status) )
                                                            <td style="color: blue;">{{ ucwords($editData->status) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Invoice Date </th>
                                                        @if( isset($editData->invoice_date) )
                                                            <td>{{ date('d-M-Y', strtotime($editData->invoice_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Payment Turnaround Days</th>
                                                        @if( isset($editData->turnaround_days) )
                                                            <td>{{ $editData->turnaround_days }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Interest Rate </th>
                                                        @if( isset($editData->interest_rate) )
                                                            <td>{{$editData->interest_rate }}%</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Receive Due Date</th>
                                                        @if( isset($editData->receive_due_date) )
                                                            <td>{{ date('d-M-Y', strtotime($editData->receive_due_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Received Amount</th>
                                                        @if( isset($editData->amount_received) )
                                                            <td>{{  number_format($editData->amount_received,2,".",",") }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif

                                                        <th scope="row">Receive Date</th>
                                                        @if( isset($editData->receive_date) )
                                                            <td>{{ date('d-M-Y', strtotime($editData->receive_date)) }}</td>
                                                        @else
                                                            <td>No input given</td>
                                                        @endif
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">Description</th>
                                                        @if( isset($editData->description) )
                                                            <td colspan="3">{{ $editData->description }}</td>
                                                        @else
                                                            <td colspan="3">No input given</td>
                                                        @endif
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mt-5 text-center">
                        <div class="col-md-12 text-center" style="margin-bottom: 1em;">
                            <a class="" title="Back" href="{{url('/project',$editData->project_id)}}">
                                <button type="button" class="btn btn-primary m-b-0">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
