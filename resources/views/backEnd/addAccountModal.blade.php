<div class="card">
    <div class="card-block">
        {{ Form::open(['class' => '', 'url' => 'save-coa-data', 'method' => 'POST']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-form-label"><span class="important">*</span> Account Parent</label>
                    <select class="form-control select-with-border {{ $errors->has('coa_parent') ? ' is-invalid' : '' }}" required name="coa_parent" id="coa_parent">
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <optgroup label="{{$category->category_name}}">
                                    @foreach($category->subCategoryAccounts as $subCategory)
                                        @if($subCategory->coa_parent == NULL)
                                            <!-- <option @if(isset($parentId) && $parentId == $subCategory->id) selected @endif value="{ 'coa_category': {{$category->id}}, 'coa_parent': {{$subCategory->id}} }">{{$subCategory->coa_name}}</option> -->
                                            <option @if(isset($parentId) && $parentId == $subCategory->id) selected @endif value=" {{$subCategory->id}}">{{$subCategory->coa_name}}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group input-effect">
                    <label class="col-form-label"><span class="important">*</span> Account Name</label>
                    <input type="text" class="form-control {{ $errors->has('coa_name') ? ' is-invalid' : '' }}" required name="coa_name" id="coa_name" placeholder="" value="{{old('coa_name')}}">
                </div>
                <div class="form-group input-effect">
                    <label class="col-form-label">Account Description (optional)</label>
                    <textarea rows="4" cols="57" class="form-control" name="coa_description" id="coa_description" value="{{old('coa_description')}}">
                    </textarea>
                </div>
                <div class="form-group">
                    <div class="" style="margin-top: 22px !important;">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="debit_credit_amount" id="debit_amount" value="debit" checked> Debit amount
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="debit_credit_amount" id="credit_amount" value="credit"> Credit amount
                            </label>
                        </div>
                    </div>
                </div>

                <div class="debit_div">
                    <div class="form-group">
                        <label class="col-form-label">Opening Debit Amount</label>
                        <input type="number" class="form-control {{ $errors->has('open_debit_amount') ? ' is-invalid' : '' }}" name="open_debit_amount" id="open_debit_amount"  value="{{old('open_debit_amount')}}">
                        @if ($errors->has('open_debit_amount'))
                            <span class="invalid-feedback" role="alert">
                            <span class="messages"><strong>{{ $errors->first('coa_name') }}</strong></span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="credit_div" style="display: none;">
                    <div class="form-group">
                        <label class="col-form-label">Opening Credit Amount</label>
                        <input type="number" class="form-control {{ $errors->has('open_credit_amount') ? ' is-invalid' : '' }}" name="open_credit_amount" id="open_credit_amount" value="{{old('open_credit_amount')}}">
                        @if ($errors->has('open_credit_amount'))
                            <span class="invalid-feedback" role="alert">
                            <span class="messages"><strong>{{ $errors->first('open_credit_amount') }}</strong></span>
                        </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group row mt-5">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
        {{ Form::close()}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
</div>

