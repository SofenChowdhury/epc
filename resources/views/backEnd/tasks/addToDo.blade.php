@extends('backEnd.master')
@section('mainContent')
<div class="card">
    <div class="card-header">
        @if(isset($editData))
            <h5>Edit Reminder : {{ $editData->task_group }} </h5>
        @else
            <h5>Add Reminder for Project : {{ $project->project_name}} </h5>
        @endif
    </div>
    <div class="card-block">
        @if(isset($editData))
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'updateToDo/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
        @else
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'saveToDo','method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        @endif
        @csrf

        @if(!isset($editData))
            @if(isset($project))
            <div class="row">
                <div >
                    <input type="text" hidden name="project_id" value="{{ $project->id }}">
                </div>
            </div>
            @endif
        @endif

        <div class="row">
            <div class="form-group col-md-6">
                <label for="project_phase"><span class="important">*</span> Project Phase :</label>
                <select class="js-example-basic-single col-sm-12 {{ $errors->has('project_phase') ? ' is-invalid' : '' }}" name="project_phase" id="project_phase">
                @if(isset($phases))
                    @foreach($phases as $phase)
                    <option value="{{$phase->defined_id}}"
                        @if(isset($project))
                            @if($project->project_phase == $phase->defined_id) selected @endif
                        @endif
                        @if(isset($editData))
                            @if($editData->project_phase == $phase->defined_id) selected @endif
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
                <label for="status"><span class="important">*</span> Status :</label>
                <select class="js-example-basic-single col-sm-12 {{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" id="status" required>
                    <option value="">Select Status</option>
                    <option value="pending"
                        @if(isset($editData))
                            @if($editData->status == "pending") selected @endif
                        @endif>
                        Pending
                    </option>
                    <option value="urgent"
                        @if(isset($editData))
                            @if($editData->status == "urgent") selected @endif
                        @endif>
                        Urgent
                    </option>
                    <option value="remind"
                        @if(isset($editData))
                            @if($editData->status == "remind") selected @endif
                        @endif>
                        Remind
                    </option>
                </select>
                @if ($errors->has('status'))
                <span class="invalid-feedback invalid-select" role="alert">
                    <strong class="messages">{{ $errors->first('status') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group col-md-3">
                <label for="due_date">Due Date :</label>
                <input type="" class="form-control datepicker {{ $errors->has('due_date') ? ' is-invalid' : '' }}" value="{{ isset($editData)? $editData->due_date : old('due_date') }}" name="due_date" autocomplete="off"/>
                @if ($errors->has('due_date'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('due_date') }}</strong></span>
                    </span>
                @endif
            </div>

        </div>

        <div class="row">

            <div class="form-group col-md-6">
                <label for="task_group" class="col-form-label">Task Group</label>
                <input type="text" class="form-control {{ $errors->has('task_group') ? ' is-invalid' : '' }}" name="task_group" id="task_group" placeholder="" value="{{ isset($editData)? $editData->task_group : old('task_group') }} ">
                @if ( $errors->has('task_group') )
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('task_group') }}</strong></span>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="task" class="col-form-label">Task </label>
                <input type="text" class="form-control {{ $errors->has('task') ? ' is-invalid' : '' }}" name="task" id="task" placeholder="" value="{{ isset($editData)? $editData->task : old('task') }} ">
                @if ($errors->has('task'))
                    <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('task') }}</strong></span>
                    </span>
                @endif
            </div>

        </div>

        <div class="form-group row mt-5">
            <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                @if(isset($editData))
                <a class="" title="Back" href="{{url('/project',$editData->project_id)}}">
                @else
                <a class="" title="Back" href="{{url('/project',$project->id)}}">
                @endif
                    <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                </a>
            </div>
            <div class="col-sm-6 text-center">
                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
        {{ Form::close()}}
    </div>
</div>

@endSection
