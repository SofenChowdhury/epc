@extends('backEnd.master')
@section('mainContent')
<div class="tab-pane" id="contacts" role="tabpanel">
    <div class="row">
        @can('Add Bonus and Advances')
        <div class="col-xl-12">
            <div class="tab-header card">
                <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="mytab">
                    <li class="nav-item">
                        <a class="nav-link active tab_style" data-toggle="tab" href="#bonus" role="tab">Employee Incentive</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#advance" role="tab">Employee Advance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#overtime" role="tab">Employee Overtime Pay</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab_style" data-toggle="tab" href="#conveyance" role="tab">Employee Conveyance</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="bonus" role="tabpanel">
                    @include('backEnd.employees.bonus.incentive')
                </div>

                <div class="tab-pane" id="advance" role="tabpanel">
                    @include('backEnd.employees.bonus.advance')
                </div>

                <div class="tab-pane" id="overtime" role="tabpanel">
                    @include('backEnd.employees.bonus.overtime')
                </div>

                <div class="tab-pane" id="conveyance" role="tabpanel">
                    @include('backEnd.employees.bonus.conveyance')
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
@endSection

@section('javascript')

@endsection
