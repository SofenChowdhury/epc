@extends('backEnd.master')
@section('mainContent')
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
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-block">
                        @can('Add Employee Salary Divisions')
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add Salary Division</h5>
                                </div>
                                <div class="card-block">
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'salaryDivision', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" required>
                                                <option value="">Select Employee </option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ( $errors->has('employee_id') )
                                                <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span></span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="project_id"><span class="important">*</span>  Project Name</label><br>
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

                                        <div class="form-group col-md-2">
                                            <label for="project_hours"><span class="important">*</span> Project Hours </label>
                                            <input type="number" class="form-control {{ $errors->has('project_hours') ? ' is-invalid' : '' }}" value="{{ old('project_hours') }}" name="project_hours" required/>
                                            @if ($errors->has('project_hours'))
                                                <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_hours') }}</strong></span></span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total_hours"><span class="important">*</span> Total Hours </label>
                                            <input type="number" class="form-control {{ $errors->has('total_hours') ? ' is-invalid' : '' }}" value="{{ old('total_hours') }}" name="total_hours" required/>
                                            @if ($errors->has('total_hours'))
                                                <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('total_hours') }}</strong></span></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                        </div>
                                    </div>
                                    {{ Form::close()}}
                                </div>
                            </div>
                        @endcan

                        <div class="card">
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="basic-btn3" class="table table-striped table-bordered show_table">
                                        <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Empployee ID</th>
                                            <th>Employee Name</th>
                                            <th>Project Name</th>
                                            <th>Project Hours</th>
                                            <th>Total Hours</th>
                                            <th>Added By</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($divisions))
                                            @php $i = 1 @endphp
                                            @foreach($divisions as $division)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $division->employee->unique_id }}</td>
                                                    <td>{{ $division->employee->first_name . ' ' . $division->employee->last_name }}</td>
                                                    <td>
                                                        @if($division->project_id)
                                                            {{ $division->project->project_name }}
                                                        @else
                                                            Head Office
                                                        @endif
                                                    </td>
                                                    <td>{{ $division->project_hours }} hrs</td>
                                                    <td>{{ $division->total_hours }} hrs</td>
                                                    <td>{{ $division->creator->name }}
                                                        (<span>{{ $division->created_by }}</span>)
                                                    </td>
                                                    <td>
                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteSalaryDivisionView',$division->id)}}">
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
@endSection
