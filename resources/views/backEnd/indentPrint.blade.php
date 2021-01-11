<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Indent</title>
</head>
<body>
<style>
    table, td, th {
        border: 1px solid black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>
<p style="font-weight: bold; font-size: 13px; line-height: 8px; padding-left: 550px">INDENT NO. {{$indentDataMaster->indent_no}}</p>
<p class="text-center" style="font-weight: bold; font-size: 16px; line-height: 8px">Engineering & Planning Consultants Ltd.</p>
<p class="text-center" style="font-weight: bold; font-size: 13px; line-height: 8px">7/4,Block-A, Lalmatia,Dhaka-1207</p>
<p class="text-center" style="font-weight: bold; font-size: 13px; line-height: 8px">{{$indentDataMaster->title}}</p><span>Date: {{$indentDataMaster->date}}</span>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name of vendor/Paid to</th>
            <th>Purpose of Payment</th>
            <th>Project Exp Code</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach($indentDataChild as $child)
        <tr>
            <td>{{$loop->index+1}}</td>
            <td>{{$child->vendor}}</td>
            <td>{{$child->purpose}}</td>
            <td>{{$child->exp_code}}</td>
            <td>{{$child->amount}}</td>
            @php
                $total += $child->amount;
            @endphp
        </tr>
        @endforeach
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>Total TK =</th>
            <th>{{$total}}</th>
        </tr>
    </tbody>
</table>
<p class="" style="font-weight: bold; font-size: 13px; line-height: 15px">Note: {{$indentDataMaster->note}}</p>
<br><br>
<table>
    <thead>
    <tr>
        <th>Initiator</th>
        <th>Manager (HR & Admin)</th>
        <th>Associate Director</th>
        <th>Director-2</th>
{{--        <th>Director-1</th>--}}
        <th>Chairman</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$indentDataMaster->accountant}}<br><span>Prepared</span></td>
        <td>{{$indentDataMaster->manager}}<br>
            @if($indentDataMaster->manager)
                <span>Approved</span>
            @endif
        </td>
        <td>{{$indentDataMaster->associate_director}}<br>
            @if($indentDataMaster->associate_director)
                <span>Approved</span>
            @endif
        </td>
        <td>{{$indentDataMaster->director_2}}<br>
            @if($indentDataMaster->director_2)
                <span>Approved</span>
            @endif
        </td>
{{--        <td>{{$indentDataMaster->director_1}}<br>--}}
{{--            @if($indentDataMaster->director_1)--}}
{{--                <span>Approved</span>--}}
{{--            @endif--}}
{{--        </td>--}}
        <td>{{$indentDataMaster->chairman}}<br>
            @if($indentDataMaster->chairman)
                <span>Approved</span>
            @endif
        </td>
    </tr>
    </tbody>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
