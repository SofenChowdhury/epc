<?php

namespace App\Http\Controllers;

use App\ErpEmployee;
use App\ErpInventory;
use App\ErpLocation;
use App\ErpRoomNo;
use App\ErpUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = ErpRoomNo::all();
        return view('backEnd.employees.location.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'room_no'=>'required'
        ]);

        $location = new ErpRoomNo();
        $location->room_no = $request->get('room_no');
        $location->floor_no = $request->get('floor_no');
        $location->created_by = Auth::user()->id;
        $result = $location->save();
        if($result) {
            return redirect('/location')->with('message-success', 'Room Number has been added.');
        } else {
            return redirect('/location')->with('message-success', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        $editData = ErpRoomNo::find($id);
        $rooms = ErpRoomNo::all();
        return view('backEnd.employees.location.index', compact('editData', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'room_no'=>'required'
        ]);

        $location = ErpRoomNo::find($id);
        $location->room_no = $request->get('room_no');
        $location->floor_no = $request->get('floor_no');
        $location->updated_by = Auth::user()->id;
        $result = $location->update();
        if($result) {
            return redirect('/location')->with('message-success', 'Room Number has been added.');
        } else {
            return redirect('/location')->with('message-success', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function assets($id)
    {
        $room = ErpRoomNo::find($id);
        $products = ErpInventory::where('room_no', $id)->get();
        $users = User::all();
        $employees = ErpEmployee::where('room_no', $id)->get();
        return view('backEnd.employees.location.assets', compact('products', 'room', 'users', 'employees'));

    }
    
    public function employees($id)
    {
        $room = ErpRoomNo::find($id);
        $employees = ErpEmployee::where('room_no', $id)->get();
        $users = User::all();
        return view('backEnd.employees.location.employees', compact('employees', 'room', 'users'));

    }
}
