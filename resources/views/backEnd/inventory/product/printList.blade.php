<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Asset List
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
                Asset List
            </h5>
        </div>

        <div class="card">

            <div class="card-block">
                <div class="dt-responsive table-responsive">
                    <table id="basic-btn" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Product Name</th>
                            @if($type == 0)
                                <th>Unit</th>
                            @endif
                            <th>Description</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($products))
                            @php $i = 1 @endphp
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$product->product}}</td>
                                    @if($type == 0)
                                        <td>{{$product->unit}}</td>
                                    @endif
                                    <td>{{$product->description}}</td>
                                </tr>
                            @endforeach
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
