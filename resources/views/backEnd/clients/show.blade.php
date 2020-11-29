@extends('backEnd.master')
@section('mainContent')

<div class="tab-pane" id="contacts" role="tabpanel">
	<div class="row">
		<div class="col-xl-3">
            @can('View Client Details')
			<div class="card user-card">
				<div class="card-header-img">
					@if( isset($client->client_image) )
						<img class="img-fluid img-radius" style="margin-top: 20px;" src="{{ asset($client->client_image) }}" alt="card-img">
					@else
						<img class="img-fluid img-radius" src="{{ asset('/public/images/no_image.png') }}" alt="card-img">
					@endif

					@if( isset($client->client_name) )
						<h4>{{ $client->client_name }}</h4>
					@else
						<h4>No Client Name</h4>
					@endif

                    <br>
			    </div>
		    </div>
            @endcan
            <div class="  text-center">
                <a class="" title="Back" href="{{url('/client')}}">
                    <button type="button" class="btn btn-primary m-b-0">Clients List</button>
                </a>
            </div>
        </div>

		<div class="col-xl-9">
            <div class="tab-header card">
                <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                    @can('View Client Details')
                    <li class="nav-item">
                        <a class="nav-link active tab_style" data-toggle="tab" href="#personal" role="tab">Client Details</a>
                        <div class="slide"></div>
                    </li>
                    @endcan
{{--                    @can('View Client Payment')--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link tab_style" data-toggle="tab" href="#payments" role="tab">Payments</a>--}}
{{--                        <!-- <div class="slide"></div> -->--}}
{{--                    </li>--}}
{{--                    @endcan--}}
                    @can('View Client Provided Documents')
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#provided_documents" role="tab">Archived Documents</a>
                    </li>
                    @endcan
                </ul>
            </div>
            <div class="tab-content">
                @can('View Client Details')
                <div class="tab-pane active" id="personal" role="tabpanel">

                    <div class="" id="logo" style="display:none;">
                        <div class="" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
                        </div>
                    </div>

                    <input type="text" id="client_name" value="{{ $client->client_name }}" hidden>
                    <input type="text" id="client_id" value="{{ $client->id }}" hidden>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Details</h5>
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
                                                                    <th scope="row">Client Full Name</th>
                                                                    @if( isset($client->client_name) )
    																	<td>{{ $client->client_name }}</td>
    																@else
    																	<td>No input given</td>
    																@endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Client  Abbreviation</th>
                                                                    @if( isset($client->abbreviation) )
                                                                        <td>{{ $client->abbreviation }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Ministry</th>
                                                                    @if( isset($client->ministry) )
                                                                        <td>{{ $client->ministry }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Division</th>
                                                                    @if( isset($client->division) )
                                                                        <td>{{ $client->division }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Agency</th>
                                                                    @if( isset($client->agency) )
                                                                        <td>{{ $client->agency }}</td>
                                                                    @else
                                                                        <td>No input given</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Company Website</th>
                                                                    @if( isset($client->website) )
                                                                        <td>{{ $client->website }}</td>
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

                    <div class="text-bottom text-center pt-5 mt-5" style="display: none" id="footer">
                        <div class="row">
                            <div class="col">
                                <p style="font-size: 0.9rem; background-color: #ece7e4;" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} |  <span id="datetime"> </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
{{--                @can('View Client Payment')--}}
{{--                <div class="tab-pane" id="payments" role="tabpanel">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">--}}
{{--                            <h5 class="card-header-text">Payments</h5>--}}
{{--                        </div>--}}
{{--                        <div class="card-block">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                    @endcan--}}
                    @can('View Client Provided Documents')
                <div class="tab-pane" id="provided_documents" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Archived Documents</h5>
                            <a href="#upload_document" class="btn btn-success collapsible" data-toggle="collapse" style="float: right; padding: 8px; color: white;">Upload Document</a>
                        </div>
                        <div class="card-block">
                            <div class="collapse" id="upload_document">
                                {{ Form::open(['class' => '', 'files' => true, 'url' => 'client/uploadDocument/'.$client->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
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
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Uploaded By</th>
                                        <th>Description</th>
                                        <th>View File</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i = 1 @endphp

                                    <!-- SHOW ALL PROJECT DOCUMENTS UPLOADED -->
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ date('d-M-Y H:s:i', strtotime($document->created_at)) }}</td>
                                            <td>{{ $document->document_name }}</td>
                                            <td>
                                                @foreach( $users as $user )
                                                    @if( $document->created_by == $user->id)
                                                        {{ $user->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                             <td>{{ $document->description }}</td>
                                            <td><a href="{{url('client/document/'.$document->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                    @endcan
            </div>
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

            var printContents = document.getElementById(personal).innerHTML;
            var client_name = document.getElementById('client_name').value;
            var id = document.getElementById('client_id').value;
            document.body.innerHTML = printContents;
            document.title='Client Details '+ client_name;
            window.print();
            window.location.href = "/epc/client/"+id;
        }
    </script>
@endsection
