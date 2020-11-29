@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="row">
            <div class="col-xl-3">
                <div class="card-block">
                    <div class="card user-card">
                        <div class="card-header-img">
                            @if( isset($editData->employee_photo) )
                                <img class="img-fluid img-radius" style="margin-top: 20px;" src="{{ asset($editData->employee_photo) }}" alt="card-img">
                            @else
                                <img class="img-fluid img-radius" src="{{ asset('/public/images/no_image.png') }}" alt="card-img">
                            @endif

                            @if( isset($editData->first_name) )
                                <h4>{{ $editData->first_name.' '.$editData->last_name}}</h4>
                            @else
                                <h4>No Name</h4>
                            @endif

                            @if( isset($editData->unique_id) )
                                <h4>{{ $editData->unique_id }}</h4>
                            @else
                                <h4>no unique id</h4>
                            @endif

                            <!-- @if( isset($editData->email) )
                                <h5>{{ $editData->email }}</h5>
                            @else
                                <h5>No Email</h5>
                            @endif -->

                            @if( isset($editData->department_id))
                                <h5>{{ $editData->department->department_name }}</h5>
                            @else
                                <h5>No input given</h5>
                            @endif

                            @if( isset($editData->designation_id))
                                <h5>{{ $editData->designation->designation_name }}</h5>
                            @else
                                <h5>No Designation</h5>
                            @endif

                            @if( isset($editData->employee_type))
                                <h5>{{ $editData->type->type_name }}</h5>
                            @else
                                <h5>No input given</h5>
                            @endif
                        </div>
                        <br>
                    </div>
                </div> 
                <div class="  text-center">
                    <a class="" title="Back" href="{{ route('employee.edit',$editData->id) }}">
                        <button type="button" class="btn btn-primary m-b-0">Back</button>
                    </a>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card-block">
                    <div class="card-header">
                        <h5>Salary Details</h5>
                    </div>
                    <div id="app">
                        <app-salary :employee-id={{$id}}> </app-salary>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
