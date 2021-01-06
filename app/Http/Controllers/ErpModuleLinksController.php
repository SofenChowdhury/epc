<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpModule;
use App\ErpModuleLinks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpModuleLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = ErpModule::where('active_status','=',1)->get();
        $module_links = ErpModuleLinks::where('active_status','=',1)->orderBy('module_id')->get();
        return view('backEnd.module_link.index', compact('modules','module_links'));
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
            'module_id'=>'required',
            'name'=>'required'
        ]);

        $module_link = new ErpModuleLinks();
        $module_link->module_id = $request->get('module_id');
        $module_link->name = $request->get('name');
        $module_link->created_by = Auth::user()->id;

        $results = $module_link->save();
        if($results) {
            return redirect('/module_link')->with('message-success', 'Module links has been added');
        } else {
            return redirect('/module_link')->with('message-danger', 'Something went wrong');
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
        $editData = ErpModuleLinks::find($id);
        $module_links = ErpModuleLinks::where('active_status', '=', 1)->get();
        $modules = ErpModule::where('active_status', '=', 1)->get();
        return view('backEnd.module_link.index', compact('editData', 'module_links', 'modules'));
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
            'module_id'=>'required',
            'name'=>'required'
        ]);

        $module_link = ErpModuleLinks::find($id);
        $module_link->module_id = $request->get('module_id');
        $module_link->name = $request->get('name');
        $module_link->updated_by = Auth::user()->id;

        $results = $module_link->update();
        if($results) {
            return redirect('/module_link')->with('message-success', 'Module link has been updated');
        } else {
            return redirect('/module_link')->with('message-danger', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteModuleLinkView($id){
        $module = 'deleteModuleLink';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteModuleLink($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $module_link = ErpModuleLinks::find($id);
        $module_link->active_status = 0;
        $results = $module_link->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Module link has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
