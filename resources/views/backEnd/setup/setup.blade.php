@extends('backEnd.master')
@section('mainContent')
@if (!$setup)
    <div class="card">
        <div class="card-header">
            <h5>Add Setup</h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'action' => 'ErpSetupController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            <div class="form-group col-md-6">
                <label for="project_name">Company Name:</label>
                @if ($errors->has('company_name'))
                    <span class="messages" style="padding-left: 10px;color: darkred"><strong>{{ $errors->first('company_name') }}</strong></span>
                @endif
                <input type="text" class="form-control" name="company_name"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Address:</label>
                @if ($errors->has('address'))
                    <span class="messages" style="padding-left: 10px;color: darkred"><strong>{{ $errors->first('address') }}</strong></span>
                @endif
                <input type="text" class="form-control" name="address"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Phone:</label>
                @if ($errors->has('phone'))
                    <span class="messages" style="padding-left: 10px;color: darkred"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
                <input type="number" class="form-control" name="phone"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Email:</label>
                @if ($errors->has('email'))
                    <span class="messages" style="padding-left: 10px;color: darkred"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
                <input type="email" class="form-control" name="email"/>
            </div>
            <div class="form-group col-md-6">
                <label for="project_name">Logo:</label>
                @if ($errors->has('logo'))
                    <span class="messages" style="padding-left: 10px;color: darkred"><strong>{{ $errors->first('logo') }}</strong></span>
                @endif
                <input type="file" name="logo" class="form-control">

            </div>
            <br>
            <div class="form-group col-md-6">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary m-b-0">Set Up</button>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>

@else
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text">Setup Details</h5>
        </div>
        <div class="card-block">
            <div class="row col-md-6">
                @if( isset($setup->logo) )
                    <img src="{{ URL::to('/') }}/public/uploads/setup/{{$setup->logo}}" class="img-fluid mCS_img_loaded" height="10" width="150"/>
                @else
                    <img src="{{ asset('/public/images/no_image.png') }}" class="img-fluid mCS_img_loaded" height="10" width="150"/>
                @endif
            </div>

            <br> <br> <br>

            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="view-info">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="general-info">
                                    <div class="row">
                                        <div class="col-lg-12 ">
                                            <div class="table-responsive">
                                                <table class="table m-0">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Company Name:</th>
                                                            <td>{{$setup->company_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Address:</th>
                                                            <td>{{$setup->address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Phone No:</th>
                                                            <td>0{{$setup->phone}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email:</th>
                                                            <td>{{$setup->email}}</td>
                                                        </tr>
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
        </div>
        <div class="row">
{{--            <div class="form-group col-md-1 col-sm-1">--}}
{{--            </div>--}}
           @can('Add/Edit Setup')
                <div class="form-group col-md-4 pl-4">
                    <a href="{{route('setup.edit')}}"> <input type="button" class="btn btn-info" value="Edit"/></a>
                </div>
            @endcan
        </div>
    </div>
@endif
@endSection

