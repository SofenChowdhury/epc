<div>
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active tab_style" data-toggle="tab" href="#add_advance" role="tab">Add Employee Advance</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#advance_list" role="tab">Employee Advance List</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="add_advance" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Advance</h5>
                            </div>
                            <div class="card-block">
                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'addAdvance', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="advance_employee_id">
                                            <option value="">Select Employee </option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ( $errors->has('employee_id') )
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span></span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="amount">Amount :</label>
                                        <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" name="amount" id="advance_amount"/>
                                        <p style="color: darkred">Cannot exceed employee's 1 month's salary</p>
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('amount') }}</strong></span></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="repay_duration">Repay Duration (No. of Months):</label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('repay_duration') ? ' is-invalid' : '' }}" name="repay_duration">
                                            <option value="">Select Duration </option>
                                            <option value="3">3 months </option>
                                            <option value="6">6 months </option>
                                            <option value="9">9 months </option>
                                            <option value="12">12 months </option>
                                        </select>
                                        @if ($errors->has('repay_duration'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('repay_duration') }}</strong></span></span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="description">Comments :</label>
                                        <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                        @if ( $errors->has('description') )
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-5">
                                    <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                                        <a class="" title="cancel" href="{{url('/employee')}}">
                                            <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                                        </a>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="advance_list" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Advance</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="basic-btn1" class="table table-striped table-bordered show_table">
                                        <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Empployee ID</th>
                                            <th>Employee Name</th>
                                            <th>Amount</th>
                                            <th>Repay Duration</th>
                                            <th>Monthly Repay Amount</th>
                                            <th>Repay Start Month</th>
                                            <th>Repay End Month</th>
                                            <th>Comment</th>
                                            <th>Added By</th>
                                            <th>Added On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($employee_advances))
                                            @php $i = 1 @endphp
                                            @foreach($employee_advances as $advance)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $advance->employee->unique_id }}</td>
                                                    <td>{{ $advance->employee->first_name . ' ' . $advance->employee->last_name }}</td>
                                                    <td>{{ $advance->amount }}</td>
                                                    <td>{{ $advance->repay_duration }} months</td>
                                                    <td>{{ $advance->monthly_repay }}</td>
                                                    <td>{{ date('F, Y', strtotime($advance->from_month)) }}</td>
                                                    <td>{{ date('F, Y', strtotime($advance->to_month)) }}</td>
                                                    <td>{{ $advance->description }}</td>
                                                    <td>{{ $advance->creator->name }}</td>
                                                    <td>{{ date('d F, Y', strtotime($advance->created_at)) }}</td>
                                                    <td>
                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteAdvanceView',$advance->id)}}">
                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                        </a>
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.show_table').DataTable();
</script>

