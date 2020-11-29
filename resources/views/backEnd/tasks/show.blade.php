@extends('backEnd.master')

@section('mainContent')
<div class="row">
	<div class="col-xl-12">
        @if(Auth::user()->hasPermissionTo('View Task') || Auth::user()->employee_id == $editData->employee_id|| Auth::user()->getRoleNames()->first() == 'Super Admin')
            <div class="card">
                <div class="card-header">
                    @if( isset($editData->task_name) )
                        <h5 class="card-header-text">Task : {{ $editData->task_name }}</h5>
                    @else
                        <h5 class="card-header-text">No Project Name</h5>
                    @endif
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
                                                            <th scope="row">Project Name</th>
                                                            @if( isset($editData->project_id) )
                                                                <td>
                                                                    <a href="{{ route('project.show',$editData->project->id) }}" style="font-size: 1em; text-decoration: underline;">{{ $editData->project->project_name }}</a>
                                                                </td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif

                                                            <th scope="row">Due Date</th>
                                                            @if( isset($editData->due_date) )
                                                                <td>{{ date('d-M-Y', strtotime($editData->due_date)) }}</td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Assigned To</th>
                                                            @if( isset($editData->employee_id) )
                                                                <td>
                                                                    <a href="{{ route('employee.show',$editData->employee->id) }}" style="font-size: 1em; text-decoration: underline;">{{ $editData->employee->first_name }} {{ $editData->employee->last_name }}</a>
                                                                </td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif

                                                            <th scope="row">Assigned By</th>
                                                            @if( isset($editData->assigned_by) )
                                                                <td>
                                                                    <a href="{{ route('employee.show',$editData->assignee->employee_id) }}" style="font-size: 1em; text-decoration: underline;">{{  $editData->assignee->name }}</a>
                                                                </td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Priority</th>
                                                            @if( isset($editData->priority) )
                                                                <td style="color: red;">
                                                                @if( $editData->priority == 2)
                                                                    Urgent
                                                                @elseif( $editData->priority == 1)
                                                                    High
                                                                @elseif( $editData->priority == 0)
                                                                    Medium
                                                                @endif
                                                                </td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif

                                                            <th scope="row">Status</th>
                                                            @if( isset($editData->task_status) )
                                                                <td style="color: blue;">{{ ucwords($editData->task_status) }}</td>
                                                            @else
                                                                <td>No input given</td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Description</th>
                                                            @if( isset($editData->description) )
                                                                <td colspan="3">{{ $editData->description }}</td>
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
                    <div class="form-group row mt-5 text-center">
                        <div class="col-md-12 text-center" style="margin-bottom: 1em;">
                            <a class="" title="Back" href="{{ url()->previous() }}">
                                <button type="button" class="btn btn-primary m-b-0">Back</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endSection
