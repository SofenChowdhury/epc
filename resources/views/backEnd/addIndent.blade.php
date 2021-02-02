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
            <div class="text-right">
                <a href="{{route('check_indents')}}" >
                    <input type="button"  class="btn btn-info mt-3"  value="Previous Indent Check"/>
                </a>
            </div>
            <div class="text-left">
                <h5>Add Indent</h5>
            </div>
        </div>
        <form action="{{url('insert_indents')}}" method="post">@csrf
            <div class="row md-layout md-gutter">
                <div class="col-md-3 md-layout-item">
                    <label for="" class="col-form-label">Indent Title:</label>
                    <input type="text" class="form-control p-2" value="" name="title" id="" required/>
                </div>
                <div class="col-md-3 md-layout-item">
                    <label for="" class="col-form-label">Project</label>
                    <input type="text" class="form-control p-2" value="" name="project" id="" required/>
                </div>
                <div class="col-md-3">
                    <label for="date" class="col-form-label">Indent date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="col-md-3 md-layout-item">
                    <label for="voucher_no" class="col-form-label">Voucher No:</label>
                    <input type="text" class="form-control p-2" required readonly value="{{rand()}}" name="voucher_no" id="voucher_no"/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="description" class="col-form-label">Indent Note: </label>
                    <textarea class="form-control" name="note" id="description"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="description" class="col-form-label">Remarks: </label>
                    <textarea class="form-control" name="remarks" id="description"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-sm voucher-table">
                        <thead>
                        <tr class="table-info">
                            <th scope="col" width="20%">Name of vendor/Paid to</th>
                            <th scope="col"width="20%">Purpose of Payment</th>
                            <th scope="col"width="20%">Project Exp Code</th>
                            <th scope="col"width="15%">Amount</th>
                        </tr>
                        </thead>
                        <tbody id="IndentData">
                        <tr class="table pb-0">
                            <td class="pb-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="vendor[]" placeholder="Name of vendor/Paid to" />
                                </div>
                            </td>
                            <td class="pb-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="purpose[]" placeholder="Purpose of Payment" />
                                </div>
                            </td>
                            <td class="pb-0">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="exp_code[]" placeholder="Project Exp Code" />
                                </div>
                            </td>
                            <td class="pb-0">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="amount[]" placeholder="Amount" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <div class="row">
                                    <input type="button" onclick="AppendDataRow()" class="btn btn-info mt-3" id="addrow" value="Add New Field" />
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="text-right">
                                    <input type="submit"  class="btn btn-info mt-3"  value="Save Indent"/>
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
@endsection
