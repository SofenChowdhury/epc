<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpBaseGroup;
use App\ErpBaseSetup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpBaseSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $base_setups = ErpBaseSetup::all();
        $base_groups = ErpBaseGroup::all();
        return view('backEnd.base_setup.index', compact('base_setups','base_groups'));
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
            'base_group_id'=>'required',
            'base_setup_name'=>'required'
        ]);

        $base_setup = new ErpBaseSetup();
        $base_setup->base_group_id = $request->get('base_group_id');
        $base_setup->base_setup_name = $request->get('base_setup_name');
        $base_setup->created_by = Auth::user()->id;

        $results = $base_setup->save();
        if($results) {
            return redirect('/base_setup')->with('message-success', 'Base setup has been added');
        } else {
            return redirect('/base_setup')->with('message-danger', 'Something went wrong');
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
        $editData = ErpBaseSetup::find($id);
        $base_setups = ErpBaseSetup::all();
        $base_groups = ErpBaseGroup::all();
        return view('backEnd.base_setup.index', compact('editData', 'base_groups','base_setups'));
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
            'base_group_id'=>'required',
            'base_setup_name'=>'required'
        ]);

        $base_setup = ErpBaseSetup::find($id);
        $base_setup->base_group_id = $request->get('base_group_id');
        $base_setup->base_setup_name = $request->get('base_setup_name');
        $base_setup->updated_by = Auth::user()->id;

        $results = $base_setup->update();
        if($results) {
            return redirect('/base_setup')->with('message-success', 'Base setup has been added');
        } else {
            return redirect('/base_setup')->with('message-danger', 'Something went wrong');
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
