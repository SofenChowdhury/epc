@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Edit Project</h5>
        </div>
        <div class="card-block">
            <form method="post" action="{{ route('project.update', $editData->id) }}" autocomplete="off">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="project_code">Project ID :</label>
                        <input type="text" class="form-control  {{ $errors->has('project_code') ? ' is-invalid' : '' }}" value="{{ $editData->project_code }}" name="project_code" />
                        @if ( $errors->has('project_code') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_code') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="project_phase">Phase :</label>
                        <select class="js-example-basic-single col-sm-12" name="project_phase" id="project_phase" disabled>
                            @if(isset($phases))
                                @foreach($phases as $phase)
                                    <option value="{{$phase->defined_id}}" {{ isset($editData) && $editData->project_phase == $phase->defined_id ? 'selected' : '' }}>
                                        - {{$phase->defined_id}} {{$phase->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('project_phase'))
                            <span class="invalid-feedback invalid-select" role="alert"><strong class="messages">{{ $errors->first('project_phase') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="contract_type">Contract Type :</label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('contract_type') ? ' is-invalid' : '' }}" name="contract_type" id="contract_type">
                            <option value="3" @if($editData->contract_type == 3) selected @endif>Lead</option>
                            <option value="2" @if($editData->contract_type == 2) selected @endif>Subconsultant</option>
                            <option value="1" @if($editData->contract_type == 1) selected @endif>Joint Venture</option>
                        </select>
                        @if ( $errors->has('contract_type') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('contract_type') }}</strong></span></span>
                        @endif
                    </div>

                    <div id="jv_input" class="form-group col-md-6 row">
                        <div class="form-group col-md-6">
                            <label for="epc_lead">Lead :</label>
                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('epc_lead') ? ' is-invalid' : '' }}" name="epc_lead" id="epc_lead">
                                <option value="0" @if($editData->epc_lead == 0) selected @endif>Lead</option>
                                <option value="1" @if($editData->epc_lead == 1) selected @endif>Local Lead</option>
                                <option value="2" @if($editData->epc_lead == 2) selected @endif>International Lead</option>
                            </select>
                            @if ( $errors->has('epc_lead') )
                                <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('epc_lead') }}</strong></span></span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="epc_share_percentage">EPC Share (%) :</label>
                            <input type="text" class="form-control  {{ $errors->has('epc_share_percentage') ? ' is-invalid' : '' }}" value="{{ $editData->epc_share_percentage }}" name="epc_share_percentage" />
                            @if ( $errors->has('epc_share_percentage') )
                                <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('epc_share_percentage') }}</strong></span></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="project_full_name">Project Full Name :</label>
                        <input type="text" class="form-control {{ $errors->has('project_full_name') ? ' is-invalid' : '' }}" name="project_full_name" value="{{$editData->project_full_name }}" />
                        @if ($errors->has('project_full_name'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_full_name') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="project_component">Project Component :</label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('project_component') ? ' is-invalid' : '' }}" name="project_component" id="project_component">
                            @if(isset($components))
                                @foreach($components as $component)
                                    <option value="{{$component->id}}"
                                            @if($editData->project_component == $component->id) selected @endif
                                    >{{$component->component_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ( $errors->has('project_component') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_component') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="procuring_entity">Procuring Entity Name :</label>
                        <input type="text" class="form-control  {{ $errors->has('procuring_entity') ? ' is-invalid' : '' }}" value="{{$editData->procuring_entity }}" name="procuring_entity" />
                        @if ( $errors->has('procuring_entity') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('procuring_entity') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="procurement_entity_code">Procurement Entity Code :</label>
                        <input type="" class="form-control {{ $errors->has('procurement_entity_code') ? ' is-invalid' : '' }}" value="{{$editData->procurement_entity_code }}" name="procurement_entity_code"/>
                        @if ($errors->has('procurement_entity_code'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('procurement_entity_code') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="procuring_entity_district">Procurement Entity District :</label>
                        <input type="text" class="form-control  {{ $errors->has('procuring_entity_district') ? ' is-invalid' : '' }}" value="{{$editData->procuring_entity_district }}" name="procuring_entity_district" />
                        @if ( $errors->has('procuring_entity_district') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('procuring_entity_district') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="eoi_publication_date"><span class="important">*</span> EOI Publication Date :</label>
                        <input type="" class="form-control datepicker  {{ $errors->has('eoi_publication_date') ? ' is-invalid' : '' }}" value="{{ isset($project_phase->phase_start_date) ? date('d F, Y', strtotime($project_phase->phase_start_date)) : '' }}" name="eoi_publication_date"/>
                        @if ( $errors->has('eoi_publication_date') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_publication_date') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="eoi_reference">EOI Reference No. :</label>
                        <input type="text" class="form-control  {{ $errors->has('eoi_reference') ? ' is-invalid' : '' }}" value="{{$editData->eoi_reference }}" name="eoi_reference" />
                        @if ( $errors->has('eoi_reference') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_reference') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="eoi_selection">EOI Selection of :</label>
                        <input type="text" class="form-control  {{ $errors->has('eoi_selection') ? ' is-invalid' : '' }}" value="{{$editData->eoi_selection }}" name="eoi_selection" />
                        @if ( $errors->has('eoi_selection') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_selection') }}</strong></span></span>
                        @endif
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="procurement_method">Procurement Method :</label>
                        <input type="text" class="form-control  {{ $errors->has('procurement_method') ? ' is-invalid' : '' }}" value="{{$editData->procurement_method }}" name="procurement_method" />
                        @if ( $errors->has('procurement_method') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('procurement_method') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="funded_by">Source of Fund :</label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('funded_by') ? ' is-invalid' : '' }}" name="funded_by" id="funded_by">
                            <option value="">Select Client Name</option>
                            @if(isset($clients))
                                @foreach($clients as $key=>$value)
                                    <option value="{{$value->id}}" {{ isset($editData) && $editData->funded_by == $value->id ? 'selected' : '' }}>{{$value->client_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('funded_by'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('funded_by') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="development_partners">Development Partners :</label>
                        <input type="" class="form-control {{ $errors->has('development_partners') ? ' is-invalid' : '' }}" value="{{ $editData->development_partners }}" name="development_partners"/>
                        @if ($errors->has('development_partners'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('development_partners') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="project_type">Project type :</label>
                        <select class="js-example-basic-single col-sm-12" name="project_type[]" id="project_type" multiple data-placeholder="{{ $editData->project_type }}">
                            @if(isset($types))
                                @foreach($types as $type)
                                    <option value="{{ $type->type_name }}" {{ $editData->project_type== $type->type_name ? 'selected' : ''  }}>{{$type->type_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('project_type'))
                            <span class="invalid-feedback invalid-select" role="alert"><strong class="messages">{{ $errors->first('project_type') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="project_status"><span class="important">*</span> Project Status :</label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('project_status') ? ' is-invalid' : '' }}" name="project_status" id="project_status">
                            @if(isset($statuses))
                                @foreach($statuses as $status)
                                    <option value="{{$status->name}}" {{ isset($editData) && $editData->project_status == $status->name ? 'selected' : '' }}>{{ ucfirst($status->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('project_status'))
                            <span class="invalid-feedback invalid-select" role="alert"><strong class="messages">{{ $errors->first('project_status') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="programme_code">Programme Code :</label>
                        <input type="" class="form-control {{ $errors->has('programme_code') ? ' is-invalid' : '' }}" value="{{ $editData->programme_code }}" name="programme_code"/>
                        @if ($errors->has('programme_code'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('programme_code') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="programme_name">Programme Name :</label>
                        <input type="" class="form-control {{ $errors->has('programme_name') ? ' is-invalid' : '' }}" value="{{ $editData->programme_name }}" name="programme_name" />
                        @if ( $errors->has('programme_name') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('programme_name') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="eoi_due_date">EOI Submission Date :</label>
                        <input type="" class="form-control datepicker {{ $errors->has('eoi_due_date') ? ' is-invalid' : '' }}" value="{{ isset($project_phase->phase_end_date) ? date('d F, Y', strtotime($project_phase->phase_end_date)) : '' }}" name="eoi_due_date"/>
                        @if ($errors->has('eoi_due_date'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_due_date') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="eoi_due_time">EOI Submission Time :</label>
                        <input type="time" class="form-control {{ $errors->has('eoi_due_time') ? ' is-invalid' : '' }}" value="{{ isset($project_phase->phase_end_time) ? date('h:i A', strtotime($project_phase->phase_end_time)) : '' }}" name="eoi_due_time"/>
                        @if ($errors->has('eoi_due_time'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_due_time') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="meeting_place">EOI Submission Place :</label>
                        <input type="" class="form-control {{ $errors->has('meeting_place') ? ' is-invalid' : '' }}" value="{{ $project_phase->meeting_place }}" name="meeting_place" />
                        @if ( $errors->has('meeting_place') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('meeting_place') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="eoi_date"> EOI Submitted On :</label>
                        <input type="" class="form-control datepicker {{ $errors->has('eoi_date') ? ' is-invalid' : '' }}" value="{{ isset($editData->eoi_submission_date) ? date('d F, Y', strtotime($editData->eoi_submission_date)) : '' }}" name="eoi_date" />
                        @if ( $errors->has('eoi_date') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('eoi_date') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="client_idl">Client Name :</label>
                        <select class="js-example-basic-single col-sm-12" name="client_id" id="client_id">
                            <option value="">Select Client name</option>
                            @if(isset($clients))
                                @foreach($clients as $key=>$value)
                                    <option value="{{$value->id}}" {{ isset($editData) && $editData->client_id == $value->id ? 'selected' : '' }}>
                                        {{$value->client_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('client_id'))
                            <span class="invalid-feedback invalid-select" role="alert"><span class="messages"><strong>{{ $errors->first('client_id') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label">Project Director :</label>
                        <select class="js-example-basic-single col-sm-12" name="project_director" id="project_director">
                            <option value="">Select Project Director</option>
                            @if(isset($users))
                                @foreach($users as $key=>$value)
                                    <option value="{{$value->id}}" {{ isset($editData) && $editData->project_director == $value->id ? 'selected' : '' }}>
                                        {{$value->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('project_director'))
                            <span class="invalid-feedback invalid-select" role="alert">
						<span class="messages"><strong>{{ $errors->first('project_director') }}</strong></span></span>@endif
                    </div>

                    <div class="form-group col-md-3">
                        <label class="col-form-label">Project Supervisor :</label>
                        <select class="js-example-basic-single col-sm-12" name="project_lead" id="project_lead">
                            <option value="">Select Project Supervisor</option>
                            @if(isset($users))
                                @foreach($users as $key=>$value)
                                    <option value="{{$value->id}}" {{ isset($editData) && $editData->project_lead == $value->id ? 'selected' : '' }}>
                                        {{$value->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('project_lead'))
                            <span class="invalid-feedback invalid-select" role="alert"><span class="messages"><strong>{{ $errors->first('project_lead') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="contact_person"><span class="important">*</span> Contact Person Name :</label>
                        <input type="text" class="form-control {{ $errors->has('contact_person') ? ' is-invalid' : '' }}" value="{{ $editData->contact_person }}" name="contact_person"/>
                        @if ($errors->has('contact_person'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('contact_person') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="designation">Designation :</label>
                        <input type="text" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" value="{{ $editData->designation }}" name="designation"/>
                        @if ($errors->has('designation'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('designation') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="contact_person_phone">Phone Number :</label>
                        <input type="text" class="form-control {{ $errors->has('contact_person_phone') ? ' is-invalid' : '' }}" value="{{ $editData->contact_person_phone }}" name="contact_person_phone"/>
                        @if ($errors->has('contact_person_phone'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('contact_person_phone') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="contact_person_email">Contact Person Email :</label>
                        <input type="text" class="form-control {{ $errors->has('contact_person_email') ? ' is-invalid' : '' }}" value="{{ $editData->contact_person_email }}" name="contact_person_email"/>
                        @if ($errors->has('contact_person_email'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('contact_person_email') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="contact_person_address">Contact Person Address :</label>
                        <input type="text" class="form-control {{ $errors->has('contact_person_address') ? ' is-invalid' : '' }}" value="{{ $editData->contact_person_address }}" name="contact_person_address"/>
                        @if ($errors->has('contact_person_address'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('contact_person_address') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="project_due_date">Project Submission Date :</label>
                        <input type="" class="form-control datepicker {{ $errors->has('project_start_date') ? ' is-invalid' : '' }}" name="project_due_date" value="{{ isset($editData->project_due_date) ? date('d-m-Y', strtotime($editData->project_due_date)) : ''}}"/>
                        @if ($errors->has('project_due_date'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_due_date') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="extended_date">Project Extended Date :</label>
                        <input type="" class="form-control datepicker {{ $errors->has('extended_date') ? ' is-invalid' : '' }}" name="extended_date" value="{{ isset($editData->new_deadline) ? date('d-m-Y', strtotime($editData->new_deadline)) : '' }}"/>
                        @if ($errors->has('extended_date'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('extended_date') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="project_amount">Contract Amount (in BDT) :</label>
                        <input type="number" class="form-control  {{ $errors->has('project_amount') ? ' is-invalid' : '' }}" name="project_amount" value="{{ $editData->project_amount }}"/>
                        @if ($errors->has('project_amount'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_amount') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="approx_fee">Consultancy Fee (in BDT) :</label>
                        <input type="number" class="form-control  {{ $errors->has('approx_fee') ? ' is-invalid' : '' }}" name="approx_fee" value="{{ $editData->approx_fee }}"/>
                        @if ($errors->has('approx_fee'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('approx_fee') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="execution_authority">Project Execution Authority :</label>
                        <input type="text" class="form-control {{ $errors->has('execution_authority') ? ' is-invalid' : '' }}" value="{{ $editData->execution_authority }}" name="execution_authority"/>
                        @if ($errors->has('execution_authority'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('execution_authority') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="project_source">Project Advertised By :</label>
                        <input type="text" class="form-control {{ $errors->has('project_source') ? ' is-invalid' : '' }}" value="{{ $editData->project_source }}" name="project_source"/>
                        @if ($errors->has('project_source'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('project_source') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="study_time">Time for performing study and Reporting :</label>
                        <input type="text" class="form-control {{ $errors->has('study_time') ? ' is-invalid' : '' }}" value="{{ $editData->study_time }}" name="study_time"/>
                        @if ($errors->has('study_time'))
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('study_time') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="description">Brief Description :</label>
                        <textarea class="form-control" name="description">{{ old('association') ? old('description') : $editData->description }}</textarea>
                        <p style="color: darkred">Maximum 350 characters</p>
                        @if ( $errors->has('description') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('description') }}</strong></span></span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description_2">Experience, Resources and Delivery Capacity Required  :</label>
                        <textarea class="form-control" name="description_2">{{ old('association') ? old('description_2') : $editData->description_2 }}</textarea>
                        <p style="color: darkred">Maximum 350 characters</p>
                        @if ( $errors->has('description_2') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('description_2') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="association">Association with other local/ foreign firm :</label>
                        <textarea class="form-control" name="association">{{ old('association') ? old('association') : $editData->association }}</textarea>
                        <p style="color: darkred">Maximum 350 characters</p>
                        @if ( $errors->has('association') )
                            <span class="invalid-feedback" role="alert" ><span class="messages"><strong>{{ $errors->first('association') }}</strong></span></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mt-5">
                    <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                        <a class="" title="Back" href="{{url('/project')}}">
                            <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                        </a>
                    </div>
                    <div class="col-sm-6 text-center">
                        <button type="submit" class="btn btn-primary m-b-0">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endSection

@section('javascript')
    <script>
        window.onload = function() {
            var input = document.getElementById('jv_input');
            var type = document.getElementById('contract_type');
            if(type.options[type.selectedIndex].value != 1){
                input.style.visibility = 'hidden';
            }
            type.onchange = function () {
                if (type.options[type.selectedIndex].value == 1) {
                    input.style.visibility = 'visible';
                } else {
                    input.style.visibility = 'hidden';
                }
            }
        }
    </script>
@endsection
