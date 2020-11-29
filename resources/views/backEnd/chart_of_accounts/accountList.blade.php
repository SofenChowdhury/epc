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

<div class="card">
	<div class="card-header">
		<h5>Chart of Accounts List</h5>
		<a href="{{ url('/add-new-coa') }}" style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add Chart of Accounts </a>
	</div>
	<div class="card-block">
		<table id="basic-btn" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Account Name</th>
					<th>Account Category</th>
					<th>Account Class</th>
					<th>Type</th>
					<th>Opening Amount</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(isset($coas))
				@foreach($coas as $coa)
				<tr>
					<td>{{$coa->coa_name}}</td>
		            <td>{{$coa->accountCategory ? $coa->accountCategory->category_name : 'N\A'}}</td>
		            <td>
		            	@if(!empty($coa->coa_class))
		            		{{$coa->accountClass->class_name}}
		            	@endif
		            	</td>
		            <td>
		            	@if($coa->debit_amount == 1)
		            	   Debit
		            	@endif
		            	@if($coa->credit_amount == 1)
		            	   Credit
		            	@endif
		            </td>

		             <td>
		            	@if($coa->debit_amount == 1)
		            	   {{$coa->opening_debit_amount}}
		            	@endif
		            	@if($coa->credit_amount == 1)
		            	   {{$coa->opening_credit_amount}}
		            	@endif
		            </td>
		            <td>
		                <!-- <a href="" title="view"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a> -->
						<a href="#" title="edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
						<a href="" title="delete">
							<button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
						</a>
					</td>
				</tr>
				@endforeach
				@endif
			</tbody>

		</table>
	</div>
</div>
@endSection
