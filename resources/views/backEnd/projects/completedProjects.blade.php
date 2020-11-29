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
            <h5>Project Lists</h5>
            <br>
            <a href="{{ url('print_projects') }}" style="padding: 6px 12px; margin-top: 10px; color: white;"
               class="btn btn-success"> Print all Projects</a>
            <a href="{{ url('print_projects/complete') }}" style="padding: 6px 12px; margin-top: 10px; color: white;"
               class="btn btn-success"> Print Completed Projects</a>

            @can('Add/Edit Project')
                <a href="{{ route('project.create') }}" style="float: right; padding: 8px; color: white;"
                   class="btn btn-success"> Add Project </a>
                <a href="{{ url('projects/past') }}" style="float: right; padding: 8px; color: white;margin-right: 10px"
                   class="btn btn-success"> Past Projects </a>
                <a href="{{ url('project') }}" style="float: right; padding: 8px; color: white;margin-right: 10px"
                   class="btn btn-success"> Active Projects </a>
            @endcan
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table id="basic-btn" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>Project ID</th>
                        <th>Project Name</th>
                        <th>Project Phase</th>
                        <th>Agency</th>
                        <th>Contract Type</th>
                        {{--                        <th>JV Associates</th>--}}
                        <th>Client</th>
                        <th>Status</th>
                        <th>Ministry</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach($projects as $project)

                        @if($project->project_status == 'completed')

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $project->project_code }}-00{{ $project->project_phase }}</td>
                                <td>{{$project->project_name}}</td>
                                <td>
                                    @if($project->project_phase == 1) EOI
                                    @elseif($project->project_phase == 2) Proposal
                                    @elseif($project->project_phase == 3) DD
                                    @elseif($project->project_phase == 4) Supervision
                                    @elseif($project->project_phase == 5) PM
                                    @endif
                                </td>
                                <td>
                                    @if( isset($project->funded_by))
                                        {{ $project->funded->client_name }}
                                    @endif
                                </td>
                                <td>
                                    @if( $project->contract_type == 1)
                                        JV
                                    @elseif( $project->contract_type == 2)
                                        Subconsultant
                                    @else
                                        Lead
                                    @endif
                                </td>
                                {{--                        <td>{{ $project->association }}</td>--}}
                                <td>
                                    @if( isset($project->client_id))
                                        {{ $project->clients->client_name }}
                                    @endif
                                </td>
                                {{--                        <td>{{ isset($project->extended_date) ? date('d-M-Y', strtotime($project->extended_date)) : ( isset($project->project_due_date) ? date('d-M-Y', strtotime($project->project_due_date)) : '') }}</td>--}}
                                <td style="color: blue;">{{ ucwords($project->project_status) }}</td>
                                <td>
                                    @if( isset($project->client_id))
                                        {{ $project->clients->ministry }}
                                    @endif
                                </td>
                                <td>
                                    @canany(['view Project Details','view Project Payment','view Project Documents','Add Task','View Task'])
                                        <a href="{{ route('project.show',$project->id) }}" title="View"><button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button></a>
                                    @endcanany
                                    @can('Add/Edit Project')
                                        <a href="{{ route('project.edit',$project->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                    @endcan
                                    @if(Auth::user()->getRoleNames()->first() == 'Super Admin')
                                        <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteProjectView', $project->id)}}">
                                            <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>
                                        </a>
                                    @endif
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endSection
