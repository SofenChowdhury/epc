{{--@extends('backEnd.master')--}}
{{--@section('mainContent')--}}

{{--@if(session()->has('message-success'))--}}
{{--    <div class="alert alert-success mb-3 background-success" role="alert">--}}
{{--        {{ session()->get('message-success') }}--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}
{{--@elseif(session()->has('message-danger'))--}}
{{--    <div class="alert alert-danger">--}}
{{--        {{ session()->get('message-danger') }}--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if(session()->has('message-success-delete'))--}}
{{--    <div class="alert alert-danger mb-3 background-danger" role="alert">--}}
{{--        {{ session()->get('message-success-delete') }}--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}
{{--@elseif(session()->has('message-danger-delete'))--}}
{{--    <div class="alert alert-danger">--}}
{{--        {{ session()->get('message-danger-delete') }}--}}
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}
{{--@endif--}}

{{--<div class="card">--}}
{{--    <div class="card-header">--}}
{{--        <h5>Employee Indents</h5>--}}
{{--        @can('Add Inventory')--}}
{{--            <a href="{{ route('inventory.create') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add Inventory </a>--}}
{{--        @endcan--}}
{{--    </div>--}}
{{--    @can('View Indent List')--}}
{{--        <div class="card-block">--}}
{{--            <div class="table-responsive">--}}
{{--                <table id="basic-btn" class="table table-striped table-bordered">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>SL</th>--}}
{{--                        <th>Indent No</th>--}}
{{--                        <th>Employee ID</th>--}}
{{--                        <th>Employee Name</th>--}}
{{--                        <th>Product Name</th>--}}
{{--                        <th>Quantity</th>--}}
{{--                        <th>Requested By</th>--}}
{{--                        <th>Requested On</th>--}}
{{--                        <th>Description</th>--}}
{{--                        <th>Actions</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @php $i = 1 @endphp--}}
{{--                    @foreach($indents as $indent)--}}
{{--                        <tr>--}}
{{--                            <td>{{$i++}}</td>--}}
{{--                            <td>{{$indent->indent_no}}</td>--}}
{{--                            <td>{{$indent->employee->unique_id}}</td>--}}
{{--                            <td>{{$indent->employee->first_name}} {{$indent->employee->last_name}}</td>--}}
{{--                            <td>{{$indent->product_name}}</td>--}}
{{--                            <td>{{$indent->quantity}}</td>--}}
{{--                            <td>{{$indent->indenter->first_name}} {{$indent->indenter->last_name}}</td>--}}
{{--                            <td>{{ date('d-M-Y', strtotime($indent->created_at)) }}</td>--}}
{{--                            <td>{{$indent->description}}</td>--}}
{{--                            <td>--}}
{{--                                @can('Edit Inventory')--}}
{{--                                    <a href="{{ route('employee.show',$indent->employee_id) }}" title="View Profile"><button type="button" class="btn btn-info action-icon"><i class="fa fa-eye"></i></button></a>--}}
{{--                                @endcan--}}
{{--                                @if(Auth::user()->getRoleNames()->first() == 'Super Admin')--}}
{{--                                    <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteIndentView', $indent->id)}}">--}}
{{--                                        <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endcan--}}
{{--</div>--}}
{{--@endSection--}}
