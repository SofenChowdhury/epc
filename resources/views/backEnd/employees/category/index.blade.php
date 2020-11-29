@extends('backEnd.master')
@section('mainContent')
<div class="row">
    <div class="col-md-4">
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
            @can('Add/Edit Category')
        <div class="card">
            <div class="card-header">
                <h5>Add New Employee Category</h5>
            </div>
            <div class="card-block">
                @if(isset($editData))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'employee-category/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                @else
                {{ Form::open(['class' => '', 'files' => true, 'url' => 'employee-category',
                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                @endif
                @if(!isset($editData))
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label"><span class="important">*</span> Category ID</label>
                            <input type="text" class="form-control {{ $errors->has('category_given_id') ? ' is-invalid' : '' }}" name="category_given_id" id="category_given_id" value="{{isset($editData)? $editData->given_id : old('category_given_id') }}">
                            <p style="color: darkred">Maximum 50 characters</p>
                            @if ($errors->has('category_given_id'))
                            <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('category_given_id') }}</strong></span>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label"><span class="important">*</span> Employee Category Name</label>
                            <input type="text" class="form-control {{ $errors->has('category_name') ? ' is-invalid' : '' }}" name="category_name" id="name" value="{{isset($editData)? $editData->category_name : old('category_name') }}">
                            <p style="color: darkred">Maximum 50 characters</p>
                            @if ($errors->has('category_name'))
                            <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('category_name') }}</strong></span>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label">Category Description (optional)</label>
                            <textarea class="form-control" name="description">{{ isset($editData)? $editData->description : old('description') }}</textarea>
                            <p style="color: darkred">Maximum 350 characters</p>
                            @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                            </span>
                            @endif
                        </div>
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
    </div>
    @can('View Category List')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Employee Category Lists</h5>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($employee_category))
                            @php $i = 1 @endphp
                            @foreach($employee_category as $value)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$value->given_id}}</td>
                                <td>{{$value->category_name}}</td>
                                <td>{{$value->description}}</td>
                                <td>
                                    @can('Add/Edit Category')
                                    <a href="{{url('employee-category/'.$value->id.'/edit')}}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                    @endcan

                                    @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                    <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteEmployeeCategoryView', $value->id)}}">
                                        <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                    </a>
                                    @endif
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
        @endcan
</div>

@endSection
