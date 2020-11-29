@extends('backEnd.master')
@section('mainContent')
<div class="card">
    <div class="card-header">
        <h5 style="font-size: 0.8rem;">{{$editData->project_name }}</h5>
    </div>
    <div class="card-block">
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'project/updatePhase/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
        @csrf
        <div class="row">
            <div class="form-group col-md-3">
                <label for="project_code">Project ID :</label>
                <input type="text" readonly class="form-control  {{ $errors->has('project_code') ? ' is-invalid' : '' }}" value="{{ $editData->project_code }}" name="project_code" />
                @if ( $errors->has('project_code') )
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('project_code') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                <label for="project_phase"><span class="important">*</span> Phase :</label>
                <select class="js-example-basic-single col-sm-12" name="project_phase" id="project_phase" >
                    @if(isset($phases))
                        @foreach($phases as $phase)
                        <option value="{{$phase->defined_id}}"
                            @if(isset($editData))
                                @if($editData->project_phase == $phase->defined_id) selected @endif
{{--                                @if($phase->defined_id == $next_phase) selected @endif--}}
                            @endif
                            >-00{{$phase->defined_id}} {{$phase->name}}
                        </option>
                        @endforeach
                    @endif
                </select>
                @if ($errors->has('project_phase'))
                <span class="invalid-feedback invalid-select" role="alert">
                    <strong class="messages">{{ $errors->first('project_phase') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                <label for="status">Status :</label>
                <select class="js-example-basic-single col-sm-12 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" id="status">

                    @if(isset($statuses))
                        @foreach($statuses as $status)
                            @if($phase->defined_id>2)
                            <option value="{{$status->name}}"
                                    @if(isset($editData))
                                    @if($editData->project_status == $status->name) selected @endif
                                @endif
                            >{{ ucfirst($status->name) }}
                            </option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @if ($errors->has('status'))
                    <span class="invalid-feedback invalid-select" role="alert">
                    <strong class="messages">{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>

            @if($next_phase == 2)
            <div class="form-group col-md-3">
                <label for="rfp_no">RFP Identification No. :</label>
                <input type="" class="form-control  {{ $errors->has('rfp_no') ? ' is-invalid' : '' }}" value="{{ old('rfp_no') }}" name="rfp_no" />
                @if ($errors->has('rfp_no'))
                    <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('rfp_no') }}</strong></span>
                        </span>
                @endif
            </div>
{{--            @else--}}
{{--            <div class="form-group col-md-3">--}}
{{--                <label for="contract_no">Contract Number :</label>--}}
{{--                <input type="" class="form-control {{ $errors->has('contract_no') ? ' is-invalid' : '' }}" value="{{ $editData->contract_no ? $editData->contract_no : old('contract_no') }}" name="contract_no"/>--}}
{{--                @if ($errors->has('contract_no'))--}}
{{--                    <span class="invalid-feedback" role="alert" >--}}
{{--                        <span class="messages"><strong>{{ $errors->first('contract_no') }}</strong></span>--}}
{{--                    </span>--}}
{{--                @endif--}}
{{--            </div>--}}
            @endif
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                @foreach($phases as $phase)
                    @if($phase->defined_id == $next_phase)
                        <label for="phase_start_date">{{$phase->name}} Commencement Date :</label>
                    @endif
                @endforeach
{{--                <label for="phase_start_date">Phase Commencement Date :</label>--}}
                <input type="" class="form-control datepicker  {{ $errors->has('phase_start_date') ? ' is-invalid' : '' }}" value="{{ old('phase_start_date') }}" name="phase_start_date" />
                @if ($errors->has('phase_start_date'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('phase_start_date') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                @foreach($phases as $phase)
                    @if($phase->defined_id == $next_phase)
                        <label for="phase_start_date">{{$phase->name}} Submission Date :</label>
                    @endif
                @endforeach
{{--                <label for="phase_end_date">Phase Submission Date :</label>--}}
                <input type="" class="form-control datepicker  {{ $errors->has('phase_end_date') ? ' is-invalid' : '' }}" value="{{ old('phase_end_date') }}" name="phase_end_date"/>

                @if ($errors->has('phase_end_date'))
                    <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('phase_end_date') }}</strong></span>
                        </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                @foreach($phases as $phase)
                    @if($phase->defined_id == $next_phase)
                        <label for="phase_start_date">{{$phase->name}} Submission Time :</label>
                    @endif
                @endforeach
{{--                <label for="phase_end_time">Phase Submission Time :</label>--}}
                <input type="time" class="form-control {{ $errors->has('phase_end_time') ? ' is-invalid' : '' }}" value="{{ old('phase_end_time') }}" name="phase_end_time"/>
                @if ($errors->has('phase_end_time'))
                    <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('phase_end_time') }}</strong></span>
                        </span>
                @endif
            </div>
        </div>

        @if($next_phase == 2)
        <div class="row">
            <div class="form-group col-md-6">
                <label for="proposal_meeting_place">Pre-proposal Meeting Place :</label>
                <textarea class="form-control" name="proposal_meeting_place" id="">{{ old('proposal_meeting_place') }}</textarea>
{{--                    <input type="" class="form-control datepicker  {{ $errors->has('project_start_date') ? ' is-invalid' : '' }}" value="{{ old('project_start_date') }}" name="project_start_date" required/>--}}
                <p style="color: darkred">Maximum 250 characters</p>
                @if ($errors->has('proposal_meeting_place'))
                    <span class="invalid-feedback" role="alert" >
                    <span class="messages"><strong>{{ $errors->first('proposal_meeting_place') }}</strong></span>
                </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                <label for="meeting_date">Meeting Date :</label>
                <input type="" class="form-control datepicker  {{ $errors->has('meeting_date') ? ' is-invalid' : '' }}" value="{{ old('meeting_date') }}" name="meeting_date"/>
                @if ($errors->has('meeting_date'))
                    <span class="invalid-feedback" role="alert" >
                    <span class="messages"><strong>{{ $errors->first('meeting_date') }}</strong></span>
                </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                <label for="meeting_time">Meeting Time :</label>
                <input type="time" class="form-control {{ $errors->has('meeting_time') ? ' is-invalid' : '' }}" value="{{ old('meeting_time') }}" name="meeting_time"/>
                @if ($errors->has('meeting_time'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('meeting_time') }}</strong></span>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="proposal_validity">Proposal Validity Time :</label>
                <input type="text" class="form-control  {{ $errors->has('proposal_validity') ? ' is-invalid' : '' }}" value="{{ old('proposal_validity') }}" name="proposal_validity"/>
                @if ($errors->has('proposal_validity'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('proposal_validity') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="selection_method">Method of Selection :</label>
                <input type="text" class="form-control  {{ $errors->has('selection_method') ? ' is-invalid' : '' }}" value="{{ old('selection_method') }}" name="selection_method"/>
                @if ($errors->has('selection_method'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('selection_method') }}</strong></span>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="assign_name_1">Assignment Name 1 :</label>
                <input type="text" class="form-control  {{ $errors->has('assign_name_1') ? ' is-invalid' : '' }}" value="{{ old('assign_name_1') }}" name="assign_name_1"/>
                <p style="color: darkred">Maximum 150 characters</p>
                @if ($errors->has('assign_name_1'))
                    <span class="invalid-feedback" role="alert" >
                    <span class="messages"><strong>{{ $errors->first('assign_name_1') }}</strong></span>
                </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="assign_desc_1">Description :</label>
                <textarea class="form-control" name="assign_desc_1" id="">{{ old('assign_desc_1') }}</textarea>
                <p style="color: darkred">Maximum 350 characters</p>
                @if ($errors->has('assign_desc_1'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('assign_desc_1') }}</strong></span>
                    </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="assign_name_2">Assignment Name 2 :</label>
                <input type="text" class="form-control  {{ $errors->has('assign_name_2') ? ' is-invalid' : '' }}" value="{{ old('assign_name_2') }}" name="assign_name_2"/>
                <p style="color: darkred">Maximum 150 characters</p>
                @if ($errors->has('assign_name_2'))
                    <span class="invalid-feedback" role="alert" >
                    <span class="messages"><strong>{{ $errors->first('assign_name_2') }}</strong></span>
                </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="assign_desc_2">Description :</label>
                <textarea class="form-control" name="assign_desc_2" id="">{{ old('assign_desc_2') }}</textarea>
                <p style="color: darkred">Maximum 350 characters</p>
                @if ($errors->has('assign_desc_2'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('assign_desc_2') }}</strong></span>
                    </span>
                @endif
            </div>
        </div>
        @endif

        <div class="row">
            @if($next_phase == 3)
            <div class="form-group col-md-6">
                <label for="project_start_date">Project Commencement Date :</label>
                <input type="" class="form-control datepicker  {{ $errors->has('project_start_date') ? ' is-invalid' : '' }}" value="{{ old('project_start_date') }}" name="project_start_date" required/>
                @if ($errors->has('project_start_date'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('project_start_date') }}</strong></span>
                    </span>
                @endif
                <p style="color: firebrick; padding-top: 8px">(Total project duration)</p>
            </div>

            <div class="form-group col-md-6">
                <label for="project_end_date">Project Completion Date :</label>
                <input type="" class="form-control datepicker  {{ $errors->has('project_end_date') ? ' is-invalid' : '' }}" value="{{ old('project_end_date') }}" name="project_end_date"/>

                @if ($errors->has('project_end_date'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('project_end_date') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="project_amount">Actual Contract Amount (in BDT) :</label>
                <input type="number" step="0.01" class="form-control {{ $errors->has('project_amount') ? ' is-invalid' : '' }}" value="{{ old('project_amount') }}" name="project_amount"/>
                @if ($errors->has('project_amount'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('project_amount') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="tax_amount"> VAT/ Tax Amount (in BDT) :</label>
                <input type="number" step="0.01" class="form-control {{ $errors->has('tax_amount') ? ' is-invalid' : '' }}" value="{{ old('tax_amount') }}" name="tax_amount"/>
                @if ($errors->has('tax_amount'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('tax_amount') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="tax_by"> VAT/ Tax paid by :</label>
                <select class="js-example-basic-single col-sm-12 {{ $errors->has('tax_by') ? ' is-invalid' : '' }}" name="tax_by" id="tax_by">
                    <option value="Government">Government</option>
                    <option value="EPC">EPC</option>
                </select>
                @if ($errors->has('project_amount'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('project_amount') }}</strong></span>
                    </span>
                @endif
            </div>
            @endif

            <div class="form-group col-md-6">
                <label for="remark">Remarks :</label>
                <textarea class="form-control" name="remark" id="">{{ old('remark') }}</textarea>
                @if ($errors->has('remark'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('remark') }}</strong></span>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row mt-5">
            <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                <a class="" title="Back" href="{{ route('project.show',$editData->id) }}">
                    <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                </a>
            </div>
            <div class="col-sm-6 text-center">
                <button type="submit" class="btn btn-primary m-b-0">Update</button>
            </div>
        </div>
    {{ Form::close()}}
    </div>
</div>

@endSection


@section('javascript')
    <script type="text/javascript">
        // $('.clockpicker').clockpicker();

    {{--        var Dt = new Date();--}}
    {{--        $('#phase_end_time').clockpicker({autoclose: true,twelvehour: true}).val(moment(Dt.getTime()).format("HH:mm A"));--}}
    {{--//         $('#phase_end_time').pickatime({--}}
    {{--// // 12 or 24 hour--}}
    {{--//             twelvehour: true,--}}
    {{--//         });--}}
    </script>
@endsection
