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

    <div class="card">
        <div class="card-header">
            <h5>EPC Documents</h5>
            @can( 'Upload Documents')
                <a href="#upload_document" class="btn btn-success collapsible" data-toggle="collapse" style="float: right; padding: 8px; color: white;">Upload Document</a>
            @endcan
        </div>
        @can('View Indent List')
            <div class="card-block">
                <div class="collapse" id="upload_document">
                    {{ Form::open(['class' => '', 'files' => true, 'action' => 'ErpDocumentsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                    {{csrf_field()}}
                    <div class="card">
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <div class="form-group row col-md-12">
                                    <div class="form-group col-md-6">
                                        <label for="document_name">Document Name:</label>
                                        <input type="text" class="form-control {{ $errors->has('document_name') ? ' is-invalid' : '' }}" value="{{ old('document_name') }}" name="document_name" required/>
                                        <p style="color: darkred">Maximum 100 characters</p>
                                        @if ($errors->has('document_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <span class="messages"><strong>{{ $errors->first('document_name') }}</strong></span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="upload_document">Upload Document</label>
                                        <input class="form-control" type="file" name="upload_document" id="upload_document" required>
                                        <p style="color: darkred">Only .pdf, .jpg, .jpeg, .png files allowed</p>
                                        @if ($errors->has('upload_document'))
                                            <span class="invalid-feedback" role="alert" >
                                                <span class="messages"><strong>{{ $errors->first('upload_document') }}</strong></span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row col-md-12">
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description" ></textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert" >
                                                <span class="messages"><strong>{{ $errors->first('description') }}</strong></span>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row col-md-12">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close()}}
                </div>
                <div class="table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1 @endphp

                        <!-- SHOW ALL DOCUMENTS UPLOADED -->
                        @foreach($documents as $document)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $document->document_name }}</td>
                                <td>{{ $document->description }}</td>
                                <td><a href="{{url('document/read/'.$document->id)}}" target="_blank">
                                        <button type="button" class="btn btn-sm"
                                                style="background-color: lightgrey; border: 1px solid black; font-size: 1.05em;">
                                            Read File
                                        </button>
                                        @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                            <a class="modalLink" title="Delete" data-modal-size="modal-md"
                                               href="{{url('deleteDocument', $document->id)}}">
                                                <button type="button" class="btn btn-danger action-icon"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </a>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
    </div>
@endSection
