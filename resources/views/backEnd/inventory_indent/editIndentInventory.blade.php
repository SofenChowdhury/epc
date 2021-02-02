@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{asset('public/assets/css/addTransaction.css')}}">
@endsection
@section('mainContent')
    <div class="card">
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
        <div class="card-header">
            <h5>Indent List</h5>
        </div>
        <form action="{{url('IndentUpdateInventory',[$id])}}" method="post">@csrf
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-sm voucher-table">
                        <thead>
                            <tr class="table-info">
                                <th scope="col " >Item No.</th>
                                <th scope="col" >Description</th>
                                <th scope="col" >Quantity</th>
                                <th scope="col" >Price</th>
                            </tr>
                        </thead>
                        @foreach($indentDataChild as $data)
                        <tbody id="IndentData">
                            <tr class="table pb-0">
                                <td class="pb-0">
                                    @if(isset($data->id))
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="vendor[]" value="{{$data->vendor}}" required/><br>
                                            {{$data->vendor}}
                                        </div>
                                    @endif
                                </td>
                                <td class="pb-0">
                                    @if(isset($data->id))
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="purpose[]" value="{{$data->purpose}}" required/><br>
                                            {{$data->purpose}}
                                        </div>
                                    @endif
                                </td>
                                <td class="pb-0">
                                    @if(isset($data->id))
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="exp_code[]" value="{{$data->exp_code}}" required/><br>
                                            {{$data->exp_code}}
                                        </div>
                                    @endif
                                </td>
                                <td class="pb-0">
                                    @if(isset($data->id))
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="amount[]" value="{{$data->amount}}" required/><br>
                                            {{$data->amount}}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tfoot>
                        <tr>
                            <td>
{{--                                <div class="row">--}}
{{--                                    <input type="button" onclick="AppendDataRow()" class="btn btn-info mt-3" id="addrow" value="Add New Field" />--}}
{{--                                </div>--}}
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="text-right">
                                    <input type="submit"  class="btn btn-info mt-3"  value="Confirm"/>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <script>
        function AppendDataRow(){
            $('#IndentData')
                .append("<tr class=\"table pb-0\">\n" +
    "                        <td class=\"pb-0\">\n" +
    "                            <div class=\"form-group\">\n" +
    "                                <input type=\"text\" class=\"form-control\" name=\"vendor[]\" placeholder=\"Name of vendor/Paid to\" />\n" +
    "                            </div>\n" +
    "                        </td>\n" +
    "                        <td class=\"pb-0\">\n" +
    "                            <div class=\"form-group\">\n" +
    "                                <input type=\"text\" class=\"form-control\" name=\"purpose[]\" placeholder=\"Purpose of Payment\" />\n" +
    "                            </div>\n" +
    "                        </td>\n" +
    "                        <td class=\"pb-0\">\n" +
    "                            <div class=\"form-group\">\n" +
    "                                <input type=\"text\" class=\"form-control\" name=\"exp_code[]\" placeholder=\"Project Exp Code\" />\n" +
    "                            </div>\n" +
    "                        </td>\n" +
    "                        <td class=\"pb-0\">\n" +
    "                            <div class=\"form-group\">\n" +
    "                                <input type=\"number\" class=\"form-control\" name=\"amount[]\" placeholder=\"Amount\" />\n" +
    "                            </div>\n" +
    "                        </td>\n" +
    "                    </tr>");
        }
    </script>
@endSection
