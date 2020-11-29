@extends('backEnd.master')
@section('mainContent')
    <div class="card">
        <div class="card-header">
            <h5>Add To Stock</h5>
        </div>
        <div class="card-block">
            {{ Form::open(['class' => '', 'files' => true, 'url' => 'inventory', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) }}
            @csrf
            <div class="row">
                <input type="text" class="form-control" value="{{ $category }}" name="category" hidden/>
                @if( $coa_list && isset($coas))
                    <div class="form-group col-md-6">
                        <label for="coa_parent"><span class="important">*</span> Chart of Account</label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('coa_parent') ? ' is-invalid' : '' }}" name="coa_parent">
                            <option value="">Select COA </option>
                            @foreach($coas as $coa)
                                <option value="{{ $coa->coa_reference_no }}" {{ old('coa_parent')== $coa->coa_reference_no ? 'selected' : ''  }} >{{ $coa->coa_reference_no }} {{ $coa->coa_name }} </option>
                            @endforeach
                        </select>
                        @if ($errors->has('coa_parent'))
                            <span class="invalid-feedback" role="alert" >
                            <span class="messages"><strong>{{ $errors->first('coa_parent') }}</strong></span>
                        </span>
                        @endif
                    </div>
                @endif

                @if(!$coa_list)
                    <div class="form-group col-md-6">
                        <label for="product_name"><span class="important">*</span> Product Name </label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('product_name') ? ' is-invalid' : '' }}" name="product_name" id="product_name">
                            <option value="">Select Product </option>
                            @foreach($product_lists as $product)
                                <option value="{{ $product->id }}" {{ old('product_name')== $product->id ? 'selected' : ''  }} >{{ $product->product }} </option>
                            @endforeach
                            <option value="other">New Product </option>
                        </select>
                        @if ($errors->has('product_name'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('product_name') }}</strong></span>
                            </span>
                        @endif
                    </div>
                        @endif

                @if($coa_list)
                    <div class="form-group col-md-6">
                @else
                    <div class="form-group col-md-6" id="new_product">
                        @endif
                        <label for="new_product"><span class="important">*</span> New Product Name </label>
                        <input type="text" class="form-control {{ $errors->has('new_product') ? ' is-invalid' : '' }}" value="{{ old('new_product') }}" name="new_product"/>
                        <p style="color: darkred">Maximum 50 characters</p>
                        @if ($errors->has('new_product'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('new_product') }}</strong></span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="serial_no">Identification Serial No</label>
                        <input type="text" class="form-control {{ $errors->has('serial_no') ? ' is-invalid' : '' }}" value="{{ old('serial_no') }}" name="serial_no"/>
                        @if ($errors->has('serial_no'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('serial_no') }}</strong></span>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" class="form-control {{ $errors->has('brand_name') ? ' is-invalid' : '' }}" value="{{ old('brand_name') }}" name="brand_name"/>
                        @if ($errors->has('brand_name'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('brand_name') }}</strong></span>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="price">Purchase Date </label>
                        <input type="" class="form-control datepicker {{ $errors->has('purchase_date') ? ' is-invalid' : '' }}" value="{{ old('purchase_date') }}" name="purchase_date"/>
                        @if ($errors->has('purchase_date'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('purchase_date') }}</strong></span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    @if($category == 1)
                        <div class="form-group col-md-3">
                            <label for="quantity"> Quantity</label>
                            <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" value="{{ old('quantity') ? old('quantity') : 1 }}" name="quantity"/>
                            @if ($errors->has('quantity'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('quantity') }}</strong></span>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="unit"> Unit (For new products)  </label>
                            <input type="" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}" value="{{ old('unit') }}" name="unit"/>
                            @if ($errors->has('unit'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('unit') }}</strong></span>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="price"><span class="important">*</span> Price (per unit) in Tk</label>
                            <input type="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" name="price" required/>
                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('price') }}</strong></span>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="min_amount">Minimum amount for re-ordering</label>
                            <input type="number" class="form-control {{ $errors->has('min_amount') ? ' is-invalid' : '' }}"  onchange="minInput();" value="{{ old('min_amount') ? old('min_amount') : 12 }}" name="min_amount" id="min_amount"/>
                            @if ($errors->has('min_amount'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('min_amount') }}</strong></span>
                                </span>
                            @endif
                            <br> <p6 id="err" style="color: red"></p6>
                        </div>

                    @else
                        @if($category == 2 || $category == 4)
                            <div class="form-group col-md-3">
                                <label for="location">Location</label>
                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" id="location">
                                    <option value="">Select Location</option>
                                    @if(isset($locations))
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location')== $location->id ? 'selected' : old('location')  }} >{{$location->location}}</option>
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
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_no')== $room->id ? 'selected' : old('room_no')  }} >{{$room->room_no}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('room_no'))
                                    <span class="invalid-feedback" role="alert" >
                                        <span class="messages"><strong>{{ $errors->first('room_no') }}</strong></span>
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="form-group col-md-3">
                            <label for="price">Price in Tk</label>
                            <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ old('price') }}" name="price"/>
                            @if ($errors->has('price'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('price') }}</strong></span>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label for="depreciation_rate">Depreciation Rate</label>
                            <input type="text" class="form-control {{ $errors->has('depreciation_rate') ? ' is-invalid' : '' }}" value="{{ old('depreciation_rate') }}" name="depreciation_rate"/>
                            @if ($errors->has('depreciation_rate'))
                                <span class="invalid-feedback" role="alert" >
                                    <span class="messages"><strong>{{ $errors->first('depreciation_rate') }}</strong></span>
                                </span>
                            @endif
                        </div>
                    @endif

                    @if($category == 3)
                        <div class="form-group col-md-3">
                            <label for="chasis_no">Chasis Number</label>
                            <input type="text" class="form-control {{ $errors->has('chasis_no') ? ' is-invalid' : '' }}" value="{{ old('chasis_no') }}" name="chasis_no"/>
                            @if ($errors->has('chasis_no'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('chasis_no') }}</strong></span>
                            </span>
                            @endif
                        </div>

                        <div class="form-group col-md-3">
                            <label for="cc">CC</label>
                            <input type="text" class="form-control {{ $errors->has('cc') ? ' is-invalid' : '' }}" value="{{ old('cc') }}" name="cc"/>
                            @if ($errors->has('cc'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('cc') }}</strong></span>
                            </span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="vendor_id">Vendor Name </label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('vendor_id') ? ' is-invalid' : '' }}" name="vendor_id" id="vendor_id">
                            <option value="">Select Vendor</option>
                            @if(isset($vendors))
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : old('vendor_id')  }} >{{$vendor->vendor_name}}</option>
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
                        <textarea class="form-control" value="{{ old('description') }}" name="description"></textarea>
                        <p style="color: darkred">Maximum 350 characters</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="payment_method">Payment Method </label>
                        <select class="js-example-basic-single col-sm-12 {{ $errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="payment_method" required>
                            <option value="0">By Cash</option>
                            <option value="1">By Cheque</option>
                        </select>
                        @if ($errors->has('payment_method'))
                            <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('payment_method') }}</strong></span>
                            </span>
                        @endif
                    </div>
                </div>

                @if($category == 1)
                    <div class="row">
                        <div class="form-group col-md-6" id="cash_account">
                            <label for="cash_account"><span class="important">*</span> Transaction Credit Account </label>
                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('cash_account') ? ' is-invalid' : '' }}" name="cash_account">
                                <option value="">Select Chart of Account</option>
                                @if(isset($cashes))
                                    @foreach($cashes as $cash)
                                        <option value="{{ $cash->id }}" {{ old('cash_account') == $cash->id ? 'selected' : old('cash_account')  }} >{{$cash->coa_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('cash_account'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('cash_account') }}</strong></span>
                            </span>
                            @endif
                        </div>





                        <div class="form-group col-md-6" id="bank_account">
                            <label for="bank_account"><span class="important">*</span> Transaction Credit Account  </label>
                            <select class="js-example-basic-single col-sm-12 {{ $errors->has('bank_account') ? ' is-invalid' : '' }}" name="bank_account">
                                <option value="">Select Chart of Account</option>
                                @if(isset($banks))
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ old('bank_account') == $bank->id ? 'selected' : old('bank_account')  }} >{{$bank->coa_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('bank_account'))
                                <span class="invalid-feedback" role="alert" >
                                <span class="messages"><strong>{{ $errors->first('bank_account') }}</strong></span>
                            </span>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group row mt-4">
                    <div class="col-sm-6 text-center" style="margin-bottom: 1em;">
                        @if($id == 1)
                            <a class="" title="Back" href="{{url('/inventory')}}">
                        @elseif($id == 2)
                            <a class="" title="Back" href="{{url('/equipment')}}">
                        @elseif($id == 3)
                            <a class="" title="Back" href="{{url('/vehicles')}}">
                        @else
                            <a class="" title="Back" href="{{url('/furniture')}}">
                        @endif
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
    </div>

@endSection

@section('javascript')
    <script>
        window.onload = function() {
            var input1 = document.getElementById('new_product');
            input1.style.visibility = 'hidden';
            var type1 = document.getElementById('product_name');
            type1.onchange = function () {
                if (type1.options[type1.selectedIndex].value === 'other') {
                    input1.style.visibility = 'visible';
                } else {
                    input1.style.visibility = 'hidden';
                }
            }

            var input2 = document.getElementById('cash_account');
            var input3 = document.getElementById('bank_account');
            input3.style.visibility = 'hidden';

            var type2 = document.getElementById('payment_method');
            type2.onchange = function () {
                if (type2.options[type2.selectedIndex].value == 0) {
                    input2.style.visibility = 'visible';
                    input3.style.visibility = 'hidden';
                }
                if (type2.options[type2.selectedIndex].value == 1){
                    input2.style.visibility = 'hidden';
                    input3.style.visibility = 'visible';
                }
            }
        }

        function minInput()
        {
            let min = document.getElementById("min_amount");
            let errors = document.getElementById("err")
            var amount = min.value;
            if (amount > 12)
            {
                errors.innerHTML = "Please enter a value less or equal to 12.";
            }
            else{
                errors.innerHTML = "";
            }
        }
    </script>
@endsection

