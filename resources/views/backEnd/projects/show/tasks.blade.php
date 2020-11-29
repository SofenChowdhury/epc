<div class="tab-pane" id="tasks" role="tabpanel">
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytasktab">
                        <li class="nav-item">
                            <a class="nav-link active tab_style" data-toggle="tab" href="#task" role="tab">Project
                                Tasks</a>
                            <div class="slide"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#reporting" role="tab">Reporting</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#deliverable"
                               role="tab">Deliverable</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="task" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text"
                                        style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                <br>
                                @can('Add Task')
                                    <a href="{{ url('task/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add
                                        Task </a>
                                    <a href="{{ url('project/task/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>
                                    <a href="{{ url('project/print',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white; margin-right: 8px;"
                                       class="btn btn-success" target="_blank"> Print Report </a>

                                @endcan
                            </div>
                            <div class="card-block">
                                @if($maxAmendmentTask>0)
                                    @for($o=$maxAmendmentTask; $o>=0; $o--)
                                        <div class="card-block">

                                            <div class="card">
                                                <div class="card-header">
                                                    @if($o!=0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Amendment No: {{$o}}
                                                            </strong>

                                                        </div>
                                                    @endif
                                                    @if($o==0)
                                                        <div class="card-header">

                                                            <strong style="color: #00aeef">
                                                                Original Contract
                                                            </strong>

                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="card-block">
                                                    <div class="table-responsive">
                                                        <table id="basic-btn"
                                                               class="table table-striped table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Sl No.</th>
                                                                <th>ID</th>
                                                                <th>Project Phase</th>
                                                                <th>Name</th>
                                                                <th>Status</th>
                                                                <th>Assigned To</th>
                                                                <th>Due Date</th>
                                                                <th>Priority</th>
                                                                <th>Assigned By</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if(isset($tasks))
                                                                @php $i = 1 @endphp
                                                                @foreach($tasks as $task)
                                                                    @if($task->amendment == $o)
                                                                        <tr>
                                                                            <td>{{ $i++ }}</td>
                                                                            <td>{{ $task->task_id }}</td>
                                                                            <td> 00{{ $task->project_phase }}</td>
                                                                            <td>{{ $task->task_name }}</td>
                                                                            <td style="color: blue;">{{ ucwords($task->task_status) }}</td>
                                                                            <td>
                                                                                @if(isset($task->employee))
                                                                                    {{ $task->employee->first_name }} {{ $task->employee->last_name }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if(isset($task->due_date))
                                                                                    {{ date('d-M-Y', strtotime($task->due_date)) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if( $task->priority == 2 )
                                                                                    <button type="button"
                                                                                            class="btn btn-danger btn-sm"
                                                                                            width=3em>Urgent
                                                                                    </button>
                                                                                @elseif( $task->priority == 1 )
                                                                                    <button type="button"
                                                                                            class="btn btn-success btn-sm">
                                                                                        High
                                                                                    </button>
                                                                                @elseif( $task->priority == 0 )
                                                                                    <button type="button"
                                                                                            class="btn btn-info btn-sm">
                                                                                        Medium
                                                                                    </button>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @foreach($users as $creator)
                                                                                    @if( $task->assigned_by == $creator->id )
                                                                                        {{$creator->name}}
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('task.show',$task->id) }}"
                                                                                   title="View">
                                                                                    <button type="button"
                                                                                            class="btn btn-basic action-icon">
                                                                                        <i class="fa fa-eye"></i>
                                                                                    </button>
                                                                                </a>
                                                                                @if(Auth::user()->id == $task->assigned_by )
                                                                                    <a href="{{ url('task/'.$task->id.'/edit') }}"
                                                                                       title="Edit">
                                                                                        <button type="button"
                                                                                                class="btn btn-info action-icon">
                                                                                            <i class="fa fa-edit"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                    <a class="modalLink" title="Delete"
                                                                                       data-modal-size="modal-md"
                                                                                       href="{{url('deleteTaskView',$task->id)}}">
                                                                                        <button type="button"
                                                                                                class="btn btn-danger action-icon">
                                                                                            <i class="fa fa-trash-o"></i>
                                                                                        </button>
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @endif
                                <div class="card-block">

                                    <div class="card">
                                        <div class="card-header">

                                            <div class="card-header">
                                                @if($maxAmendmentTask==0)
                                                    <strong style="color: #00aeef">
                                                        Original Contract
                                                    </strong>
                                                @endif
                                                @if($maxAmendmentTask>0)
                                                    <strong style="color: #00aeef">
                                                        Contract & Amendment
                                                    </strong>
                                                @endif

                                            </div>


                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="basic-btn"
                                                       class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Sl No.</th>
                                                        <th>ID</th>
                                                        <th>Project Phase</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Assigned To</th>
                                                        <th>Due Date</th>
                                                        <th>Priority</th>
                                                        <th>Assigned By</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($tasks))
                                                        @php $i = 1 @endphp
                                                        @foreach($tasks as $task)

                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $task->task_id }}</td>
                                                                <td> 00{{ $task->project_phase }}</td>
                                                                <td>{{ $task->task_name }}</td>
                                                                <td style="color: blue;">{{ ucwords($task->task_status) }}</td>
                                                                <td>
                                                                    @if(isset($task->employee))
                                                                        {{ $task->employee->first_name }} {{ $task->employee->last_name }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(isset($task->due_date))
                                                                        {{ date('d-M-Y', strtotime($task->due_date)) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if( $task->priority == 2 )
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-sm"
                                                                                width=3em>Urgent
                                                                        </button>
                                                                    @elseif( $task->priority == 1 )
                                                                        <button type="button"
                                                                                class="btn btn-success btn-sm">
                                                                            High
                                                                        </button>
                                                                    @elseif( $task->priority == 0 )
                                                                        <button type="button"
                                                                                class="btn btn-info btn-sm">
                                                                            Medium
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @foreach($users as $creator)
                                                                        @if( $task->assigned_by == $creator->id )
                                                                            {{$creator->name}}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('task.show',$task->id) }}"
                                                                       title="View">
                                                                        <button type="button"
                                                                                class="btn btn-basic action-icon">
                                                                            <i class="fa fa-eye"></i>
                                                                        </button>
                                                                    </a>
                                                                    @if(Auth::user()->id == $task->assigned_by )
                                                                        <a href="{{ url('task/'.$task->id.'/edit') }}"
                                                                           title="Edit">
                                                                            <button type="button"
                                                                                    class="btn btn-info action-icon">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                        </a>
                                                                                <a class="modalLink" title="Delete"
                                                                                   data-modal-size="modal-md"
                                                                                   href="{{url('deleteTaskView',$task->id)}}">
                                                                                    <button type="button"
                                                                                            class="btn btn-danger action-icon">
                                                                                        <i class="fa fa-trash-o"></i>
                                                                                    </button>
                                                                                </a>
                                                                            @endif
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
                        </div>

                        <div class="card col-md-12">
                            <div class="card-header">
                                <h5 class="card-header-text" style="font-size: 1rem;">Reminder</h5>
                                <a style="float: right; padding: 0.4em; color: white;" class="btn btn-success"
                                   href="{{url('addToDo',$editData->id)}}">Add To-Do</a>
                            </div>
                            <div class="card-block" style="max-height: 30em; overflow: auto;">
                                <div class="view-info">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="general-info">
                                                <div class="row">
                                                    <div class="col-lg-12 ">
                                                        <div class="table-responsive">
                                                            <table class="table m-0" id="reminder_table">
                                                                <thead>
                                                                <tr style="font-size: 1.1em">
                                                                    <th scope="row"></th>
                                                                    <th scope="row">Phase</th>
                                                                    <th scope="row">Task Group</th>
                                                                    <th scope="row">Task</th>
                                                                    <th scope="row">Due date</th>
                                                                    <th scope="row">Status</th>
                                                                    <th scope="row">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($todos))
                                                                    @php $i = 1 @endphp
                                                                    @foreach($todos as $todo)
                                                                        <tr>
                                                                            <td>{{ $i++ }}</td>
                                                                            <td> 00{{ $todo->project_phase }}</td>
                                                                            <td>{{ $todo->task_group }}</td>
                                                                            <td>{{ $todo->task }}</td>
                                                                            <td>
                                                                                @if(isset($todo->due_date))
                                                                                    {{ date('d-M-Y', strtotime($todo->due_date)) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if( $todo->status == 'urgent' )
                                                                                    <button type="button" class="btn btn-danger btn-sm">Urgent</button>
                                                                                @elseif( $todo->status == 'pending' )
                                                                                    <button type="button" class="btn btn-warning btn-sm">Pending</button>
                                                                                @elseif( $todo->status == 'remind' )
                                                                                    <button type="button" class="btn btn-success btn-sm">Remind</button>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ url('editToDo',$todo->id) }}" title="Edit"><button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button></a>
                                                                                <a class="modalLink" title="Completed" data-modal-size="modal-md" href="{{url('deleteToDoView',$todo->id)}}">
                                                                                    <button type="button" class="btn btn-success action-icon"><i class="fa fa-check"></i></button>
                                                                                </a>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="reporting" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text"
                                        style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                @can('Add Project Reporting')
                                    <a href="{{ url('project_reporting/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add
                                        Reporting </a>
                                    <a href="{{ url('project/reporting/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>
                                    <button class="btn btn-success printBtn"
                                            onclick="printReportsDiv('project_reports')"
                                            style="float: right; padding: 8px; margin-right: 10px" target="_blank">Print
                                        Reporting
                                    </button>

                                @endcan
                            </div>
                            <div class="card-block" id="project_reports">
                                <div class="logo row" id="logo" style="display:none;">
                                    <div class="col-md-4"
                                         style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                        <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}"
                                             height="10" width="120">
                                    </div>
                                    <div class="col-md-4"
                                         style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                        <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }}
                                            Reporting List</p>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @if($maxAmendmentReporting>0)
                                        @for($p=$maxAmendmentReporting; $p>=0; $p--)
                                            <div class="card-block">

                                                <div class="card">
                                                    <div class="card-header">
                                                        @if($p!=0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Amendment No: {{$p}}
                                                                </strong>

                                                            </div>
                                                        @endif
                                                        @if($p==0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Original Contract
                                                                </strong>

                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table id="basic-btn"
                                                                   class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sl No.</th>
                                                                    <th>Project Phase</th>
                                                                    <th>Name of Report</th>
                                                                    <th>Due Date</th>
                                                                    <th>Description</th>
                                                                    <th>No. of Copies</th>
                                                                    <th>Submitted On</th>
                                                                    <th id="action">Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($editData->reporting))
                                                                    @php $i = 1 @endphp
                                                                    @foreach($editData->reporting as $report)
                                                                        @if($report->amendment == $p)
                                                                            <tr>
                                                                                <td>{{ $i++ }}</td>
                                                                                <td> 00{{ $report->project_phase }}</td>
                                                                                <td>{{ $report->report_name }}</td>
                                                                                <td>
                                                                                    @if(isset($report->due_date))
                                                                                        {{ date('d-M-Y', strtotime($report->due_date)) }}
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $report->description }}</td>
                                                                                <td>{{ $report->no_of_copies }}</td>
                                                                                <td>
                                                                                    @if(isset($report->submitted_on))
                                                                                        {{ date('d-M-Y', strtotime($report->submitted_on)) }}
                                                                                    @endif
                                                                                </td>
                                                                                {{--                                                    <td>--}}
                                                                                {{--                                                        @foreach($users as $creator)--}}
                                                                                {{--                                                            @if( $task->assigned_by == $creator->id )--}}
                                                                                {{--                                                                {{$creator->name}}--}}
                                                                                {{--                                                            @endif--}}
                                                                                {{--                                                        @endforeach--}}
                                                                                {{--                                                    </td>--}}
                                                                                <td id="action1">
                                                                                    @can('Edit Project Reporting')
                                                                                        <a href="{{ url('project_reporting/'.$report->id.'/edit') }}"
                                                                                           title="Edit">
                                                                                            <button type="button"
                                                                                                    class="btn btn-info action-icon">
                                                                                                <i class="fa fa-edit"></i>
                                                                                            </button>
                                                                                        </a>
                                                                                        {{--                                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteTaskView',$report->id)}}">--}}
                                                                                        {{--                                                                <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
                                                                                        {{--                                                            </a>--}}
                                                                                    @endcan
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                    <div class="card-block">

                                        <div class="card">

                                            <div class="card-header">
                                                @if($maxAmendmentReporting>0)
                                                    <strong style="color: #00aeef">
                                                        Contract & Amendment
                                                    </strong>
                                                @endif
                                                @if($maxAmendmentReporting==0)
                                                    <strong style="color: #00aeef">
                                                        Original Contract
                                                    </strong>
                                                @endif
                                            </div>


                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="basic-btn"
                                                       class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Sl No.</th>
                                                        <th>Project Phase</th>
                                                        <th>Name of Report</th>
                                                        <th>Due Date</th>
                                                        <th>Description</th>
                                                        <th>No. of Copies</th>
                                                        <th>Submitted On</th>
                                                        <th id="action">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($editData->reporting))
                                                        @php $i = 1 @endphp
                                                        @foreach($editData->reporting as $report)

                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td> 00{{ $report->project_phase }}</td>
                                                                <td>{{ $report->report_name }}</td>
                                                                <td>
                                                                    @if(isset($report->due_date))
                                                                        {{ date('d-M-Y', strtotime($report->due_date)) }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $report->description }}</td>
                                                                <td>{{ $report->no_of_copies }}</td>
                                                                <td>
                                                                    @if(isset($report->submitted_on))
                                                                        {{ date('d-M-Y', strtotime($report->submitted_on)) }}
                                                                    @endif
                                                                </td>
                                                                {{--                                                    <td>--}}
                                                                {{--                                                        @foreach($users as $creator)--}}
                                                                {{--                                                            @if( $task->assigned_by == $creator->id )--}}
                                                                {{--                                                                {{$creator->name}}--}}
                                                                {{--                                                            @endif--}}
                                                                {{--                                                        @endforeach--}}
                                                                {{--                                                    </td>--}}
                                                                <td id="action1">
                                                                    @can('Edit Project Reporting')
                                                                        <a href="{{ url('project_reporting/'.$report->id.'/edit') }}"
                                                                           title="Edit">
                                                                            <button type="button"
                                                                                    class="btn btn-info action-icon">
                                                                                <i class="fa fa-edit"></i>
                                                                            </button>
                                                                        </a>
                                                                        {{--                                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteTaskView',$report->id)}}">--}}
                                                                        {{--                                                                <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
                                                                        {{--                                                            </a>--}}
                                                                    @endcan
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
                                    <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none"
                                         id="footer">
                                        <div class="row">
                                            <div class="col">
                                                <p style="font-size: 0.9rem; background-color: #ece7e4; color: black">
                                                    ERP Version 1.1 | Developed by: White Paper | Printed
                                                    By: {{ Auth::user()->name }} | <span id="datetime109"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    <div class="tab-pane " id="deliverable" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text"
                                        style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                @can('Add Project Deliverable')
                                    <a href="{{ url('project_deliverable/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;" class="btn btn-success"> Add
                                        Deliverable </a>
                                    <a href="{{ url('project/deliverable/amendment/create',$editData->id) }}"
                                       style="float: right; padding: 8px; color: white;margin-right: 10px"
                                       class="btn btn-success"> Add Amendment </a>
                                    <button class="btn btn-success printBtn"
                                            onclick="printDeliverableDiv('project_deliverable')"
                                            style="float: right; padding: 8px; margin-right: 10px" target="_blank">Print
                                        Deliverable
                                    </button>
                                @endcan
                            </div>
                            <div class="card-block" id="project_deliverable">
                                <div class="logo row" id="logo" style="display:none;">
                                    <div class="col-md-4"
                                         style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                        <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}"
                                             height="10" width="120">
                                    </div>
                                    <div class="col-md-4" style="padding-left:5%; background-color: #f2f2f2; padding-top:3%;padding-bottom:3%;">
                                        <p style="margin-top: 25px; font-size: 22px; font-weight: bold;">{{ $editData->project_name }} Deliverable List</p>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @if($maxAmendmentDeliverable>0)
                                        @for($q=$maxAmendmentDeliverable; $q>=0; $q--)
                                            <div class="card-block">

                                                <div class="card">
                                                    <div class="card-header">
                                                        @if($q!=0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Amendment No: {{$q}}
                                                                </strong>

                                                            </div>
                                                        @endif
                                                        @if($q==0)
                                                            <div class="card-header">

                                                                <strong style="color: #00aeef">
                                                                    Original Contract
                                                                </strong>

                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table id="basic-btn"
                                                                   class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Sl No.</th>
                                                                    <th>Project Phase</th>
                                                                    <th>Deliverable Name</th>
                                                                    <th>Amount Percentage</th>
                                                                    <th>Amount</th>
                                                                    <th>Delivery Status</th>
                                                                    <th>Received Amount</th>
                                                                    <th>Receive Date</th>
                                                                    <th>Description</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(isset($editData->deliverable))
                                                                    @php $i = 1 @endphp
                                                                    @foreach($editData->deliverable as $deliverable)
                                                                        @if($deliverable ->amendment == $q)
                                                                            <tr>
                                                                                <td>{{ $i++ }}</td>
                                                                                <td>
                                                                                    00{{ $deliverable->project_phase }}</td>
                                                                                <td>{{ $deliverable->report_name }}</td>
                                                                                <td>{{ $deliverable->amount_percentage }}</td>
                                                                                <td>{{  number_format($deliverable->total_amount,2,".",",") }}</td>
                                                                                <td style="color: blue">{{ ucfirst($deliverable->status) }}</td>
                                                                                <td>{{  number_format($deliverable->amount_received,2,".",",") }}</td>
                                                                                <td>
                                                                                    @if(isset($deliverable->receive_date))
                                                                                        {{ date('d-M-Y', strtotime($deliverable->receive_date)) }}
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ $deliverable->description }}</td>
                                                                                <td>
                                                                                    @can('Edit Project Deliverable')
                                                                                        <a href="{{ route('project_deliverable.show',$deliverable->id) }}"
                                                                                           title="View">
                                                                <button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button>
                                                            </a>
                                                            <a href="{{ url('project_deliverable/'.$deliverable->id.'/edit') }}" title="Edit">
                                                                <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                            </a>
                                                                                        {{--                                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteTaskView',$report->id)}}">--}}
                                                                                        {{--                                                                <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
                                                                                        {{--                                                            </a>--}}
                                                                                    @endcan
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                    <div class="card-block">

                                        <div class="card">

                                            <div class="card-header">
                                                @if($maxAmendmentDeliverable>0)
                                                    <strong style="color: #00aeef">
                                                        Contract & Amendment
                                                    </strong>
                                                @endif
                                                    @if($maxAmendmentDeliverable==0)
                                                        <strong style="color: #00aeef">
                                                           Original Contract
                                                        </strong>
                                                    @endif
                                            </div>

                                            <div class="card-block">
                                                <div class="table-responsive">
                                                    <table id="basic-btn" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Sl No.</th>
                                                            <th>Project Phase</th>
                                                            <th>Deliverable Name</th>
                                                            <th>Amount Percentage</th>
                                                            <th>Amount</th>
                                                            <th>Delivery Status</th>
                                                            <th>Received Amount</th>
                                                            <th>Receive Date</th>
                                                            <th>Description</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($editData->deliverable))
                                                            @php $i = 1 @endphp
                                                            @foreach($editData->deliverable as $deliverable)

                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td> 00{{ $deliverable->project_phase }}</td>
                                                                    <td>{{ $deliverable->report_name }}</td>
                                                                    <td>{{ $deliverable->amount_percentage }}</td>
                                                                    <td>{{  number_format($deliverable->total_amount,2,".",",") }}</td>
                                                                    <td style="color: blue">{{ ucfirst($deliverable->status) }}</td>
                                                                    <td>{{  number_format($deliverable->amount_received,2,".",",") }}</td>
                                                                    <td>
                                                                        @if(isset($deliverable->receive_date))
                                                                            {{ date('d-M-Y', strtotime($deliverable->receive_date)) }}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $deliverable->description }}</td>
                                                                    <td>
                                                                        @can('Edit Project Deliverable')
                                                                            <a href="{{ route('project_deliverable.show',$deliverable->id) }}"
                                                                               title="View">
                                                                                        <button type="button" class="btn btn-success action-icon"><i class="fa fa-eye"></i></button>
                                                                                    </a>
                                                                                    <a href="{{ url('project_deliverable/'.$deliverable->id.'/edit') }}" title="Edit">
                                                                                        <button type="button" class="btn btn-info action-icon"><i class="fa fa-edit"></i></button>
                                                                                    </a>
                                                                                    {{--                                                            <a class="modalLink" title="Delete" data-modal-size="modal-md" href="{{url('deleteTaskView',$report->id)}}">--}}
                                                                                    {{--                                                                <button type="button" class="btn btn-danger action-icon"><i class="fa fa-trash-o"></i></button>--}}
                                                                                    {{--                                                            </a>--}}
                                                                                @endcan
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

                                <div class="text-bottom text-center pt-5 mt-5 footer" style="display: none" id="footer">
                                    <div class="row">
                                        <div class="col">
                                            <p style="font-size: 0.9rem; background-color: #ece7e4; color: black" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime108"> </p>
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
</div>

<script>
    $('#reminder_table').DataTable();
    $('.back_btn').hide();

    function printReportsDiv(project_reports)
    {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();

        var dt = new Date();
        document.getElementById("datetime109").innerHTML = dt.toLocaleString();
        document.getElementById("action").style.display = "none";
        document.getElementById("action1").style.display = "none";
        var printContents = document.getElementById(project_reports).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title=project_name + ' Reporting List';
        window.print();
        window.location.href = "/epc/project/"+project_id;
    }
    function printDeliverableDiv(project_deliverable)
    {
        $('.back_btn').hide();
        $('.logo').show();
        $('.footer').show();
        var dt = new Date();
        document.getElementById("datetime108").innerHTML = dt.toLocaleString();

        var printContents = document.getElementById(project_deliverable).innerHTML;
        var project_id = document.getElementById('project_id').value;
        var project_name = document.getElementById('project_name').value;
        document.body.innerHTML = printContents;
        document.title=project_name + ' Deliverable List';
        window.print();
        window.location.href = "/epc/project/"+project_id;
    }

</script>
