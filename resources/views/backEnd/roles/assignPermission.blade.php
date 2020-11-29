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
    <div id="role_id" style="display: none">{{$role->id}}</div>
    <div id="role_name" style="display: none">{{$role->name}}</div>
	<div class="card-header">
		<h5>Assign Permission To - {{$role->name}}</h5>
        <button class="btn btn-success printBtn" onclick="printPermissionsDiv('assigned_permissions')" style="float: right; padding: 0.4em;" target="_blank">Print Permissions List</button>
    </div>
	<div class="card-block" id="assigned_permissions">
        <div class="logo row" id="logo" style="display:none;">
            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
            </div>
            <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                <p style="margin-top: 25px; font-size: 22px; font-weight: bold;"> Assign Permission To - {{$role->name}}</p>
            </div>
        </div>
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'role_permission_store', 'method' => 'POST']) }}
        <input type="hidden" name="role_id" value="{{$role->id}}">
		<table class="table" id="assigned_permissions">
			<thead>
				<tr style="border-top: none !important;">
                    <th>Module  Name</th>
					<th>Module Features</th>
                    <th>Permission</th>
				</tr>
			</thead>
			<tbody>

{{--            @foreach($permissions as $permission)--}}

{{--				<tr>--}}
{{--                    <td>{{$permission->Module_name}}</td>--}}
{{--                    <td>{{ $permission->name}}</td>--}}
{{--					<td>--}}

{{--						<div class="">--}}
{{--							<input type="checkbox" id="permissions{{$permission->id}}" class="common-checkbox" name="permissions[]" value="{{$permission->id}}" {{in_array($permission->id, $already_assigned)? 'checked':''}}>--}}
{{--                            {{dd($permission)}}--}}
{{--							<label for="permissions{{$permission->id}}"></label>--}}
{{--						</div>--}}
{{--					</td>--}}
{{--				</tr>--}}
{{--            @endforeach--}}
            @foreach($permissions as $permission)
                <tr>
                    <td>{{$permission->Module_name}}</td>
                    <td>{{ $permission->name}}</td>
                    <td>
                        <div class="">
                            <input type="checkbox" id="permissions{{$permission->id}}" class="common-checkbox" name="permissions[]" value="{{$permission->id}}" {{in_array($permission->id, $already_assigned)? 'checked':''}}>
                            <label for="permissions{{$permission->id}}"></label>
                        </div>
                    </td>
                </tr>
            @endforeach
				<tr>
					<td></td>
					<td></td>
					<td>
						<div class="col-lg-12 mt-20 text-right">
							<button id="save" type="submit" class="primary-btn fix-gr-bg">
								<span class="ti-check"></span>
								Save
							</button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
        {{ Form::close() }}
        <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
            <div class="row">
                <div class="col">
                    <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime107"> </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#project_employee').DataTable();
    $('#budget_table').DataTable();

    function printPermissionsDiv(assigned_permissions)
    {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();

        var dt = new Date();
        document.getElementById("datetime107").innerHTML = dt.toLocaleString();
        document.getElementById("save").style.display = "none";
        var role_id = document.getElementById('role_id').innerHTML;
        var role_name = document.getElementById('role_name').innerHTML;
        var printContents = document.getElementById(assigned_permissions).innerHTML;
        document.body.innerHTML = printContents;
        document.title=role_name+ ' Permissions List';
        window.print();
        window.location.href = "/epc/role_assign-permission/"+role_id;

    }

</script>
@endSection
