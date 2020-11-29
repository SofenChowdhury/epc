@extends('backEnd.master')

@section('mainContent')
    @can('view COA')
<div class="card" id="contacts" role="tabpanel">
	<div class="row">
		<div class="col-xl-12">
            <div class="card-header">
                <h5>Chart of Accounts</h5>
            </div>
            <div class="card-body">
            @foreach($categories as $category)
                <div class="accordion-panel">
                    <div class="accordion-heading" style="background-color: #9ACCE0;" id="headingOne">
                        <h3 class="card-title accordion-title">
                            <a class="accordion-msg waves-effect waves-dark " data-toggle="collapse" data-parent="#accordion" href="#collapseOne_{{ $category->id }}" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="card-header-text">
                                    {{ $category->category_reference_no }} {{ucfirst($category->category_name)}}
                                </h5>
                            </a>
                        </h3>
                    </div>
                    <br>
                    <div id="collapseOne_{{ $category->id }}" class="panel-collapse in active collapse " role="tabpanel" aria-labelledby="headingOne">
                        @foreach( $category->header as $header )
                        <div class="accordion-panel">
                            <div class="accordion-heading" style="background-color: #c1cede;" id="headingTwo">
                                <h3 class="card-title accordion-title">
                                    <a class="accordion-msg waves-effect waves-dark active" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo_{{ $header->id }}" aria-expanded="true" aria-controls="collapseTwo">
                                        <h5 class="card-header-text">
                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $header->header_reference_no }} {{ $header->header_name }}
                                        </h5>
                                    </a>
                                </h3>
                            </div>
                            <br>
                            <div id="collapseTwo_{{ $header->id }}" class="panel-collapse in active collapse" role="tabpanel" aria-labelledby="headingTwo">
                                @foreach( $header->coa as $coa )
                                    @if($coa->active_status == 1)
                                    @if($coa->child == 1)
                                        <div class="accordion-panel">
                                            <div class="accordion-heading" style="background-color: #ebebf6;" id="headingThree">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark active" data-toggle="collapse" data-parent="#accordion" href="#collapseThree_{{ $coa->id }}" aria-expanded="true" aria-controls="collapseThree">
                                                        <h5 class="card-header-text">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $coa->coa_reference_no }}. {{ $coa->coa_name }}
                                                        </h5>
                                                    </a>
                                                </h3>
                                            </div>
                                            <br>
                                            <div id="collapseThree_{{ $coa->id }}" class="panel-collapse in active collapse" role="tabpanel" aria-labelledby="headingThree">
                                                @foreach( $coa->children as $child)
                                                    <div class="accordion-content accordion-desc">
                                                        <div class="card-block p-0 m-0">
                                                            <div class="view-info">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr style="font-size: larger;" >
                                                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;{{ $child->coa_reference_no }}. {{ $child->coa_name }}</th>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                    <div class="accordion-content accordion-desc">
                                        <div class="card-block">
                                            <div class="row">
                                                <h5 class="card-header-text">
                                                    &nbsp;&nbsp;&nbsp;{{ $coa->coa_reference_no }}. {{ $coa->coa_name }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            </div>
        </div>
	</div>
</div>
  @endcan

@endSection
