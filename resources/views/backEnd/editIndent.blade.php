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
                    <form action="{{url('IndentUpdate',[$id])}}" method="post">@csrf
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    <th scope="col " colspan="3">Name of vendor/Paid to</th>
                                    <th scope="col" colspan="3">Purpose of Payment</th>
                                    <th scope="col" colspan="3">Project Exp Code</th>
                                    <th scope="col" colspan="3">Amount</th>
                                </tr>
                                @foreach($indentDataChild as $data)
                                        <tr>
                                            <td colspan="3">
                                                @if(isset($data->id))
                                                    <input type="text" name="vendor[]" value="{{$data->vendor}}"/><br>
                                                    {{$data->vendor}}
                                                @endif
                                            </td>

                                            <td colspan="3">
                                                @if(isset($data->id))
                                                    <input type="text" name="purpose[]" value="{{$data->purpose}}"/><br>
                                                    {{$data->purpose}}
                                                @endif
                                            </td>

                                            <td colspan="3">
                                                @if(isset($data->id))
                                                    <input type="text" name="exp_code[]" value="{{$data->exp_code}}"/><br>
                                                    {{$data->exp_code}}
                                                @endif
                                            </td>

                                            <td colspan="3">
                                                @if(isset($data->id))
                                                    <input type="number" name="amount[]" value="{{$data->amount}}"/><br>
                                                    {{$data->amount}}
                                                @endif
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-right">
                                <input type="submit"  class="btn btn-info mt-3"  value="Confirm"/>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        @endcan
    </div>
@endSection
