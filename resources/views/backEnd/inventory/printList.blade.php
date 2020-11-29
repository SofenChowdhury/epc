<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @if($category == 1)
            Inventory Products List
        @elseif($category == 2)
            Property, Plant and Equipments List
        @elseif($category == 3)
            Vehicles List
        @elseif($category == 4)
            Furniture List
        @endif
        {{ date('Y-m-d H:i:s') }}
    </title>

    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/icon/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/pages/chart/radial/css/radial.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('public/assets/pages/list-scroll/list.css')}}" type="text/css" media="all">
</head>
<body>
<div class="card-block" id="page">
    <div class="row" id="logo">
        <div class="" style="padding:3% 0 0 5%; float:left">
            <img class="img-fluid" src="{{asset('public/assets/images/epc_logo.png')}}" height="10" width="120">
        </div>
    </div>
    <div class="card-block" >
        <div class="text-center card-header" style="font-weight: bold; ">
            <h5>
                @if($category == 1)
                    Inventory Products List
                @elseif($category == 2)
                    Property, Plant and Equipments List
                @elseif($category == 3)
                    Vehicles List
                @elseif($category == 4)
                    Furniture List
                @endif
            </h5>
    </div>

    <div class="card">

            <div class="card-block">
                <div class="table-responsive">
                    <table id="" class="table table-striped table-bordered">
                        <thead>
                        <tr>

                            <th>SL</th>
                            @if($category == 2 || $category == 4)
                                <th>Room No</th>
                            @endif
                            @if($category != 1)
                                <th>Asset Number</th>
                            @endif
                            <th>Product Name</th>
                            <th>Serial No</th>
                            @if($category == 1)
                                <th>Unit</th>
                                <th>Quantity</th>
                            @endif
                            <th>Price</th>
                            @if($category == 1)
                                <th>Total</th>
                            @endif
                            <th>Purchase Date</th>
                            <th>Added By</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; $total = 0; @endphp
                        @foreach($products as $product)
                            <tr>
                                <td>{{$i++}}</td>
                                @if(isset($product->room_no))
                                    <td>{{ $product->room->room_no }}</td>
                                @endif
                                @if($category != 1)
                                    <td>
                                        @if(isset($product->coa_id))
                                            <a href="{{ url('single_account', $product->coa_id) }}">{{ $product->coa->coa_reference_no }}</a>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if(isset($product->product_id))
                                        {{$product->product->product}}
                                    @endif
                                </td>
                                <td>{{$product->serial_no}}</td>
                                @if($category == 1)
                                    <td>
                                        @if(isset($product->product_id)){{ $product->product->unit }}@endif
                                    </td>
                                    @if($product->quantity <= $product->min_amount)
                                        <td style="color: red; font-weight: bold">
                                    @else
                                        <td>
                                            @endif
                                            {{$product->quantity}}
                                        </td>
                                    @endif
                                    <td>{{ $product->price }}</td>
                                    @if($category == 1)
                                        <td>
                                            @if($product->price && $product->quantity)
                                                @php $sum = $product->price * $product->quantity; $total += $sum @endphp
                                                {{ $sum }}
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ isset($product->purchase_date) ? date('d-M-Y', strtotime($product->purchase_date)) : ''}}</td>
                                    <td>
                                        @foreach($users as $userCreator)
                                            @if( $product->created_by == $userCreator->id )
                                                {{$userCreator->name}}
                                            @endif
                                        @endforeach
                                    </td>
                            </tr>
                        @endforeach
                        @if($category == 1)
                            <tr>
                                <td></td>
                                <td colspan="5">Total</td>
                                <td colspan="3">{{ $total }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="text-bottom text-center pt-5 mt-5" >
        <div class="row">
            <div class="col" style="background-color: #4a5f68; position:fixed; bottom: 0" >
                <p class=" " style="font-size: 0.9rem; background-color: #4a5f68" >ERP Version 1.1 | Developed by: White Paper | Printed By: {{ Auth::user()->name }} | <span id="datetime"></span></p>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript" src="{{asset('public/bower_components/jquery/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/popper.js/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/pages/widget/excanvas.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/modernizr/js/modernizr.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/bower_components/chart.js/js/Chart.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/js/SmoothScroll.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            var dt = new Date();
            document.getElementById("datetime").innerHTML = dt.toLocaleString();

            window.focus();
            window.print();
            window.setTimeout('history.back()',1000);
            // window.close();
            // history.back();
            // history.go(-1);
        });
    </script>
</body>
</html>
