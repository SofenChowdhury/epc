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
        @can('View Inventory Indent List')
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
                                    <th>title</th>
                                    <th>project</th>
                                    <th>indent_no</th>
                                    <th>date</th>
                                    <th>note</th>
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
                                            <td>
                                                @if(Auth::user()->name == $value->accountant && $value->manager_action != 1)
                                                    <a class="" title="edit"  href="{{route('IndentEditInventory',['id' => $value->id])}}" target="_blank">
                                                        <button type="button" class="btn btn-primary">Check</button>
                                                    </a>
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
                                                                            <th scope="col " colspan="3">Item No.</th>
                                                                            <th scope="col" colspan="3">Description</th>
                                                                            <th scope="col" colspan="3">Quantity</th>
                                                                            <th scope="col" colspan="3">Price</th>
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
@endSection
