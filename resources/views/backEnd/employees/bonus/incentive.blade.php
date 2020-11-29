<div>
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytasktab">
                        <li class="nav-item">
                            <a class="nav-link active tab_style" data-toggle="tab" href="#add_bonus" role="tab">Add Employee Incentive</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#bonus_list" role="tab">Employee Incentive List</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="add_bonus" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Incentive</h5>
                            </div>
                            <div class="card-block">
                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'addBonus', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="employee_id"><span class="important">*</span> Employee Name : </label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('employee_id') ? ' is-invalid' : '' }}" name="employee_id" id="bonus_employee_id">
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
                                        <label for="bonus_title">Incentive Title :</label>
                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('bonus_title') ? ' is-invalid' : '' }}" name="bonus_title">
                                            <option value="">Select Incentive Title </option>
                                            @foreach($incentives as $incentive)
                                                <option value="{{ $incentive->incentive_name }} {{ old('bonus_title') == $incentive->incentive_name ? 'selected' : '' }}">{{ $incentive->incentive_name }}</option>
                                            @endforeach
                                            <option value="Other">Other </option>
                                        </select>
                                        {{--                                    <input type="text" class="form-control {{ $errors->has('bonus_title') ? ' is-invalid' : '' }}" value="{{ old('bonus_title') }}" name="bonus_title"/>--}}
                                        @if ($errors->has('bonus_title'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('bonus_title') }}</strong></span></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="amount"><span class="important">*</span> Amount :</label>
                                        <input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}" name="amount" id="bonus_amount"/>
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('amount') }}</strong></span></span>
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
                    <div class="tab-pane" id="bonus_list" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Employee Incentive</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table id="basic-btn" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Empployee ID</th>
                                            <th>Employee Name</th>
                                            <th>Incentive Title</th>
                                            <th>Amount</th>
                                            <th>Comment</th>
                                            <th>Added By</th>
                                            <th>Added On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($employee_incentives))
                                            @php $i = 1 @endphp
                                            @foreach($employee_incentives as $incentive)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $incentive->employee->unique_id }}</td>
                                                    <td>{{ $incentive->employee->first_name . ' ' . $incentive->employee->last_name }}</td>
                                                    <td>{{ $incentive->bonus_title }}</td>
                                                    <td>{{ $incentive->amount }}</td>
                                                    <td>{{ $incentive->description }}</td>
                                                    <td>{{ $incentive->creator->name }}</td>
                                                    <td>{{ date('d F, Y', strtotime($incentive->created_at)) }}</td>
                                                    <td>
                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteBonusView',$incentive->id)}}">
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

