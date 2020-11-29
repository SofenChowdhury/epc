@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add To Stock</h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'inventory/'.$product->id, 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}

            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="product"><span class="important">*</span> Product </label>
                    <select class="js-example-basic-single col-sm-12" name="product" id="product" disabled>
                        <option value="{{ $product->product->product }}">{{ $product->product->product }}</option>
                    </select>
                    @if ($errors->has('product'))
                        <span class="invalid-feedback" role="alert">
							<span class="messages"><strong>{{ $errors->first('product') }}</strong></span>
						</span>
                    @endif
                </div>
                <div class="form-group col-md-3">

                    <label for="location">Status</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('status') ? ' is-invalid' : '' }}"
                            name="status" id="status">

                        @if(isset($product))

                            <option value="0" {{ isset($product) && $product->status == 0 ? 'selected' : '' }}>
                                sold
                            </option>
                            <option value="1" {{ isset($product) && $product->status == 1 ? 'selected' : '' }}>
                                present
                            </option>
                        @endif
                    </select>
                    @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert">
                        <span class="messages"><strong>{{ $errors->first('location') }}</strong></span>
                    </span>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="serial_no">Identification Serial No</label>
                    <input type="text" class="form-control {{ $errors->has('serial_no') ? ' is-invalid' : '' }}"
                           value="{{ $product->serial_no }}" name="serial_no"/>
                    @if ($errors->has('serial_no'))
                        <span class="invalid-feedback" role="alert">
                        <span class="messages"><strong>{{ $errors->first('serial_no') }}</strong></span>
                    </span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="brand_name">Brand Name</label>
                    <input type="text" class="form-control {{ $errors->has('brand_name') ? ' is-invalid' : '' }}" value="{{ $product->brand_name }}" name="brand_name"/>
                    @if ($errors->has('brand_name'))
                        <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('brand_name') }}</strong></span>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">

            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="location">Location</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" id="location">
                        <option value="">Select location</option>
                        @if(isset($locations))
                            @foreach($locations as $key=>$value)
                                <option value="{{$value->id}}" {{ isset($product) && $product->location == $value->id ? 'selected' : '' }}>
                                    {{$value->location}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert" >
                        <span class="messages"><strong>{{ $errors->first('location') }}</strong></span>
                    </span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="room_no">Room Number</label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('room_no') ? ' is-invalid' : '' }}" name="room_no" id="room_no">
                        <option value="">Select Room Number</option>
                        @if(isset($rooms))
                            @foreach($rooms as $key=>$value)
                                <option value="{{$value->id}}" {{ isset($product) && $product->room_no == $value->id ? 'selected' : '' }}>
                                    {{$value->room_no}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('room_no'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('room_no') }}</strong></span>
						</span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <label for="price">Purchase Date </label>
                    <input type="" class="form-control datepicker {{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ isset($product->purchase_date) ? date('d-m-Y', strtotime($product->purchase_date)) : '' }}" name="purchase_date"/>
                    @if ($errors->has('purchase_date'))
                        <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('purchase_date') }}</strong></span>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-3">
                    <input type="hidden" name="coa_id" value="{{$product->coa_id}}" readonly>
                    <label for="payment_method">Payment Method </label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="payment_method" >
                        <option value="0" @if($product->payment_method == 0) selected @endif>By Cash</option>
                        <option value="1" @if($product->payment_method == 1) selected @endif>By Cheque</option>
                    </select>
                </div>
            </div>

            <div class="row">
                @if($product->category == 1)
                <div class="form-group col-md-3">
                    <label for="quantity"> Quantity  </label>
                    <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ $product->quantity }}" name="quantity"/>
                    @if ($errors->has('quantity'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
						</span>
                    @endif
                </div>
                @endif

                <div class="form-group col-md-3">
                    <label for="price">Price in Tk</label>
                    <input type="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ $product->price }}" name="price"/>

                    @if ($errors->has('price'))
                        <span class="invalid-feedback" role="alert" >
							<span class="messages"><strong>{{ $errors->first('price') }}</strong></span>
						</span>
                    @endif
                </div>

                    @if($product->category != 1)
                        <div class="form-group col-md-3">
                        <label for="depreciation_rate">Depreciation Rate</label>
                        <input type="text" class="form-control {{ $errors->has('depreciation_rate') ? ' is-invalid' : '' }}" value="{{ $product->depreciation_rate }}" name="depreciation_rate"/>
                        @if ($errors->has('depreciation_rate'))
                            <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('depreciation_rate') }}</strong></span>
                                </span>
                        @endif
                    </div>
                    @endif

                    @if($product->category == 3)
                        <div class="form-group col-md-3">
                            <label for="chasis_no">Chasis Number</label>
                            <input type="text" class="form-control {{ $errors->has('chasis_no') ? ' is-invalid' : '' }}" value="{{ $product->chasis_no }}" name="chasis_no"/>
                            @if ($errors->has('chasis_no'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('chasis_no') }}</strong></span>
                            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="cc">CC</label>
                            <input type="text" class="form-control {{ $errors->has('cc') ? ' is-invalid' : '' }}" value="{{ $product->cc }}" name="cc"/>
                            @if ($errors->has('cc'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('cc') }}</strong></span>
                            </span>
                            @endif
                        </div>
                    @endif

                <div class="form-group col-md-6">
                    <label for="vendor_id">Vendor Name </label>
                    <select class="js-example-basic-single col-sm-12 {{ $errors->has('vendor_id') ? ' is-invalid' : '' }}" name="vendor_id" id="vendor_id">
                        <option value="">Select Vendor</option>
                        @if(isset($vendors))
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>{{$vendor->vendor_name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('vendor_id'))
                        <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('vendor_id') }}</strong></span>
                            </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="upload_document">Upload Voucher</label>
                    <input data-preview="#preview" class="form-control" type="file" name="upload_document" id="upload_document">
                    @if ($errors->has('upload_document'))
                        <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('upload_document') }}</strong></span>
                        </span>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="description">Description </label>
                    <textarea class="form-control" name="description">{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                    <a class="" title="Back" href="{{URL::previous()}}">
                        <button type="button" class="btn btn-primary m-b-0">Cancel</button>
                    </a>
                </div>
                <div class="col-sm-6 text-center">
                    <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
            {{ Form::close()}}
        </div>
    </div>

@endSection
