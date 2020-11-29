<div>
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active tab_style" data-toggle="tab" href="#add_conveyance" role="tab">Add Employee Conveyance</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#conveyance_list" role="tab">Employee Conveyance List</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="add_conveyance" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Conveyance</h5>
                            </div>
                            <div class="card-block">
                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'addConveyancePay', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="conveyance_employee_id">
                                            <option value="">Select Employee </option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }} {{ old('employee_id') == $employee->id ? 'selected' : '' }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ( $errors->has('employee_id') )
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span></span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="conveyance_id"><span class="important">*</span> Conveyance Schedule :</label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('conveyance_id') ? ' is-invalid' : '' }}" name="conveyance_id">
                                            <option value="">Select Conveyance Schedule </option>
                                            @if(isset($conveyances))
                                                @foreach($conveyances as $conveyance)
                                                    <option value="{{ $conveyance->id }} {{ old('conveyance_id') == $conveyance->id ? 'selected' : '' }}">{{ $conveyance->destination }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('conveyance_id'))
                                            <span class="invalid-feedback" role="alert" >
                                            <span class="messages"><strong>{{ $errors->first('conveyance_id') }}</strong></span>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="project_id"> Project Name</label><br>
                                        <select class="js-example-basic-single  {{ $errors->has('project_id') ? ' is-invalid' : '' }}" name="project_id" id="project_id">
                                            <option value="0" {{ old('project_id')== 0 ? 'selected' : ''  }}>Head Office</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id')== $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('project_id'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_id') }}</strong></span></span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="amount">Amount :</label>
                                        <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" name="amount" id="overtime_amount"/>
                                        <p style="color: darkred">Only input if amount is different from conveyance schedule</p>
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('amount') }}</strong></span></span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="pay_date"><span class="important">*</span> Date :</label>
                                        <input type="" class="form-control datepicker {{ $errors->has('pay_date') ? ' is-invalid' : '' }}" value="{{ old('pay_date') }}" name="pay_date"/>
                                        @if ( $errors->has('pay_date') )
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('pay_date') }}</strong></span></span>
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
                    <div class="tab-pane" id="conveyance_list" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Conveyance</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="basic-btn3" class="table table-striped table-bordered show_table">
                                        <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Empployee ID</th>
                                            <th>Employee Name</th>
                                            <th>Project Name</th>
                                            <th>Conveyance Title</th>
                                            <th>Payment Date</th>
                                            <th>Amount</th>
                                            <th>Comment</th>
                                            <th>Added By</th>
                                            <th>Added On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($employee_conveyances))
                                            @php $i = 1 @endphp
                                            @foreach($employee_conveyances as $conveyance)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $conveyance->employee->unique_id }}</td>
                                                    <td>{{ $conveyance->employee->first_name . ' ' . $conveyance->employee->last_name }}</td>
                                                    <td>
                                                        @if($conveyance->project_id)
                                                            {{ $conveyance->project->project_name }}
                                                        @else
                                                            Head Office
                                                        @endif
                                                    </td>
                                                    <td>{{ $conveyance->conveyance->destination }}</td>
                                                    <td>{{ date('d F, Y', strtotime($conveyance->pay_date)) }}</td>
                                                    <td>
                                                        @if($conveyance->amount == null)
                                                            {{ $conveyance->conveyance->rate }}
                                                        @else
                                                            {{ $conveyance->amount }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $conveyance->description }}</td>
                                                    <td>{{ $conveyance->creator->name }}</td>
                                                    <td>{{ date('d F, Y', strtotime($conveyance->created_at)) }}</td>
                                                    <td>
                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteConveyanceView',$conveyance->id)}}">
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
