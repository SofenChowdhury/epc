<div class="tab-pane" id="materials" role="tabpanel">
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                @if($editData->project_phase >= 3)
                    <div class="tab-header card">
                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="myinnertab">
                            @can('view Project Employee List')
                                <li class="nav-item">
                                    <a class="nav-link active tab_style" data-toggle="tab" href="#products" role="tab">Consumables</a>
                                    <div class="slide"></div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab_style" data-toggle="tab" href="#assets" role="tab">Assets</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endif

                <div class="tab-content">
                    <div class="tab-pane active" id="products" role="tabpanel">
                        <div class="logo row" id="logo" style="display:none;">
                            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                            </div>
                            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Project Material Details</p>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                <br>
                            </div>
                            <div class="card-block">
                                <div class="card">
                                    <div class="card-block">
                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/material/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="row col-md-12">
                                                <div class="col-md-3">
                                                    <label for="product"><strong> Product Name:</strong></label>
                                                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('product') ? ' is-invalid' : '' }}" name="product" id="product">
                                                        <option value="">Select Product</option>
                                                        @if(isset($products))
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}"  {{ old('product')== $product->product ? 'selected' : ''  }}>{{ $product->product }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="quantity"><strong>Quantity:</strong></label>
                                                    <input type="number" step="0.01" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity" required />
                                                    @if ($errors->has('quantity'))
                                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span></span>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="description"><strong>Remark:</strong></label>
                                                    <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description"  />
                                                    <p style="color: darkred">Maximum 150 characters</p>
                                                    @if ($errors->has('description'))
                                                        <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="collapse row col-md-12" id="add_prod">
                                                @for($i=1; $i<=4; $i++)
                                                    <div class="row col-md-12">
                                                        <div class="form-group col-md-3">
                                                            <label for="product"><strong> Product Name:</strong></label>
                                                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('product') ? ' is-invalid' : '' }}" name="product_{{$i}}" id="product">
                                                                <option value="">Select Product</option>
                                                                @if(isset($products))
                                                                    @foreach($products as $product)
                                                                        <option value="{{ $product->id }}"  {{ old('product')== $product->product ? 'selected' : ''  }}>{{ $product->product }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="quantity"><strong>Quantity:</strong></label>
                                                            <input type="number" step="0.01" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity_{{$i}}"/>
                                                            @if ($errors->has('quantity'))
                                                                <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span></span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="description"><strong>Remark:</strong></label>
                                                            <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description_{{$i}}"/>
                                                            <p style="color: darkred">Maximum 150 characters</p>
                                                            @if ($errors->has('description'))
                                                                <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>

                                            <div class="form-group row col-md-12">
                                                <div class="col-md-2">
                                                    <label for="add"></label>
                                                    <a href="#add_prod" class="form-control btn btn-primary m-b-0 collapsible" data-toggle="collapse" style="margin-top: 5px; color: white;">Add Row</a>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="submit"></label>
                                                    <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close()}}
                                    </div>
                                </div>

                                <div class="card" id="project_products">
                                    <div class="logo row" id="logo" style="display:none;">
                                        <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                                        </div>
                                        <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                            <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Project Employees List</p>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        @if(isset($distinct_material_phase))
                                            @foreach( $distinct_material_phase as $distinct_phase)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <strong>
                                                            @foreach($phases as $phase)
                                                                @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                    PHASE - 00{{$phase->defined_id}} {{$phase->name}}
                                                                @endif
                                                            @endforeach
                                                        </strong>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table id="project_materials" class="table table-striped table-bordered project_materials">
                                                                <thead>
                                                                <tr>
                                                                    <th>SL.</th>
                                                                    <th>Product Name</th>
                                                                    <th>Quantity Required</th>
                                                                    <th>Quantity Sanctioned</th>
                                                                    <th>Unit</th>
                                                                    <th>Description</th>
                                                                    <th>Remark</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php $i = 1 @endphp
                                                                <!-- SHOW ALL MATERIALS OF THIS PROJECT -->
                                                                @foreach($editData->materials as $material)
                                                                    @if($material->project_phase == $distinct_phase->project_phase && isset($material->product_id) && $material->product->product_type == 0)
                                                                        <tr>
                                                                            <td> {{ $i++ }} </td>
                                                                            <td>
                                                                                @if(isset($material->product_id))
                                                                                    {{$material->product->product}}
                                                                                @endif
                                                                            </td>
                                                                            <td> {{ $material->quantity}}</td>
                                                                            <td> {{ $material->quantity_sanctioned}}</td>
                                                                            <td>
                                                                                @if(isset($material->product_id))
                                                                                    {{$material->product->unit}}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if(isset($material->product_id))
                                                                                    {{$material->product->description}}
                                                                                @endif
                                                                            </td>
                                                                            <td> {{ $material->description }}</td>
                                                                            @if(isset($material->reassign))
                                                                                <td style="color: #711c1c;">
                                                                                    Reassigned to <br>
                                                                                    @if($material->reassign == 0) Inventory
                                                                                    @elseif($material->reassign == 1) Project Client
                                                                                    @else {{ $material->ressigned->project_name }}
                                                                                    @endif
                                                                                </td>
                                                                            @else
                                                                                <td>
                                                                                    {{--EDIT MATERIAL--}}
                                                                                    <a href="#editMaterial" data-toggle="modal" data-target="#editMaterial_{{ $material->id}}" data-id="{{$material->id}}" >
                                                                                        <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                                                    </a>
                                                                                    <div class="modal fade" id="editMaterial_{{ $material->id}}" role="dialog" >
                                                                                        <div class="modal-dialog modal-lg">
                                                                                            <div class="modal-content col-md-12">
                                                                                                <div class="modal-header">
                                                                                                    @if( isset($material->product_name) )
                                                                                                        <h4 class="modal-title" style="color:#000000">{{ $material->product_name }}</h4>
                                                                                                    @endif
                                                                                                </div>
                                                                                                <div class="modal-body" >
                                                                                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/material_edit/'.$material->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                                                    <div class="col-md-8">
                                                                                                        <label for="quantity"><strong>Quantity:</strong></label>
                                                                                                        <input type="number" step="0.01" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $material->quantity }}" name="quantity" required />
                                                                                                        @if ($errors->has('quantity'))
                                                                                                            <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span></span>
                                                                                                        @endif
                                                                                                    </div>

                                                                                                    <div class="col-md-8">
                                                                                                        <label for="description"><strong>Description:</strong></label>
                                                                                                        <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $material->description }}" name="description"  />
                                                                                                        <p style="color: darkred">Maximum 150 characters</p>
                                                                                                        @if ($errors->has('description'))
                                                                                                            <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                                                                        @endif
                                                                                                    </div>

                                                                                                    <div class="col-md-2">
                                                                                                        <label for="submit"></label>
                                                                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                                                                    </div>
                                                                                                    {{ Form::close()}}
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    {{--END EDIT MATERIAL--}}
                                                                                    @role('Super Admin')
                                                                                    <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteProjectMaterialView', $material->id)}}">
                                                                                        <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                                                    </a>
                                                                                    @endrole
                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    {{--                <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">--}}
                                    {{--                    <div class="row">--}}
                                    {{--                        <div class="col">--}}
                                    {{--                            <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime1"> </p>--}}
                                    {{--                        </div>--}}
                                    {{--                    </div>--}}
                                    {{--                </div>--}}
                                </div>
                            </div>
                        </div>

                        <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                            <div class="row">
                                <div class="col">
                                    <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime2"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--// ASSETS TAB STARTS--}}
                    @if($editData->project_phase >= 3)
                        <div class="tab-pane" id="assets" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/material/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-6">
                                                        <label for="product"><strong> Product Name:</strong></label>
                                                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('product') ? ' is-invalid' : '' }}" name="product" id="product">
                                                            <option value="">Select Product</option>
                                                            @if(isset($assets))
                                                                @foreach($assets as $product)
                                                                    <option value="{{ $product->id }}"  {{ old('product')== $product->product ? 'selected' : ''  }}>{{ $product->product }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="description"><strong>Remark:</strong></label>
                                                        <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description"  />
                                                        <p style="color: darkred">Maximum 150 characters</p>
                                                        @if ($errors->has('description'))
                                                            <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="collapse row col-md-12" id="add_mat">
                                                    @for($i=1; $i<=4; $i++)
                                                        <div class="row col-md-12">
                                                            <div class="col-md-6">
                                                                <label for="product"><strong> Product Name:</strong></label>
                                                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('product') ? ' is-invalid' : '' }}" name="product_{{$i}}" id="product">
                                                                    <option value="">Select Product</option>
                                                                    @if(isset($assets))
                                                                        @foreach($assets as $product)
                                                                            <option value="{{ $product->id }}"  {{ old('product')== $product->product ? 'selected' : ''  }}>{{ $product->product }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="description"><strong>Remark:</strong></label>
                                                                <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}" name="description_{{$i}}"/>
                                                                <p style="color: darkred">Maximum 150 characters</p>
                                                                @if ($errors->has('description'))
                                                                    <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <div class="row col-md-12">
                                                    <div class=" col-md-2">
                                                        <label for="add"></label>
                                                        <a href="#add_mat" class="form-control btn btn-primary m-b-0 collapsible" data-toggle="collapse" style="margin-top: 5px; color: white;">Add Row</a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>

                                    <div class="card" id="project_assets">
                                        <div class="logo row" id="logo" style="display:none;">
                                            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                                            </div>
                                            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                                <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Project Employees List</p>
                                            </div>
                                        </div>

                                        <div class="card-block">
                                            @if(isset($distinct_material_phase))
                                                @foreach( $distinct_material_phase as $distinct_phase)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>
                                                                @foreach($phases as $phase)
                                                                    @if( $distinct_phase->project_phase == $phase->defined_id )
                                                                        PHASE - 00{{$phase->defined_id}} {{$phase->name}}
                                                                    @endif
                                                                @endforeach
                                                            </strong>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="table-responsive">
                                                                <table id="project_materials" class="table table-striped table-bordered project_materials">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>SL.</th>
                                                                        <th>Asset Number</th>
                                                                        <th>Product Name</th>
                                                                        <th>Quantity Required</th>
                                                                        <th>Quantity Sanctioned</th>
                                                                        <th>Description</th>
                                                                        <th>Remark</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @php $i = 1 @endphp
                                                                    <!-- SHOW ALL MATERIALS OF THIS PROJECT -->
                                                                    @foreach($editData->materials as $material)
                                                                        @if($material->project_phase == $distinct_phase->project_phase && isset($material->product_id) && $material->product->product_type == 1)
                                                                            <tr>
                                                                                <td> {{ $i++ }} </td>
                                                                                <td style="text-align: left">
                                                                                    @if(isset($material->inventory_id))
                                                                                        <a href="{{ url('single_account', $material->inventory->coa_id) }}" target="_blank">{{ $material->inventory->coa->coa_reference_no }}</a>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if(isset($material->product_id))
                                                                                        {{$material->product->product}}
                                                                                    @endif
                                                                                </td>
                                                                                <td> {{ $material->quantity}}</td>
                                                                                <td> {{ $material->quantity_sanctioned}}</td>
                                                                                <td>
                                                                                    @if(isset($material->product_id))
                                                                                        {{$material->product->description}}
                                                                                    @endif
                                                                                </td>
                                                                                <td> {{ $material->description }}</td>
                                                                                @if(isset($material->reassign))
                                                                                    <td style="color: #711c1c;">
                                                                                        Reassigned to <br>
                                                                                        @if($material->reassign == 0) Inventory
                                                                                        @elseif($material->reassign == 1) Project Client
                                                                                        @else {{ $material->ressigned->project_name }}
                                                                                        @endif
                                                                                    </td>
                                                                                @else
                                                                                    <td>
                                                                                        {{--EDIT MATERIAL--}}
                                                                                        <a href="#editMaterial" data-toggle="modal" data-target="#editMaterial_{{ $material->id}}" data-id="{{$material->id}}" >
                                                                                            <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                                                        </a>
                                                                                        <div class="modal fade" id="editMaterial_{{ $material->id}}" role="dialog" >
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content col-md-12">
                                                                                                    <div class="modal-header">
                                                                                                        @if( isset($material->product_name) )
                                                                                                            <h4 class="modal-title" style="color:#000000">{{ $material->product_name }}</h4>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div class="modal-body" >
                                                                                                        {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/material_edit/'.$material->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                                                        <div class="col-md-8">
                                                                                                            <label for="description"><strong>Description:</strong></label>
                                                                                                            <input type="text" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $material->description }}" name="description"  />
                                                                                                            <p style="color: darkred">Maximum 150 characters</p>
                                                                                                            @if ($errors->has('description'))
                                                                                                                <span class="invalid-feedback" role="alert"><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                                                                                                            @endif
                                                                                                        </div>

                                                                                                        <div class="col-md-2">
                                                                                                            <label for="submit"></label>
                                                                                                            <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                                                                        </div>
                                                                                                        {{ Form::close()}}
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{--END EDIT MATERIAL--}}

                                                                                        {{--ASSIGN MATERIAL--}}
                                                                                        @if(isset($material->coa_id))
                                                                                            {{--                                                        @if(isset($material->coa_id) && isset($editData->project_status) && $editData->project_status == 'completed')--}}
                                                                                            <a href="#assignMaterial" data-toggle="modal" data-target="#assignMaterial_{{ $material->id}}" data-id="{{$material->id}}" >
                                                                                                <button type="button" class="btn btn-success action-icon">Assign </button>
                                                                                            </a>
                                                                                            <div class="modal fade" id="assignMaterial_{{$material->id}}" role="dialog" >
                                                                                                <div class="modal-dialog modal-lg">
                                                                                                    <div class="modal-content col-md-12">
                                                                                                        <div class="modal-header">
                                                                                                            <h4 class="modal-title" style="color:#000000">
                                                                                                                @if(isset($material->product_name))
                                                                                                                    {{ $material->product_name }}
                                                                                                                @endif
                                                                                                            </h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body" >
                                                                                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/material_reassign/'.$material->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                                                                                            <div class="col-md-10">
                                                                                                                <label for="reassign">Reassign To</label><br>
                                                                                                                <select class="js-example-basic-single  {{ $errors->has('reassign') ? ' is-invalid' : '' }}" name="reassign" id="reassign">
                                                                                                                    <option value="0" {{ old('reassign')== 0 ? 'selected' : ''  }}>Back to Inventory</option>
                                                                                                                    <option value="1" {{ old('reassign')== 1 ? 'selected' : ''  }}>Back to Client</option>
                                                                                                                    @foreach($all_projects as $project)
                                                                                                                        <option value="{{ $project->id }}" {{ old('reassign')== $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="col-md-2">
                                                                                                                <label for="submit"></label>
                                                                                                                <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 2em; margin-bottom: 2em" />
                                                                                                            </div>
                                                                                                            {{ Form::close()}}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                        {{--END ASSIGN MATERIAL--}}
                                                                                        @role('Super Admin')
                                                                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteProjectMaterialView', $material->id)}}">
                                                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                                                        </a>
                                                                                        @endrole
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime1"> </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--// ASSETS TAB ENDS--}}
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $('.project_materials').DataTable();
</script>
