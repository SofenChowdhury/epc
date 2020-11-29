@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Edit Setup</h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'route' => ['setup.update', $profile->id],  'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            <div class="form-group col-md-6">
                <label for="project_name">Company Name:</label>
                <input  type="text" class="form-control" name="company_name" value="{{$profile->company_name}}"/>
            </div>

            <div class="form-group col-md-6">
                <label for="project_name">Address:</label>
                <input  type="text" class="form-control" name="address" value="{{$profile->address}}"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Phone:</label>
                <input  type="number" class="form-control" name="phone" value="{{$profile->phone}}"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Email:</label>
                <input  type="email" class="form-control" name="email" value="{{$profile->email}}"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Logo:</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <br>
            <div class="form-group col-md-6">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary m-b-0">Update Setup</button>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endSection
