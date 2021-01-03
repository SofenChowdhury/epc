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
                        {{--                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'select',--}}
                        {{--                            'method' => 'GET', 'enctype' => 'multipart/form-data'])}}--}}
                        <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>title</th>
                                    <th>indent_no</th>
                                    <th>date</th>
                                    <th>note</th>
                                    <th>accountant</th>
                                    <th>accountant_remark</th>
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
                                            <td>{{$value->indent_no}}</td>
                                            <td>{{$value->date}}</td>
                                            <td>{{$value->note}}</td>
                                            <td>{{$value->accountant}}</td>
                                            <td>{{$value->accountant_remark}}</td>
                                            <td>
                                                @if(Auth::user()->name == $value->accountant)
                                                    <a class="modalLink m-4" title="Delete" data-modal-size="modal-md" href="{{url('IndentDeleteView', $value->id)}}">
                                                        <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                    </a>
                                                @endif

                                                <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $value->id}}" data-id="{{$value->id}}" >
                                                    <button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button>
                                                </a>
                                                <!-- Product Details Model -->
                                                <div class="modal fade" id="myModal_{{ $value->id}}" role="dialog" >
                                                    <div class="modal-dialog modal-lg">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                @if( isset($value->title) )
                                                                    <h4 class="modal-title" style="color:#000000">{{ $value->title }}-{{$value->indent_no}}({{$value->date}})</h4>
                                                                @endif
                                                            </div>
                                                            <div class="modal-body" >
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                        <tr>
                                                                            <th scope="col">title </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->title}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">indent_no </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->indent_no}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">date </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->date}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">note </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->note}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">accountant </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->accountant}}
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="col">accountant_remark </th>
                                                                            <td colspan="3">
                                                                                @if(isset($value->id))
                                                                                    {{$value->accountant_remark}}
                                                                                @endif
                                                                            </td>
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
                        {{--                        <div class="form-group row mt-4">--}}
                        {{--                            <div class="col-sm-12 text-center">--}}
                        {{--                                <button type="submit" class="btn btn-primary m-b-0">Assign</button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        {{ Form::close()}}--}}
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endSection
