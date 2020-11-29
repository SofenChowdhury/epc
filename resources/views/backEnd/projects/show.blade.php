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
                        <a class="nav-link active tab_style" data-toggle="tab" href="#personal" role="tab">Project Details</a>
                        <div class="slide"></div>
                    </li>
                    @endcan
                    @can('View Project Employee List')
                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#financial" role="tab">Project Financial</a>
                        </li>
                    @endcan
                    @can('View Project Materials')
                        <li class="nav-item">
                            <a class="nav-link tab_style" data-toggle="tab" href="#materials" role="tab">Project Materials</a>
                        </li>
                    @endcan
                        @if($editData->project_phase != 1)
                    @canany(['Add Task','View Task'])
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#tasks" role="tab">Tasks</a>
                    </li>
                        @endcanany
                        @endif
                    @can('view Project Payment')
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#expenses" role="tab">Project Expenses</a>
                        <!-- <div class="slide"></div> -->
                    </li>
                        @endcan
                    @can('view Project Documents')
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#provided_documents" role="tab">
{{--                            @if($editData->project_status == 'completed')--}}
                            @if($editData->project_phase >= 3)
                                Project Closeout/Cancelled
                            @else
                                Archived Documents
                            @endif
                        </a>
                        <!-- <div class="slide"></div> -->
                    </li>
                            @endcan
                </ul>
            </div>
            <div class="tab-content">
                @can('view Project Details')
                    @include('backEnd.projects.show.details')
                @endcan

                @can('View Project Employee List')
                    @include('backEnd.projects.show.financial')
                @endcan

                @can('View Project Materials')
                    @include('backEnd.projects.show.materials')
                @endcan

                @canany(['Add Task','View Task'])
                    @include('backEnd.projects.show.tasks')
                @endcan

                @can('view Project Payment')
                    @include('backEnd.projects.show.payments')
                @endcan

                @can('view Project Documents')
                    @include('backEnd.projects.show.documents')
                @endcan

            </div>
        </div>
	</div>
</div>

@endSection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#project_employee').DataTable();
            $('.project_materials').DataTable();
            $('#reminder_table').DataTable();
            $('#budget_table').DataTable();
            $('.payment_table').DataTable();
        } );

        function printDiv(personal)
        {
            $('.printBtn').hide();
            $('.logo').show();
            $('.footer').show();
            // document.getElementById('logo').style.display = "block";
            // document.getElementById('footer').style.display = "block";
            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(personal).innerHTML;
            var project_id = document.getElementById('project_id').value;
            var project_name = document.getElementById('project_name').value;
            document.body.innerHTML = printContents;
            document.title=project_name + ' Details';
            window.print();
            window.location.href = "/epc/project/"+project_id;
        }

        function printEmployeesDiv(project_employees)
        {
            $('.logo').show();
            $('.footer').show();
            var dt = new Date();
            document.getElementById("datetime1").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(project_employees).innerHTML;
            var project_id = document.getElementById('project_id').value;
            var project_name = document.getElementById('project_name').value;
            document.body.innerHTML = printContents;
            document.title=project_name + ' Employees List';
            window.print();
            window.location.href = "/epc/project/"+project_id;
        }

        function printPaymentsDiv(payments)
        {
            $('.printBtn').hide();
            $('.logo').show();
            $('.footer').show();
            var dt = new Date();
            document.getElementById("datetime2").innerHTML = dt.toLocaleString();

            var printContents = document.getElementById(payments).innerHTML;
            var project_id = document.getElementById('project_id').value;
            var project_name = document.getElementById('project_name').value;
            document.body.innerHTML = printContents;
            document.title=project_name + ' Payment Details';
            window.print();
            window.location.href = "/epc/project/"+project_id;
        }
    </script>
@endsection
