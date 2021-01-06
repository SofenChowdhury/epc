<?php

namespace App\Http\Controllers;

use App\ErpChalanNo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpChalanNoController extends Controller
{
    public function index()
    {
        $chalans = ErpChalanNo::all();
        return view('backEnd.employees.chalanNo.index', compact('chalans'));
    }

    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'chalan_no'=>'required|string|min:1|max:100',
            'bank_name'=>'min:0|max:100'
        ]);

        $chalan = new ErpChalanNo();
        $chalan->chalan_no = $request->get('chalan_no');
        if ($request->chalan_date != null)
            $chalan->chalan_date = date('Y-m-d', strtotime($request->chalan_date));
        $chalan->bank_name = $request->get('bank_name');
        if ($request->start_month != null)
            $chalan->start_month = date('Y-m-d', strtotime($request->start_month));
        if ($request->end_month != null)
            $chalan->end_month = date('Y-m-d', strtotime($request->end_month));

        $result = $chalan->save();
        if($result) {
            return redirect('/chalan_no')->with('message-success', 'Chalan Number has been added.');
        } else {
            return redirect('/chalan_no')->with('message-success', 'Something went wrong.');
        }
    }

    public function edit($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpChalanNo::find($id);
        $chalans = ErpChalanNo::all();
        return view('backEnd.employees.chalanNo.index', compact('editData', 'chalans'));
    }

    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'chalan_no'=>'required|string|min:1|max:100',
            'bank_name'=>'min:0|max:100'
        ]);

        $chalan = ErpChalanNo::find($id);
        $chalan->chalan_no = $request->get('chalan_no');
        if ($request->chalan_date != null)
            $chalan->chalan_date = date('Y-m-d', strtotime($request->chalan_date));
        $chalan->bank_name = $request->get('bank_name');
        if ($request->start_month != null)
            $chalan->start_month = date('Y-m-d', strtotime($request->start_month));
        if ($request->end_month != null)
            $chalan->end_month = date('Y-m-d', strtotime($request->end_month));

        $result = $chalan->update();
        if($result) {
            return redirect('/chalan_no')->with('message-success', 'Chalan Number has been updated.');
        } else {
            return redirect('/chalan_no')->with('message-success', 'Something went wrong.');
        }
    }
}
