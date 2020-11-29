<div class="tab-pane" id="provided_documents" role="tabpanel">
    <div class="tab-pane" role="tabpanel">
        <div class="row">
            <div class="col-xl-12">
                @if($editData->project_phase >= 3)

                    {{--                @if($editData->project_status == 'completed')--}}
                    <div class="tab-header card">
                        <ul class="nav nav-tabs nav-fill tab-timeline" role="tablist" id="innertab">
                            <li class="nav-item">
                                <a class="nav-link active tab_style" data-toggle="tab" href="#archived" role="tab">Archived Documents</a>
                                <div class="slide"></div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#lesson" role="tab">Lesson Learned</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#paperwork" role="tab">Complete Paperwork</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link tab_style" data-toggle="tab" href="#sign_off" role="tab">Project Director's Sign Off</a>
                            </li>
                        </ul>
                    </div>
                @endif

                <div class="tab-content">
                    <div class="tab-pane active" id="archived" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                @if( isset($editData->project_name) )
                                    <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                @else
                                    <h5 class="card-header-text">No Project Name</h5>
                                @endif
                                <br>
                                <a href="#upload_document" class="btn btn-success collapsible" data-toggle="collapse" style="float: right; padding: 8px; color: white;">Upload Document</a>
                            </div>
                            <div class="card-block">
                                <div class="collapse" id="upload_document">
                                    {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/uploadDocument/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
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
                                                        <input data-preview="#preview" class="form-control" type="file" name="upload_document" id="upload_document">
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
                                                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
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
                                            <th>Project Phase</th>
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
                                        @if(isset($documents))
                                            @foreach($documents as $document)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td> 00{{ $document->project_phase }}</td>
                                                    <td>{{ date('d-M-Y H:s:i', strtotime($document->created_at)) }}</td>
                                                    <td>{{ $document->document_name }}</td>
                                                    <td>
                                                        @foreach( $users as $user )
                                                            @if( $document->created_by == $user->id)
                                                                {{ $user->name }}
                                                            @endif
                                                        @endforeach
                                                    </td>

                                                    <td>{{$document->description }}
{{--                                                        @if ( strlen(strip_tags( $document->description ) ) > 50)--}}
{{--                                                            <a href="" data-toggle="modal" data-target="#documentModal_{{ $document->id}}">--}}
{{--                                                                <i class="fa fa-angle-double-right" style="font-size: 1em; color: #11c15b;"></i>--}}
{{--                                                            </a>--}}
{{--                                                            @include('backEnd.textModal', ['id'=>'documentModal_'.$document->id, 'title'=> $document->document_name , 'content'=>$document->description])--}}
{{--                                                        @endif--}}
                                                    </td>
                                                    <td><a href="{{url('project/document/'.$document->id)}}" target="_blank"><button type="button" class="btn btn-sm" style="background-color: lightgrey; font-size: 1.05em;">Read File</button></a>
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

                    @if($editData->project_phase >= 3)
                        {{--                    @if($editData->project_status == 'completed')--}}
                        {{--// LESSON TAB STARTS--}}
                        <div class="tab-pane" id="lesson" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/lesson/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="form-group row col-md-10 offset-md-1">
                                                    <div class="form-group col-md-10">
                                                        <label for="lesson"><strong><span class="important">*</span> Lesson Learned:</strong></label>
                                                        <textarea class="form-control {{ $errors->has('lesson') ? ' is-invalid' : '' }}" name="lesson">{{ old('lesson') }}</textarea>
                                                        <p style="color: darkred">Maximum 350 characters</p>
                                                        @if ($errors->has('lesson'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('lesson') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="lesson_table" class="table table-striped table-bordered payment_table">
                                                    <thead>
                                                    <tr>
                                                        <th>Lessom learner</th>
                                                        <th>Added By</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($editData->lessons))
                                                        @php $i = 1 @endphp
                                                        @foreach($editData->lessons as $lesson)
                                                            <tr>
                                                                <td>{{ $lesson->lesson }}</td>
                                                                <td> {{ $lesson->user->name }}</td>
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
                        {{--// LESSON ENDS--}}

                        {{--// PAPERWORK TAB STARTS--}}
                        <div class="tab-pane" id="paperwork" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/check_list/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <input type="checkbox" name="certificate" value="1" {{ isset($editData->checklist) && $editData->checklist->certificate ? 'checked' : '' }}>
                                                        <label for="certificate"><strong>Received Completion Certificate</strong></label>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="checkbox" name="payment" value="1" {{ isset($editData->checklist) && $editData->checklist->payment ? 'checked' : '' }}>
                                                        <label for="payment"><strong>Received final payment</strong></label>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="checkbox" name="report" value="1" {{ isset($editData->checklist) && $editData->checklist->report ? 'checked' : '' }}>
                                                        <label for="report"><strong>Submit completion report</strong></label>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <input type="checkbox" name="other" value="1" {{ isset($editData->checklist) && $editData->checklist->other ? 'checked' : '' }}>
                                                        <input type="text" name="other_name" value="{{ isset($editData->checklist->other_name) ? $editData->checklist->other_name : '' }}">
                                                    </div>
                                                    <div class="form-group col-md-8">
                                                        <label for="remark"><strong>Remark</strong></label>
                                                        <input type="text" class="form-control {{ $errors->has('remark') ? ' is-invalid' : '' }}" name="remark" value="{{ isset($editData->checklist->remark) ? $editData->checklist->remark : '' }}">
                                                        <p style="color: darkred">Maximum 100 characters</p>
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;"/>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>

                                    <div class="table-responsive col-md-10 offset-md-1">
                                        <table id="check_table" class="table table-striped table-bordered payment_table">
                                            <tbody>
                                            @if(isset($editData->checklist))
                                                <tr>
                                                    <td>Received Completion Certificate</td>
                                                    <td style="color: blue">{{ $editData->checklist->certificate ? 'Yes' : 'No' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Received final payment</td>
                                                    <td style="color: blue">{{ $editData->checklist->payment ? 'Yes' : 'No' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Submit completion report</td>
                                                    <td style="color: blue">{{ $editData->checklist->report ? 'Yes' : 'No' }}</td>
                                                </tr>
                                                @if(isset($editData->checklist->other_name))
                                                <tr>
                                                    <td>{{ $editData->checklist->other_name }}</td>
                                                    <td style="color: blue">{{ $editData->checklist->other ? "Yes" : 'No' }}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>Remark</td>
                                                    <td>{{ $editData->checklist->remark ? $editData->checklist->remark : '' }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--// PAPERWORK ENDS--}}

                        {{--// SIGN OFF TAB STARTS--}}
                        <div class="tab-pane" id="sign_off" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    @if( isset($editData->project_name) )
                                        <h5 class="card-header-text" style="font-size: 1rem;">{{ $editData->project_name }}</h5>
                                    @else
                                        <h5 class="card-header-text">No Project Name</h5>
                                    @endif
                                    <br>
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <div class="card-block">
                                            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/sign_off/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="form-group row col-md-12">
                                                    <div class="form-group col-md-6">
                                                        <label for="remark"><strong>Remark:</strong></label>
                                                        <textarea class="form-control {{ $errors->has('remark') ? ' is-invalid' : '' }}" name="remark" required>{{ old('remark') }}</textarea>
                                                        <p style="color: darkred">Maximum 350 characters</p>
                                                        @if ($errors->has('remark'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <span class="messages"><strong>{{ $errors->first('remark') }}</strong></span>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="remark_date"><strong>Date:</strong></label>
                                                        <input type="" class="form-control datepicker {{ $errors->has('remark_date') ? ' is-invalid' : '' }}" value="{{ old('remark_date') }}" name="remark_date" required/>
                                                        @if ($errors->has('remark_date'))
                                                            <span class="invalid-feedback" role="alert">
                                                                    <span class="messages"><strong>{{ $errors->first('remark_date') }}</strong></span>
                                                                </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="remark_time"><strong>Time:</strong></label>
                                                        <input type="time" class="form-control {{ $errors->has('remark_time') ? ' is-invalid' : '' }}" value="{{ old('remark_time') }}" name="remark_time" required/>
                                                        @if ($errors->has('remark_time'))
                                                            <span class="invalid-feedback" role="alert">
                                                                    <span class="messages"><strong>{{ $errors->first('remark_time') }}</strong></span>
                                                                </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group col-md-2">
                                                        <label for="submit"></label>
                                                        <input type="submit" class="form-control btn btn-primary m-b-0" style="margin-top: 5px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close()}}
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sign_off_table" class="table table-striped table-bordered payment_table">
                                                    <thead>
                                                    <tr>
                                                        <th>SL.</th>
                                                        <th>Sign Off Remark</th>
                                                        <th>Written By</th>
                                                        <th>Written On</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($editData->sign_offs))
                                                        @php $i = 1 @endphp
                                                        @foreach($editData->sign_offs as $sign_off)
                                                            <tr>
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $sign_off->remark }}</td>
                                                                <td> {{ $sign_off->user->name }}</td>
                                                                <td>
                                                                    @if(isset($sign_off->remark_date))
                                                                        {{ date('d F, Y'), strtotime($sign_off->remark_date) }}
                                                                    @endif
                                                                    @if(isset($sign_off->reamrk_time))
                                                                        {{ date('h:i A'), strtotime($sign_off->reamrk_time) }}
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
                        {{--// SIGN OFF ENDS--}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
