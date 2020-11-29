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
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                        @can('view Project Details')
                            <li class="nav-item">
                                <a class="nav-link active tab_style" data-toggle="tab" href="#assets" role="tab">Assets</a>
                                <div class="slide"></div>
                            </li>
                        @endcan
                        @can('View Project Employee List')
                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#employee" role="tab">Employees</a>
                            </li>
                        @endcan
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="assets" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5>Assets in room {{ $room->room_no }}</h5>
                                <br><br>
                                <a href="{{ url('location') }}" style="padding: 6px; color: white;" class="btn btn-success"> Room No List </a>
                            </div>
                            @can('View Inventory')
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="basic-btn" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Asset Number</th>
                                                <th>Product Name</th>
                                                <th>Serial No</th>
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
                                                    <td>
                                                        @if(isset($product->coa_id))
                                                            <a href="{{ url('single_account', $product->coa_id) }}" target="_blank">{{ $product->coa->coa_reference_no }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{$product->product->product}}</td>
                                                    <td>{{$product->serial_no}}</td>
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
                                                                        @if( isset($product->product_id) )
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

                                                                                @if($product->chasis_no != null || $product->cc != null)
                                                                                    <tr>
                                                                                        <th scope="row">Chasis Number</th>
                                                                                        <td>{{$product->chasis_no}}</td>

                                                                                        <th scope="row">CC</th>
                                                                                        <td>{{ $product->cc }}</td>
                                                                                    </tr>
                                                                                @endif

                                                                                @if($product->coa_id != null)
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
                                                                                    <th scope="row">Location</th>
                                                                                    <td>{{ $product->location == 1 ? 'Head Office' : '' }}</td>

                                                                                    <th scope="row">Purchase Date</th>
                                                                                    <td>{{ isset($product->purchase_date) ? $product->purchase_date : '' }}</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th scope="row">Price (per product)</th>
                                                                                    <td>Tk {{ $product->price }}</td>

                                                                                    <th scope="row">Payment Method</th>
                                                                                    <td>
                                                                                        @if($product->payment_method==0)
                                                                                            By Cash
                                                                                        @elseif($product->payment_method==1)
                                                                                            By Cheque
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

                                                                                    <th scope="row">Vendor Contact</th>
                                                                                    <td>
                                                                                        @if(isset($product->vendor_id))
                                                                                            {{ $product->vendor->phone_number }}
                                                                                        @endif
                                                                                    </td>
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
                                                        <a class="modalLink" title="Return" data-modal-size="modal-md" href="{{url('assignBackView', $product->id)}}">
                                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-arrow-left"></i></button>
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
                    </div>
                    <div class="tab-pane" id="employee" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5>Employees in room {{ $room->room_no }}</h5>
                                <br><br>
                                <a href="{{ url('location') }}" style="padding: 6px; color: white;" class="btn btn-success"> Room No List </a>
                            </div>
                            @can('View Employee List')
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table id="basic-btn1" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Photo</th>
                                                <th>Employee ID</th>
                                                <th>Full Name</th>
                                                <th>Mobile</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $i = 1 @endphp
                                            @foreach($employees as $employee)
                                                @if($employee->id != 1)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>
                                                            <div class="d-inline-block align-middle">
                                                                @if(empty($employee->employee_photo))
                                                                    <img src="{{asset('public/images/no_image.png')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                @else
                                                                    <img src="{{asset($employee->employee_photo)}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>{{$employee->unique_id}}</td>
                                                        <td>{{$employee->first_name.' '.$employee->last_name}}</td>
                                                        <td>{{$employee->mobile}}</td>
                                                        <td>
                                                            @if(isset($employee->department_id))
                                                                {{$employee->department->department_name}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($employee->designation_id))
                                                                {{$employee->designation->designation_name}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @canany(['View Employee Details','View Employee Salary','View Employee Leave','View Employee Attendance History','View Employee Tasks','View Employee Document'])
                                                                <a href="{{ route('employee.show',$employee->id) }}" title="View"><button type="button" class="btn btn-basic action-icon"><i class="fa fa-eye"></i></button></a>
                                                            @endcanany
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endcan()
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endSection
