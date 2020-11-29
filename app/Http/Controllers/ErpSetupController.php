<?php

namespace App\Http\Controllers;

use App\ErpSetup;
use App\Http\Requests\SetupRequest;
use Illuminate\Http\Request;

class ErpSetupController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('setup', ['except' => ['index']]);
    }
    public function index()
    {
        $setup=ErpSetup::first();
        return view('backEnd.setup.setup',compact('setup'));
    }

    public function store(SetupRequest $request)
    {
        $setup = new ErpSetup;
        if ($request->hasFile('logo')) {
            $file = $request->logo;
            $file_new_name = time() . $file->getClientOriginalName();
            $file->move('public/uploads/setup', $file_new_name);
            $setup->logo = $file_new_name;
            $setup->save();
        }
        $setup->company_name = $request->company_name;
        $setup->address = $request->address;
        $setup->phone = $request->phone;
        $setup->email = $request->email;
        $setup->save();
        return redirect()->back()->with('message-success', 'Company has been added');

    }
    public function edit(){
        $profile=ErpSetup::first();
        return view('backEnd.setup.edit',compact('profile'));
    }
    public function update(Request $request, $id){
        $setup=ErpSetup::find($id);
        if ($request->hasFile('logo')) {
            $file = $request->logo;
            $file_new_name = time() . $file->getClientOriginalName();
            $file->move('public/uploads/setup', $file_new_name);
            $setup->logo = $file_new_name;
            $setup->save();
        }
        $setup->company_name = $request->company_name;
        $setup->address = $request->address;
        $setup->phone = $request->phone;
        $setup->email = $request->email;
        $setup->save();
        return view('backEnd.setup.setup',compact('setup'));
    }
}
