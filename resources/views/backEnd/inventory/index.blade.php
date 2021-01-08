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
    <div class="tab-pane" id="contacts" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                @if($category != 1)
                    <div class="tab-header card">
                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                            @can('View Inventory')
                                <li class="nav-item">
                                    <a class="nav-link active tab_style" data-toggle="tab" href="#inventory" role="tab">Inventory List</a>
                                    <div class="slide"></div>
                                </li>
                            @endcan
                            @can('View Inventory')
                                <li class="nav-item">
                                    <a class="nav-link tab_style" data-toggle="tab" href="#assigned" role="tab">Inventory Assigned</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endif
                <div class="tab-content">
                    <div class="tab-pane active" id="inventory" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5>
                                    @if($category == 1)
                                        Inventory Products List
                                    @elseif($category == 2)
                                        Property, Plant and Equipments List
                                    @elseif($category == 3)
                                        Vehicles List
                                    @elseif($category == 4)
                                        Furniture List
                                    @endif
                                </h5>
                                <br>
                                <a href="{{ url('inventory/printList/'.$category) }}" style="padding: 6px 12px; margin-top: 10px; color: white;" class="btn btn-success"> Print Inventory</a>
                                @can('Add Inventory')
                                    <a href="{{ url('inventory/create/'.$category) }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add Inventory </a>
                                @endcan
                            </div>
                            @can('View Inventory')
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="basic-btn" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                @if($category != 1)
                                                    <th>Asset Number</th>
                                                @endif
                                                <th>Status</th>
                                                <th>Product Name</th>
                                                <th>Serial No</th>
                                                @if($category == 1)
                                                    <th>Unit</th>
                                                    <th>Quantity</th>
                                                @endif
                                                <th>Price</th>
                                                <th>Current Price</th>
                                                @if($category == 1)
                                                    <th>Total</th>
                                                @endif
                                                <th>Purchase Date</th>
                                                <th>Added By</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i = 1 @endphp
                                            @foreach($products as $product)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    @if($category != 1)
                                                        <td>
                                                            @if(isset($product->coa_id))
                                                                <a href="{{ url('single_account', $product->coa_id) }}">{{ $product->coa->coa_reference_no }}</a>
                                                            @endif
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if($product->status==0)
                                                            Sold
                                                        @else
                                                            Present
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(isset($product->product_id))
                                                            {{$product->product->product}}
                                                        @endif
                                                    </td>
                                                    <td>{{$product->serial_no}}</td>
                                                    @if($category == 1)
                                                        <td>
                                                            @if(isset($product->product_id)){{ $product->product->unit }}@endif
                                                        </td>
                                                        @if($product->quantity <= $product->min_amount)
                                                            <td style="color: red; font-weight: bold">
                                                        @else
                                                            <td>
                                                                @endif
                                                                {{$product->quantity}}
                                                            </td>
                                                        @endif
                                                        <td>{{ $product->price }}</td>
                                                        <td>
                                                            @if(isset($product->depreciations))
                                                                @if($product->depreciations->current_value ==null)
                                                                    {{ $product->price }}
                                                                @else

                                                                    {{$product->depreciations->current_value}}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        @if($category == 1)
                                                            <td>
                                                                @if($product->price && $product->quantity){{ $product->price * $product->quantity }}@endif
                                                            </td>
                                                        @endif
                                                        <td>{{ isset($product->purchase_date) ? date('d-M-Y', strtotime($product->purchase_date)) : ''}}</td>
                                                        <td>
                                                            @foreach($users as $userCreator)
                                                                @if( $product->created_by == $userCreator->id )
                                                                    {{$userCreator->name}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="#myModal" data-toggle="modal" data-target="#myModal_{{ $product->id}}" data-id="{{$product->id}}" >
                                                                <button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button>
                                                            </a>
                                                            <!-- Product Details Model -->
                                                            <div class="modal fade" id="myModal_{{ $product->id}}" role="dialog" >
                                                                <div class="modal-dialog modal-lg">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            @if( isset($product->product->product) )
                                                                                <h4 class="modal-title" style="color:#000000">{{ $product->product->product }}</h4>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-body" >
                                                                            <div class="table-responsive">
                                                                                <table class="table m-0">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <th scope="col">Product </th>
                                                                                        <td colspan="3">
                                                                                            @if(isset($product->product_id))
                                                                                                {{$product->product->product}}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Serial No</th>
                                                                                        <td>{{ $product->serial_no }}</td>

                                                                                        <th scope="row">Brand Name</th>
                                                                                        <td>{{ $product->brand_name }}</td>
                                                                                    </tr>
                                                                                    @if($category == 3)
                                                                                        <tr>
                                                                                            <th scope="row">Chasis Number</th>
                                                                                            <td>{{$product->chasis_no}}</td>

                                                                                            <th scope="row">CC</th>
                                                                                            <td>{{ $product->cc }}</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    @if($category != 1)
                                                                                        <tr>
                                                                                            <th scope="row">COA Reference No</th>
                                                                                            <td>
                                                                                                @if(isset($product->coa_id))
                                                                                                    {{ $product->coa->coa_reference_no }}
                                                                                                @endif
                                                                                            </td>
                                                                                            <th scope="row">Depreciation Rate</th>
                                                                                            <td>{{ $product->depreciation_rate }}%</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    <tr>
                                                                                        @if($category == 1)
                                                                                            <th scope="row">Unit</th>
                                                                                            <td>
                                                                                                @if(isset($product->product_id))
                                                                                                    {{$product->product->unit}}
                                                                                                @endif
                                                                                            </td>
                                                                                        @else
                                                                                            <th scope="row">Location
                                                                                            </th>
                                                                                            <td>{{ $product->location == 1 ? 'Head Office' : '' }}</td>
                                                                                        @endif
                                                                                        <th scope="row">Purchase Date
                                                                                        </th>
                                                                                        <td>{{ isset($product->purchase_date) ? $product->purchase_date : '' }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Quantity</th>
                                                                                        <td>{{ $product->quantity }}</td>

                                                                                        <th scope="row">Price (per
                                                                                            product)
                                                                                        </th>
                                                                                        <td>
                                                                                            Tk {{ $product->price }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Accumulated
                                                                                            depreciation (per product)
                                                                                        </th>
                                                                                        <td>
                                                                                            @if(isset($product->depreciations->accumulated_depreciation))
                                                                                                Tk {{$product->depreciations->accumulated_depreciation}}
                                                                                            @endif
                                                                                        </td>
                                                                                        <th scope="row">Current
                                                                                            Value(per product)
                                                                                        </th>
                                                                                        <td>
                                                                                            @if(isset($product->depreciations))
                                                                                                @if($product->depreciations->current_value ==null)
                                                                                                    {{ $product->price }}
                                                                                                @else

                                                                                                    {{$product->depreciations->current_value}}
                                                                                                @endif
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Vendor Name</th>
                                                                                        <td>
                                                                                            @if(isset($product->vendor_id))
                                                                                                {{ $product->vendor->vendor_name }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <th scope="row">Vendor Contact
                                                                                        </th>
                                                                                        <td>
                                                                                            @if(isset($product->vendor_id))
                                                                                                {{ $product->vendor->phone_number }}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Payment Method</th>
                                                                                        <td>
                                                                                            @if($product->payment_method==0)
                                                                                                By Cash
                                                                                            @elseif($product->payment_method==1)
                                                                                                By Cheque
                                                                                            @endif
                                                                                        </td>
                                                                                        @if($category == 1)
                                                                                            <th scope="row">Re-ordering notice</th>
                                                                                            <td>{{ $product->min_amount }}</td>
                                                                                        @else
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        @endif
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Added By</th>
                                                                                        @foreach($users as $user)
                                                                                            @if( $product->created_by == $user->id )
                                                                                                <td>{{ $user->name }}</td>
                                                                                            @endif
                                                                                        @endforeach

                                                                                        <th scope="row">Added At</th>
                                                                                        <td>{{ date('d-M-Y', strtotime($product->created_at)) }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Description</th>
                                                                                        <td colspan="3">{{ $product->description }}</td>
                                                                                    </tr>
                                                                                    @if(isset($product->upload_document))
                                                                                        <tr>
                                                                                            <th scope="row">Voucher</th>
                                                                                            <td colspan="3">
                                                                                                <a href="{{url('inventory/document/'.$product->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @can('Edit Inventory')
                                                                <a href="{{ route('inventory.edit',$product->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                                            @endcan
                                                            @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                                                <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteInventoryView', $product->id)}}">
                                                                    <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                                                </a>
                                                            @endif
                                                            @can('Assign Inventory')
                                                                <a href="#assignModal" data-toggle="modal" data-target="#assignModal_{{ $product->id}}" data-id="{{$product->id}}" >
                                                                    <button type="button" class="btn btn-success action-icon">Assign </button>
                                                                </a>
                                                            @endcan
                                                            <div class="modal fade" id="assignModal_{{ $product->id}}" role="dialog" >
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content form-group col-md-12">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" style="color:#000000">{{$product->product_name}}</h4>
                                                                        </div>
                                                                        <div class="modal-body" >
                                                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'inventory/assign/'.$product->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
{{--                                                                            @if($category != 1)--}}
                                                                                <div class="form-group col-md-10">
                                                                                    <label for="employee_id"> Assign To
                                                                                        Employee</label><br>
                                                                                    <select
                                                                                        class="js-example-basic-single {{ $errors->has('employee_id') ? ' is-invalid' : '' }}"
                                                                                        name="employee_id"
                                                                                        id="employee_id">
                                                                                        <option value="">Select
                                                                                            Employee
                                                                                        </option>
                                                                                        @foreach($employees as $employee)
                                                                                            <option
                                                                                                value="{{ $employee->id }}" {{ old('employee_id')== $employee->id ? 'selected' : ''  }} >
                                                                                                {{$employee->first_name}} {{$employee->last_name}}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @if ($errors->has('employee_id'))
                                                                                        <span class="invalid-feedback"
                                                                                              role="alert">
                                                                                        <span
                                                                                            class="messages"><strong>{{ $errors->first('employee_id') }}</strong></span>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
{{--                                                                            @endif--}}
                                                                            <div class="form-group col-md-10">
                                                                                <label for="project_id"> Assign Under
                                                                                    Project</label><br>
                                                                                <select
                                                                                    class="js-example-basic-single  {{ $errors->has('project_id') ? ' is-invalid' : '' }}"
                                                                                    name="project_id" id="project_id">
                                                                                    <option value="">Select Project
                                                                                    </option>
                                                                                    <option
                                                                                        value="0" {{ old('project_id')== 'head' ? 'selected' : ''  }}>
                                                                                        Head Office
                                                                                    </option>
                                                                                    @foreach($projects as $project)
                                                                                        <option
                                                                                            value="{{ $project->id }}" {{ old('project_id')== $project->id ? 'selected' : ''  }}>{{ $project->project_name }} </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if ($errors->has('project_id'))
                                                                                    <span class="invalid-feedback"
                                                                                          role="alert">
                                                                                    <span
                                                                                        class="messages"><strong>{{ $errors->first('project_id') }}</strong></span>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            @if($category == 3)
                                                                                <div class="form-group col-md-10">
                                                                                    <label for="driver"> Assign
                                                                                        Driver</label><br>
                                                                                    <select
                                                                                        class="js-example-basic-single {{ $errors->has('driver') ? ' is-invalid' : '' }}"
                                                                                        name="driver" id="driver">
                                                                                        <option value="">Select Driver
                                                                                        </option>
                                                                                        @foreach($employees as $employee)
                                                                                            <option value="{{ $employee->id }}"  {{ old('driver')== $employee->id ? 'selected' : ''  }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @if ($errors->has('driver'))
                                                                                        <span class="invalid-feedback" role="alert" >
                                                                                            <span class="messages"><strong>{{ $errors->first('driver') }}</strong></span>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            @endif
{{--                                                                            <div class="form-group col-md-10">--}}
{{--                                                                                <label for="indent_no"> Indent Number  </label>--}}
{{--                                                                                <input type="text" class="form-control {{ $errors->has('indent_no') ? ' is-invalid' : '' }}" value="{{ old('indent_no') }}" name="indent_no"/>--}}
{{--                                                                                @if ($errors->has('indent_no'))--}}
{{--                                                                                    <span class="invalid-feedback" role="alert" >--}}
{{--                                                                                    <span class="messages"><strong>{{ $errors->first('indent_no') }}</strong></span>--}}
{{--                                                                                </span>--}}
{{--                                                                                @endif--}}
{{--                                                                            </div>--}}
                                                                            <div class="form-group col-md-10">
                                                                                <label for="quantity"> Quantity  </label>
                                                                                <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity"/>
                                                                                @if ($errors->has('quantity'))
                                                                                    <span class="invalid-feedback" role="alert" >
                                                                                        <span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <input type="text" name="category" value="{{ $category }}" hidden>
                                                                            <div class="form-group col-md-2">
                                                                                <label for="submit"></label>
                                                                                <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                                            </div>
                                                                            {{ Form::close()}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                    @if($category != 1)
                        <div class="tab-pane" id="assigned" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        @if($category == 2)
                                            Assigned Property, Plant and Equipments List
                                        @elseif($category == 3)
                                            Assigned Vehicles List
                                        @elseif($category == 4)
                                            Assigned Furniture List
                                        @endif
                                    </h5>
                                    <br>
                                    <a href="{{ url('inventory/printAssignedList/'.$category) }}" style="padding: 6px 12px; margin-top: 10px; color: white;" class="btn btn-success"> Print List</a>
                                </div>
                                @can('View Inventory')
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table id="basic-btn1" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    @if($category != 3)
                                                        <th>Room Number</th>
                                                    @endif
                                                    <th>Asset Number</th>
                                                    <th>Issued To</th>
                                                    <th>Product Name</th>
                                                    <th>Serial No</th>
                                                    <th>Price</th>
                                                    <th>Current Value</th>
                                                    <th>Purchase Date</th>
                                                    <th>Added By</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php $i = 1; $total_price= 0;$total_current = 0; @endphp
                                                @if(isset($assigns))
                                                    @foreach($assigns as $assign)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            @if($category != 3)
                                                                <td>
                                                                    <a href="{{url('location/assets/'.$assign->room_no)}}" title="assets">{{ $assign->room->room_no }}</a>
                                                                </td>
                                                            @endif
                                                            <td>
                                                                @if(isset($assign->coa_id))
                                                                    <a href="{{ url('single_account', $assign->coa_id) }}">{{ $assign->coa->coa_reference_no }}</a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $get_emp = DB::table('erp_employee_materials')
                                                                        ->leftjoin('erp_employees','erp_employees.id','erp_employee_materials.employee_id')
                                                                        ->select('erp_employees.first_name','erp_employees.last_name','erp_employees.unique_id')
                                                                        ->where('coa_id',$assign->coa_id)
                                                                        ->first();
                                                                @endphp
                                                                @if($get_emp)
                                                                    {{ $get_emp->first_name }} {{ $get_emp->last_name }}
                                                                    <small>( {{ $get_emp->unique_id }} )</small>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($assign->product_id))
                                                                    {{$assign->product->product}}
                                                                @endif
                                                            </td>
                                                            <td>{{$assign->serial_no}}</td>
                                                            <td>{{ $assign->price }}</td>
                                                            @php $total_price += $assign->price; @endphp
                                                            <td>
                                                                @if(isset($assign->depreciations))
                                                                    @if($assign->depreciations->current_value ==null)
                                                                        {{ $assign->price }}
                                                                        @php $total_current += $assign->price; @endphp
                                                                    @else
                                                                        {{$assign->depreciations->current_value}}
                                                                        @php $total_current += $assign->depreciations->current_value; @endphp
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>{{ isset($assign->purchase_date) ? date('d-M-Y', strtotime($assign->purchase_date)) : ''}}</td>
                                                            <td>
                                                                @foreach($users as $userCreator)
                                                                    @if( $assign->created_by == $userCreator->id )
                                                                        {{$userCreator->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <a href="#myModal" data-toggle="modal"
                                                                   data-target="#myAModal_{{ $assign->id}}"
                                                                   data-id="{{$assign->id}}">
                                                                    <button type="button"
                                                                            class="btn btn-basic action-icon"><i
                                                                            class="fa fa-eye"></i></button>
                                                                </a>
                                                                <!-- Product Details Model -->
                                                                <div class="modal fade" id="myAModal_{{ $assign->id}}"
                                                                     role="dialog">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                @if( isset($assign->product->product) )
                                                                                    <h4 class="modal-title"
                                                                                        style="color:#000000">{{ $assign->product->product }}</h4>
                                                                                @endif
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table m-0">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <th scope="col">Product</th>
                                                                                            <td colspan="3">
                                                                                                @if(isset($assign->product_id))
                                                                                                    {{$assign->product->product}}
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Serial No</th>
                                                                                            <td>{{ $assign->serial_no }}</td>

                                                                                            <th scope="row">Brand Name</th>
                                                                                            <td>{{ $assign->brand_name }}</td>
                                                                                        </tr>
                                                                                        @if($category == 3)
                                                                                            <tr>
                                                                                                <th scope="row">Chasis Number</th>
                                                                                                <td>{{$assign->chasis_no}}</td>

                                                                                                <th scope="row">CC</th>
                                                                                                <td>{{ $assign->cc }}</td>
                                                                                            </tr>
                                                                                        @endif
                                                                                        <tr>
                                                                                            <th scope="row">COA Reference No</th>
                                                                                            <td>
                                                                                                @if(isset($assign->coa_id))
                                                                                                    {{ $assign->coa->coa_reference_no }}
                                                                                                @endif
                                                                                            </td>

                                                                                            <th scope="row">Depreciation Rate</th>
                                                                                            <td>{{ $assign->depreciation_rate }}%</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Location</th>
                                                                                            <td>{{ $assign->location == 1 ? 'Head Office' : '' }}</td>

                                                                                            <th scope="row">Purchase Date</th>
                                                                                            <td>{{ isset($assign->purchase_date) ? $assign->purchase_date : '' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Price (per product)</th>
                                                                                            <td>Tk {{ $assign->price }}</td>

                                                                                            <th scope="row">Payment
                                                                                                Method
                                                                                            </th>
                                                                                            <td>
                                                                                                @if($assign->payment_method==0)
                                                                                                    By Cash
                                                                                                @elseif($assign->payment_method==1)
                                                                                                    By Cheque
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Accumulated
                                                                                                depreciation (per
                                                                                                product)
                                                                                            </th>
                                                                                            <td>
                                                                                                @if(isset($assign->depreciations->accumulated_depreciation))
                                                                                                    Tk {{$assign->depreciations->accumulated_depreciation}}
                                                                                                @endif
                                                                                            </td>
                                                                                            <th scope="row">Current
                                                                                                Value(per product)
                                                                                            </th>
                                                                                            <td>
                                                                                                @if(isset($assign->depreciations))
                                                                                                    @if($assign->depreciations->current_value ==null)
                                                                                                        {{ $assign->price }}
                                                                                                    @else

                                                                                                        {{$assign->depreciations->current_value}}
                                                                                                    @endif
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Vendor
                                                                                                Name
                                                                                            </th>
                                                                                            <td>
                                                                                                @if(isset($assign->vendor_id))
                                                                                                    {{ $assign->vendor->vendor_name }}
                                                                                                @endif
                                                                                            </td>
                                                                                            <th scope="row">Vendor
                                                                                                Contact
                                                                                            </th>
                                                                                            <td>
                                                                                                @if(isset($assign->vendor_id))
                                                                                                    {{ $assign->vendor->phone_number }}
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row">Added By</th>
                                                                                            @foreach($users as $user)
                                                                                                @if( $assign->created_by == $user->id )
                                                                                                    <td>{{ $user->name }}</td>
                                                                                                @endif
                                                                                            @endforeach
                                                                                            <th scope="row">Added At</th>
                                                                                            <td>{{ date('d-M-Y', strtotime($assign->created_at)) }}</td>
                                                                                        </tr>
                                                                                           <tr>
                                                                                                <th scope="row">Description</th>
                                                                                                <td>{{ $assign->description }}</td>
                                                                                                <th scope="row">Issued To</th>
                                                                                                <td>
                                                                                                    @php
                                                                                                        $get_emp = DB::table('erp_employee_materials')
                                                                                                            ->leftjoin('erp_employees','erp_employees.id','erp_employee_materials.employee_id')
                                                                                                            ->select('erp_employees.first_name','erp_employees.last_name','erp_employees.unique_id')
                                                                                                            ->where('coa_id',$assign->coa_id)
                                                                                                            ->first();
                                                                                                    @endphp
                                                                                                    @if($get_emp)
                                                                                                        {{ $get_emp->first_name }} {{ $get_emp->last_name }}
                                                                                                        <small>( {{ $get_emp->unique_id }} )</small>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                            @if(isset($assign->upload_document))
                                                                                                <tr>
                                                                                                    <th scope="row">Voucher</th>
                                                                                                    <td colspan="3">
                                                                                                        <a href="{{url('inventory/document/'.$assign->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @can('Edit Inventory')
                                                                    <a href="{{ route('inventory.edit',$assign->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                                                @endcan
                                                                @can('Assign Inventory')
                                                                    @if($category == 2 ||$category == 4)
                                                                        <a class="modalLink" title="Return" data-modal-size="modal-md" href="{{url('assignBackView', $assign->inventory_id)}}">
                                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-arrow-left"></i></button>
                                                                        </a>
                                                                    @else
                                                                        <a class="modalLink" title="Return" data-modal-size="modal-md" href="{{url('assignBackView', $assign->id)}}">
                                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-arrow-left"></i></button>
                                                                        </a>
                                                                    @endif
                                                                @endcan
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <h4 style="color: #00aeef;margin: 5px">
                                                    Total Price: {{$total_price}} BDT
                                                </h4>

                                                <h4 style="color: #00aeef;margin: 5px">
                                                    Total Current Price: {{$total_current}} BDT
                                                </h4>
                                                <br>
                                            </table>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endSection
