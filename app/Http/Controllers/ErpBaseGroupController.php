<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpBaseGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpBaseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base_groups = ErpBaseGroup::all();
        return view('backEnd.base_group.index', compact('base_groups'));
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
            'name'=>'required'
        ]);

        $base_group = new ErpBaseGroup();
        $base_group->name = $request->get('name');
        $base_group->created_by = Auth::user()->id;

        $results = $base_group->save();
        if($results) {
            return redirect('/base_group')->with('message-success', 'Group has been added');
        } else {
            return redirect('/base_group')->with('message-danger', 'Something went wrong');
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
        //
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
        $editData = ErpBaseGroup::find($id);
        $base_groups = ErpBaseGroup::all();
        return view('backEnd.base_group.index', compact('editData', 'base_groups'));
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
           'name' => "required"
        ]);

       $base_group = ErpBaseGroup::find($id);
       $base_group->name = $request->name;
       $base_group->updated_by = Auth::user()->id;
       $results = $base_group->update();

       if($results){
           return redirect()->back()->with('message-success', 'Group has been updated successfully');
       }else{
           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
