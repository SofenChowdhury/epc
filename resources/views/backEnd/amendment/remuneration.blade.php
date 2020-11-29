@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/employee/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            {{csrf_field()}}

            <input type="hidden" name="amendment" value="{{$maxAmendment+1}}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="title"><strong>Amendment No:</strong></label>
                    <input type="text" class="form-control {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                           value="{{$maxAmendment+1}}"  disabled/>
                    @if ($errors->has('amendment'))
                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('amendment') }}</strong></span>
                                                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group row col-md-12">
                    <div class="form-group col-md-3">
                        <label for="employee"><strong> Employee Name:</strong></label>
                        <select
                            class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}"
                            name="employee" id="employee">
                            <option value="">Select Employee</option>
                            @if(isset($employees))
                                @foreach($employees as $employee)
                                    <option
                                        value="{{ $employee->id }}" {{ old('employee')== $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}}
                                        . {{$employee->first_name}} {{$employee->last_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="title"><strong>Position:</strong></label>
                        <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                               value="{{ old('title') }}" name="title"/>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('title') }}</strong></span>
                                                        </span>
                        @endif
                    </div>
                    @if($editData->project_phase < 3)
                        <div class="form-group col-md-3">
                            <label for="man_hour"><strong><span class="important">*</span> Man hour:</strong></label>
                            <input type="number" step="0.01"
                                   class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"
                                   value="{{ old('man_hour') }}" name="man_hour" required/>
                            @if ($errors->has('man_hour'))
                                <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('man_hour') }}</strong></span>
                                                            </span>
                            @endif
                        </div>
                    @else
                        <div class="form-group col-md-2">
                            <label for="staff_month_rate"><strong><span class="important">*</span> Staff Month
                                    Rate:</strong></label>
                            <input type="number" step="0.01"
                                   class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"
                                   value="{{ old('staff_month_rate') }}" name="staff_month_rate" required/>
                            @if ($errors->has('staff_month_rate'))
                                <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_rate') }}</strong></span>
                                                            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-2">
                            <label for="staff_month_proposal"><strong><span class="important">*</span> Staff
                                    month(Proposal):</strong></label>
                            <input type="number" step="0.01"
                                   class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"
                                   value="{{ old('staff_month_proposal') }}" name="staff_month_proposal" required/>
                            @if ($errors->has('staff_month_proposal'))
                                <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_proposal') }}</strong></span>
                                                            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-2">
                            <label for="staff_month_agreed"><strong><span class="important">*</span> Staff
                                    month(Agreed):</strong></label>
                            <input type="number" step="0.01"
                                   class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"
                                   value="{{ old('staff_month_agreed') }}" name="staff_month_agreed" required/>
                            @if ($errors->has('staff_month_agreed'))
                                <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('staff_month_agreed') }}</strong></span>
                                                            </span>
                            @endif
                        </div>


                    @endif
                </div>

                <div class="collapse row col-md-12" id="add_emp">
                    @for($i=1; $i<=4; $i++)
                        <div class="form-group row col-md-12">
                            <div class="form-group col-md-3">
                                <label for="employee"><strong> Employee Name:</strong></label>
                                <select
                                    class="js-example-basic-single col-sm-12 {{ $errors->has('employee') ? ' is-invalid' : '' }}"
                                    name="employee_{{$i}}" id="employee">
                                    <option value="">Select Employee</option>
                                    @if(isset($employees))
                                        @foreach($employees as $employee)
                                            <option
                                                value="{{ $employee->id }}" {{ old('employee')== $employee->id ? 'selected' : ''  }}>{{$employee->unique_id}}
                                                . {{$employee->first_name}} {{$employee->last_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="title"><strong>Position:</strong></label>
                                <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       value="{{ old('title') }}" name="title_{{$i}}"/>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                                        <span
                                                            class="messages"><strong>{{ $errors->first('title') }}</strong></span>
                                                    </span>
                                @endif
                            </div>

                            @if($editData->project_phase < 3)
                                <div class="form-group col-md-3">
                                    <label for="man_hour"><strong><span class="important">*</span> Man
                                            hour:</strong></label>
                                    <input type="number" step="0.01"
                                           class="form-control {{ $errors->has('man_hour') ? ' is-invalid' : '' }}"
                                           value="{{ old('man_hour') }}" name="man_hour_{{$i}}"/>
                                    @if ($errors->has('man_hour'))
                                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('man_hour') }}</strong></span>
                                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="form-group col-md-2">
                                    <label for="staff_month_rate"><strong><span class="important">*</span> Staff Month
                                            Rate:</strong></label>
                                    <input type="number" step="0.01"
                                           class="form-control {{ $errors->has('staff_month_rate') ? ' is-invalid' : '' }}"
                                           value="{{ old('staff_month_rate') }}" name="staff_month_rate_{{$i}}"/>
                                    @if ($errors->has('staff_month_rate'))
                                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_rate') }}</strong></span>
                                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="staff_month_proposal"><strong><span class="important">*</span> Staff
                                            month(Proposal):</strong></label>
                                    <input type="number" step="0.01"
                                           class="form-control {{ $errors->has('staff_month_proposal') ? ' is-invalid' : '' }}"
                                           value="{{ old('staff_month_proposal') }}"
                                           name="staff_month_proposal_{{$i}}"/>
                                    @if ($errors->has('staff_month_proposal'))
                                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_proposal') }}</strong></span>
                                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="staff_month_agreed"><strong><span class="important">*</span> Staff
                                            month(Agreed):</strong></label>
                                    <input type="number" step="0.01"
                                           class="form-control {{ $errors->has('staff_month_agreed') ? ' is-invalid' : '' }}"
                                           value="{{ old('staff_month_agreed') }}" name="staff_month_agreed_{{$i}}"/>
                                    @if ($errors->has('staff_month_agreed'))
                                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('staff_month_agreed') }}</strong></span>
                                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="form-group row col-md-12">
                    <div class="form-group col-md-2">
                        <label for="add"></label>
                        <a href="#add_emp" class="form-control btn btn-primary m-b-0 collapsible" data-toggle="collapse"
                           style="margin-top: 5px; color: white;">Add Row</a>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="submit"></label>
                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;"/>
                    </div>
                </div>
            </div>

            {{ Form::close()}}
        </div>
    </div>
@endsection
