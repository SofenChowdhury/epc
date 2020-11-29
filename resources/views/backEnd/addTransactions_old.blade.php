@extends('backEnd.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('public/assets/css/addTransaction.css')}}">
@endsection

@section('mainContent')
    <div class="card">
        <div class="card-header">
            Journal Voucher Entry
        </div>
        <div class="card-block">
            <form id="voucher-form" method="POST" action="{{route('addTransactions')}}">
                @csrf

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="transaction_date" class="col-form-label">Transaction date :</label>
                        <input type="" class="form-control datepicker" autocomplete="off" required id="transaction_date" name="transaction_date" value="{{ date('d-m-Y') }}"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="transaction_type" class="col-form-label">Reference No :</label>
                        <input type="text" class="form-control" required readonly value="{{$voucherNo}}" name="voucher_no"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="project" class="col-form-label">Select project (optional) :</label>
                        <select class="form-control js-example-basic-single col-sm-12" name="project" id="project">
                            <option disabled selected value="">Select a project</option>
                            @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="description" class="col-form-label">Description :</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm voucher-table">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col" width="35%">Account</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table">
                                    <td>
                                        <div class="form-group coa_category">
                                            <select class="form-control head-select js-example-basic-single" required name="coa_parent0">
                                                @if(isset($categories))
                                                    @foreach($categories as $category)
                                                    <optgroup label="{{$category->category_name}}">
                                                        @foreach($category->subCategoryAccounts as $subCategory)
                                                        <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{$subCategory->coa_name}}">
                                                            @foreach($subCategory->accounts as $child)
                                                                <option value="{{$child->id}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$child->coa_name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        @endforeach
                                                    </optgroup>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" value="0" required class="form-control debit-input input-debit0" name="debit0"/>
                                    </td>
                                    <td>
                                        <input type="number" value="0" required class="form-control credit-input input-credit0" name="credit0"/>
                                    </td>
                                    <td></td>
                                </tr>
                            <!-- <tr class="table">
                                <td>
                                    <div class="form-group coa_category">
                                        <select class="form-control head-select js-example-basic-single" required name="coa_parent1">
                                            @if(isset($categories))
                                                @foreach($categories as $category)
                                                    <optgroup label="{{$category->category_name}}">
                                                        @foreach($category->subCategoryAccounts as $subCategory)
                                                            <option value="{{$subCategory->id}}">{{$subCategory->coa_name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" value="0" required class="form-control debit-input input-debit1" name="debit1"/>
                                </td>
                                <td>
                                    <input type="number" value="0" required class="form-control credit-input input-credit1" name="credit1"/>
                                </td>
                                <td></td>
                            </tr> -->
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <div class="row">
                                        <input type="button" class="btn btn-info" id="addrow" value="Add new" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="transaction_type">Total Debit:</label>
                                        <input type="text" readonly class="form-control debit-total inline-input" value="0" name="total_debit"/>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label for="transaction_type">Total Credit:</label>
                                        <input type="text" readonly class="form-control credit-total inline-input" value="0" name="total_credit"/>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="totalRow" id="totalRow" value="0">
                                    <input type="submit" class="btn btn-info" value="Save" />
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')

    <script src="{{asset('public/js/addTransactions.js')}}"></script>

@endsection