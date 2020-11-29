@extends('backEnd.master')
@section('mainContent')

<div class="tab-pane" id="contacts" role="tabpanel">
	<div class="row">

		<div class="col-xl-12">
            <div class="tab-header card">
                <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                    @can('View Vendor')
                    <li class="nav-item">
                        <a class="nav-link active tab_style" data-toggle="tab" href="#personal" role="tab">Vendor Details</a>
                        <div class="slide"></div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#bank_details" role="tab">Bank Details</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#documents" role="tab">Vendor Documents</a>
                    </li>
                    @endcan
                </ul>
            </div>
            @can('View Vendor')
            <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                    <div class="" id="logo" style="display:none;">
                        <div class="" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                        </div>
                    </div>

                    <input type="text" id="vendor_name" value="{{ $vendor->vendor_name }}" hidden>
                    <input type="text" id="vendor_id" value="{{ $vendor->id }}" hidden>

                    <div class="card">
                        <div class="card-header">
                            @if( isset($vendor->vendor_name) )
                                <h5 class="card-header-text" style="font-size: 1rem;">{{ $vendor->vendor_name }}</h5>
                            @else
                                <h5 class="card-header-text"> Vendor Details</h5>
                            @endif
                            <br>
                            <button class="btn btn-success" onclick="printDiv('personal')" id="printBtn" style="float: right; padding: 6px 25px;">Print Details</button>
                        </div>
                        <div class="card-block">
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
                                                                    <th scope="row">Vendor ID</th>
                                                                    @if( isset($vendor->unique_id) )
                                                                        <td>{{ $vendor->unique_id }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Vendor Name</th>
                                                                    @if( isset($vendor->vendor_name) )
    																	<td>{{ $vendor->vendor_name }}</td>
    																@else
    																	<td>No input given</td>
    																@endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Chart of Account ID</th>
                                                                    @if( isset($vendor->coa_id) )
                                                                        <td>
                                                                            <a href="{{ url('single_account', $vendor->coa_id) }}" target="_blank">{{ $vendor->coa->coa_reference_no }}</a>
                                                                        </td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Trade Licence Number</th>
                                                                    @if( isset($vendor->trade_licence_no) )
                                                                        <td>{{ $vendor->trade_licence_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Type of Service</th>
                                                                    @if( isset($vendor->service_type) )
                                                                        <td colspan="3">{{ $vendor->service_type }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Service Account No.</th>
                                                                    @if( isset($vendor->service_acc_no) )
                                                                        <td>{{ $vendor->service_acc_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Service Meter No.</th>
                                                                    @if( isset($vendor->service_meter_no) )
                                                                        <td>{{ $vendor->service_meter_no }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Phone Number</th>
                                                                    @if( isset($vendor->phone_number) )
                                                                        <td>{{ $vendor->phone_number }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Email</th>
                                                                    @if( isset($vendor->email) )
                                                                        <td>{{ $vendor->email }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Contact Person Name</th>
                                                                    @if( isset($vendor->contact_person_name) )
                                                                        <td>{{ $vendor->contact_person_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Designation</th>
                                                                    @if( isset($vendor->designation) )
                                                                        <td>{{ $vendor->designation }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Contact Person Phone</th>
                                                                    @if( isset($vendor->contact_person_phone) )
                                                                        <td>{{ $vendor->contact_person_phone }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif

                                                                    <th scope="row">Contact Person Email</th>
                                                                    @if( isset($vendor->contact_person_email) )
                                                                        <td>{{ $vendor->contact_person_email }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Office Address</th>
                                                                    @if( isset($vendor->office_address) )
                                                                        <td colspan="3">{{ $vendor->office_address }}</td>
                                                                    @else
                                                                        <td colspan="3">No input given</td>
                                                                    @endif
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

                    <div class="text-bottom text-center pt-5 mt-5" style="display: none" id="footer">
                        <div class="row">
                            <div class="col">
                                <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="bank_details" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Bank Details</h5>
                            <br>
                        </div>
                        <div class="card-block">
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
                                                                    <th scope="row">Bank Name</th>
                                                                    @if( isset($vendor->bank->bank_name) )
                                                                        <td>{{ $vendor->bank->bank_name }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Account Number</th>
                                                                    @if( isset($vendor->bank->account_number) )
                                                                        <td>{{ $vendor->bank->account_number }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Bank Branch</th>
                                                                    @if( isset($vendor->bank->bank_branch) )
                                                                        <td>{{ $vendor->bank->bank_branch }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Bank Address</th>
                                                                    @if( isset($vendor->bank->bank_address) )
                                                                        <td>{{ $vendor->bank->bank_address }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Routing Number</th>
                                                                    @if( isset($vendor->bank->routing_number) )
                                                                        <td>{{ $vendor->bank->routing_number }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Swift Code</th>
                                                                    @if( isset($vendor->bank->swift_code) )
                                                                        <td>{{ $vendor->bank->swift_code }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
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

                <div class="tab-pane" id="documents" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Vendor Documents</h5>
                            <br>
                            <a href="#upload_document" class="btn btn-success collapsible" data-toggle="collapse" style="float: right; padding: 8px; color: white;">Upload Document</a>
                        </div>
                        <div class="card-block">
                            <div class="collapse" id="upload_document">
                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'vendor/uploadDocument/'.$vendor->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                {{csrf_field()}}
                                <div class="card">
                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <div class="form-group row col-md-12">
                                                <div class="form-group col-md-6">
                                                    <label for="document_name">Document Name:</label>
                                                    <input type="text" class="form-control {{ $errors->has('document_name') ? ' is-invalid' : '' }}" value="{{ old('document_name') }}" name="document_name" required />
                                                    <p style="color: darkred">Maximum 100 characters</p>
                                                    @if ($errors->has('document_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                    <span class="messages"><strong>{{ $errors->first('document_name') }}</strong></span>
                                                </span>
                                                    @endif
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="upload_document">Upload Document</label>
                                                    <input data-preview="#preview" class="form-control" type="file" name="upload_document" id="upload_document" required>
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
                                <table id="print-btn" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Upload Date</th>
                                        <th>Uploaded By</th>
                                        <th>Description</th>
                                        <th>View File</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 1 @endphp
                                    <!-- SHOW ALL VENDOR DOCUMENTS UPLOADED -->
                                    @foreach($vendor->documents as $document)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $document->document_name }}</td>
                                            <td>{{ date('d-M-Y H:s:i', strtotime($document->created_at)) }}</td>
                                            <td>
                                                @foreach( $users as $user )
                                                    @if( $document->created_by == $user->id)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $document->description }}</td>
                                            <td><a href="{{url('vendor/document/'.$document->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
	</div>
</div>
@endSection

@section('javascript')
    <script>
        function printDiv(personal)
        {
            $('#printBtn').hide();

            document.getElementById('logo').style.display = "block";
            document.getElementById('footer').style.display = "block";
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContent1 = document.getElementById(personal).innerHTML;
            var vendor_name = document.getElementById('vendor_name').value;
            var id = document.getElementById('vendor_id').value;
            document.body.innerHTML = printContent1;
            document.title='Vendor Details '+ vendor_name;
            window.print();
            window.location.href = "/epc/vendors/"+id;
        }
    </script>
@endsection
