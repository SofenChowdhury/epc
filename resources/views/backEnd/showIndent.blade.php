@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-md-4">
            @if(session()->has('message-success'))
                <div class="alert alert-success mb-3 background-success" role="alert">
                    {{ session()->get('message-success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session()->has('message-danger'))
                <div class="alert alert-danger">
                    {{ session()->get('message-danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('message-success-delete'))
                <div class="alert alert-danger mb-3 background-danger" role="alert">
                    {{ session()->get('message-success-delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session()->has('message-danger-delete'))
                <div class="alert alert-danger">
                    {{ session()->get('message-danger-delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        @can('View Indent List')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Indent List</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Project</th>
                                    <th>Indent_no</th>
                                    <th>Date</th>
                                    <th>Note</th>
                                    <th>Initiator</th>
                                    <th>Initiator_remark</th>
                                    <th>Manager</th>
                                    <th>Manager_remark</th>
                                    <th>Associate_director</th>
                                    <th>Associate_director_remark</th>
                                    <th>Director_2</th>
                                    <th>Director_2_remark</th>
{{--                                    <th>Director_1</th>--}}
{{--                                    <th>Director_1_remark</th>--}}
                                    <th>Chairman</th>
                                    <th>Chairman_remark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($indentDataMaster))
                                    @php $i = 1 @endphp
                                    @foreach($indentDataMaster as $value)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$value->title}}</td>
                                            <td>{{$value->project}}</td>
                                            <td>{{$value->indent_no}}</td>
                                            <td>{{$value->date}}</td>
                                            <td>{{$value->note}}</td>
                                            <td>Prepared by : <br>{{$value->accountant}}</td>
                                            <td>{{$value->accountant_remark}}</td>
                                            <td>
                                                @if($value->manager_action == 1)
                                                    Approved
                                                @elseif($value->manager_action == 2)
                                                    Rejected
                                                @else
                                                    @if(Auth::user()->id == 24 && $value->confirm == 1)
                                                        <p onclick="managerAction({{$value->id}},'manager')">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Action</button>
                                                        </p>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$value->manager_remark}}</td>
                                            <td>
                                                @if($value->associate_director_action == 1)
                                                    Approved
                                                @elseif($value->associate_director_action == 2)
                                                    Rejected
                                                @elseif($value->manager_action == 1)
                                                    @if(Auth::user()->id == 23)
                                                        <button type="button" class="btn btn-warning" onclick="managerAction({{$value->id}},'associate_director')">Action</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$value->associate_director_remark}}</td>
                                            <td>
                                                @if($value->director_2_action == 1)
                                                    Approved
                                                @elseif($value->director_2_action == 2)
                                                    Rejected
                                                @elseif($value->associate_director_action == 1)
                                                    @if(Auth::user()->id == 21)
                                                        <button type="button" class="btn btn-warning" onclick="managerAction({{$value->id}},'director_2')">Action</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$value->director_2_remark}}</td>
{{--                                            <td>--}}
{{--                                                @if($value->director_1_action == 1)--}}
{{--                                                    Approved--}}
{{--                                                @elseif($value->director_1_action == 2)--}}
{{--                                                    Rejected--}}
{{--                                                @elseif($value->director_2_action == 1)--}}
{{--                                                    @if(Auth::user()->id == 20)--}}
{{--                                                        <button type="button" class="btn btn-warning" onclick="managerAction({{$value->id}},'director_1')">Action</button>--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td>{{$value->director_1_remark}}</td>--}}
                                            <td>
                                                @if($value->chairman_action == 1)
                                                    Approved
                                                @elseif($value->chairman_action == 2)
                                                    Rejected
                                                @elseif($value->director_2_action == 1)
                                                    @if(Auth::user()->id == 19)
                                                        <button type="button" class="btn btn-warning" onclick="managerAction({{$value->id}},'chairman')">Action</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$value->chairman_remark}}</td>
                                            <td>
                                                @if(Auth::user()->name == $value->accountant || Auth::user()->name == 'Kawser Ahmed' || Auth::user()->name == 'Md Admin' || Auth::user()->name == 'Taher Mohammad Niaz')
                                                    @if(Auth::user()->name == 'Kawser Ahmed' || Auth::user()->name == 'Md Admin')
                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('IndentDeleteView', $value->id)}}">
                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                        </a>
                                                    @endif
                                                    @if($value->chairman_action == 1 || Auth::user()->name == 'Kawser Ahmed' || Auth::user()->name == 'Md Admin')
                                                        <a class="" title="print"  href="{{route('IndentPrint',['id' => $value->id])}}" target="_blank">
                                                            <button type="button" class="btn btn-primary">Print</button>
                                                        </a>
                                                    @endif
                                                @endif
                                                <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $value->id}}" data-id="{{$value->id}}" >
                                                    <button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button>
                                                </a>
                                                <div class="modal fade" id="myModal_{{ $value->id}}" role="dialog" >
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content" style="width: 100%">
                                                            <div class="modal-header">
                                                                @if( isset($value->title) )
                                                                    <h3 class="modal-title" style="color:#000000">Engineering & Planning Consultants Ltd.<br><span>7/4,Block-A, Lalmatia,Dhaka-1207</span></h3>
                                                                    <span><strong>Indent No: {{$value->indent_no}}</strong><br>Date: {{$value->date}}</span><br>
                                                                @endif
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp
                                                            </div>
                                                            <div class="modal-body" >
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <h5 class="text-center">Indent Title: {{$value->title}}</h5>
                                                                        <tbody>
                                                                        <tr>
                                                                            <th scope="col " colspan="3">Name of vendor/Paid to</th>
                                                                            <th scope="col" colspan="3">Purpose of Payment</th>
                                                                            <th scope="col" colspan="3">Project Exp Code</th>
                                                                            <th scope="col" colspan="3">Amount</th>
                                                                        </tr>
                                                                        @foreach($indentDataChild as $data)
                                                                            @if($value->id == $data->master_id)
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    @if(isset($data->id))
                                                                                        {{$data->vendor}}
                                                                                    @endif
                                                                                </td>

                                                                                <td colspan="3">
                                                                                    @if(isset($data->id))
                                                                                        {{$data->purpose}}
                                                                                    @endif
                                                                                </td>

                                                                                <td colspan="3">
                                                                                    @if(isset($data->id))
                                                                                        {{$data->exp_code}}
                                                                                    @endif
                                                                                </td>

                                                                                <td colspan="3">
                                                                                    @if(isset($data->id))
                                                                                        {{$data->amount}}
                                                                                        @php
                                                                                            $total += $data->amount;
                                                                                        @endphp
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            @endif
                                                                        @endforeach
                                                                            <tr>
                                                                                <th scope="col " colspan="3"></th>
                                                                                <th scope="col " colspan="3"></th>
                                                                                <th scope="col " colspan="3">Total TK =</th>
                                                                                <th scope="col " colspan="3">{{$total}}</th>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="modal fade" id="actionModal" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 100%">
                <div class="modal-header">
                    <h4 class="modal-title" style="color:#000000">Permission</h4>
                </div>
                <div class="modal-body" >
                    <div class="table-responsive">
                        <form method="post" action="{{url('approvalAction')}}">@csrf
                            <table class="table m-0">
                                <tbody>
                                    <tr>
                                        <th><b>Remark:</b></th>
                                        <th>
                                            <textarea class="form-control" id="remark" name="remark"></textarea>
                                            <input name="action" id="actionInput" required type="hidden">
                                            <input name="id" id="indentId" required type="hidden">
                                            <input name="indentUser" id="indentUser" required type="hidden">
                                        </th>
                                        <th>
                                            <button type="button" class="btn btn-success" onclick="AppAction(1)">Approved</button>
                                        </th>
                                        <th>
                                            <button type="button" class="btn btn-danger" onclick="AppAction(2)">Reject</button>
                                        </th>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col " colspan="1">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </th>
                                        <th scope="col " colspan="4">
                                            <button type="submit" class="btn btn-primary" style="float: right" >Submit</button>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function managerAction(id,id1,id2){
            $('#actionModal').modal('show');
            $('#indentId').val(id);
            $('#indentUser').val(id1);
            $('#remark').val(id2);
        }
        function AppAction(id1){
            $('#actionInput').val(id1);
        }
    </script>
@endSection
