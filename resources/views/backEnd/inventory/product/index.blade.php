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
        @can('Add Product')
            <div class="card">
                <div class="card-header">
                    <h5>Add Product</h5>
                </div>
                <div class="card-block">
                    @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'product/'.$editData->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                    @else
                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'product',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                    @endif
                        <input type="text" hidden name="product_type" value="{{ $type }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label"><span class="important">*</span> Product Name</label>
                                <input type="text" class="form-control {{ $errors->has('product_name') ? ' is-invalid' : '' }}" name="product_name" value="{{isset($editData)? $editData->product : old('product_name') }}">
                                <p style="color: darkred">Maximum 100 characters</p>
                                @if ($errors->has('product_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <span class="messages"><strong>{{ $errors->first('product_name') }}</strong></span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($type == 0)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="unit">Unit </label>
                                <input type="text" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}" value="{{isset($editData)? $editData->unit : old('unit') }}" name="unit"/>
                                @if ($errors->has('unit'))
                                    <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group col-md-12">
                            <label for="description">Description </label>
                            <textarea class="form-control" name="description">{{isset($editData)? $editData->description : old('description') }}</textarea>
                            <p style="color: darkred">Maximum 350 characters</p>
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
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Products List</h5>
                <a href="{{ url('assets/printList') }}" style="padding: 6px 12px; margin-top: 10px; color: white;float: right" class="btn btn-success"> Print List</a>
            </div>
            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Product Name</th>
                            @if($type == 0)
                                <th>Unit</th>
                            @endif
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($products))
                            @php $i = 1 @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$product->product}}</td>
                                    @if($type == 0)
                                        <td>{{$product->unit}}</td>
                                    @endif
                                    <td>{{$product->description}}</td>
                                    <td>
                                        <a href="{{url('product/'.$product->id.'/edit')}}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                        @role('Super Admin')
                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteProductView', $product->id)}}">
                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                        </a>
                                        @endrole
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

@endSection
