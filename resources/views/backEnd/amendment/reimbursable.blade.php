@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'project/budget/'.$editData->id, 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            {{csrf_field()}}
            <input type="hidden" name="amendment" value="{{$maxAmendment+1}}">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="title"><strong>Amendment No:</strong></label>
                    <input type="text" class="form-control {{ $errors->has('amendment') ? ' is-invalid' : '' }}"
                           value="{{$maxAmendment+1}}" disabled/>
                    @if ($errors->has('amendment'))
                        <span class="invalid-feedback" role="alert">
                                                            <span
                                                                class="messages"><strong>{{ $errors->first('amendment') }}</strong></span>
                                                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group row col-md-12">
                    <div class="form-group col-md-3">
                        <label for="expense_name"><strong><span class="important">*</span> Expense
                                Name:</strong></label>
                        <input type="" class="form-control {{ $errors->has('expense_name') ? ' is-invalid' : '' }}"
                               value="{{ old('expense_name') }}" name="expense_name" required/>
                        <p style="color: darkred">Maximum 150 characters</p>
                        @if ($errors->has('expense_name'))
                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('expense_name') }}</strong></span>
                                                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="unit"><strong> Unit:</strong></label>
                        <input type="" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                               value="{{ old('unit') }}" name="unit"/>
                        @if ($errors->has('unit'))
                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="unit_cost"><strong><span class="important">*</span> Unit Cost
                                (BDT):</strong></label>
                        <input type="number" step="0.01"
                               class="form-control {{ $errors->has('unit_cost') ? ' is-invalid' : '' }}"
                               value="{{ old('unit_cost') }}" name="unit_cost" required/>
                        @if ($errors->has('unit_cost'))
                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit_cost') }}</strong></span>
                                                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="quantity"><strong><span class="important">*</span> Quantity:</strong></label>
                        <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                               value="{{ old('quantity') }}" name="quantity" required/>
                        @if ($errors->has('quantity'))
                            <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                            </span>
                        @endif
                    </div>
                </div>

                <div class="collapse row col-md-12" id="add_exp">
                    @for($i=1; $i<=4; $i++)
                        <div class="form-group row col-md-12">
                            <div class="form-group col-md-3">
                                <label for="expense_name"><strong><span class="important">*</span> Expense
                                        Name:</strong></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('expense_name') ? ' is-invalid' : '' }}"
                                       value="{{ old('expense_name') }}" name="expense_name_{{$i}}"/>
                                <p style="color: darkred">Maximum 150 characters</p>
                                @if ($errors->has('expense_name'))
                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('expense_name') }}</strong></span>
                                                            </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="unit"><strong> Unit:</strong></label>
                                <input type="text" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                       value="{{ old('unit') }}" name="unit_{{$i}}"/>
                                @if ($errors->has('unit'))
                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                                            </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="unit_cost"><strong><span class="important">*</span> Unit Cost
                                        (BDT):</strong></label>
                                <input type="number" step="0.01"
                                       class="form-control {{ $errors->has('unit_cost') ? ' is-invalid' : '' }}"
                                       value="{{ old('unit_cost') }}" name="unit_cost_{{$i}}"/>
                                @if ($errors->has('unit_cost'))
                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('unit_cost') }}</strong></span>
                                                            </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="quantity"><strong><span class="important">*</span>
                                        Quantity:</strong></label>
                                <input type="number"
                                       class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}"
                                       value="{{ old('quantity') }}" name="quantity_{{$i}}"/>
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback" role="alert">
                                                                <span
                                                                    class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                                            </span>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="form-group row col-md-12">
                    <div class="form-group col-md-2">
                        <label for="add"></label>
                        <a href="#add_exp" class="form-control btn btn-primary m-b-0 collapsible" data-toggle="collapse"
                           style="margin-top: 5px; color: white;">Add Row</a>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="submit"></label>
                        <input type="submit" class="form-control btn btn-primary m-b-0"
                               style="margin-top: 5px;"/>
                    </div>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>
@endsection
