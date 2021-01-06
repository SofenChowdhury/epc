<?php

namespace App\Http\Controllers;

use App\ErpClientDocument;
use App\erpSetup;
use Illuminate\Http\Request;
use App\ErpClient;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:View Client List|View Client Details|View Client Payment|View Client Provided Documents|Add/Edit Client')->only('index');
        $this->middleware('permission:View Client List|Add/Edit Client')->only('create','edit','store','update');
        $this->middleware('permission:View Client Details|View Client Payment|View Client Provided Documents')->only('show');
    }

    public function index()
    {
        $clients = ErpClient::where('active_status', '=', 1)->get();
        return view('backEnd.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        return view('backEnd.clients.create');
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
            'client_name'=>'required|string|min:3|max:150',
            'abbreviation'=>'min:0|max:50',
            'ministry'=>'min:0|max:100',
            'division'=>'min:0|max:100',
            'agency'=>'min:0|max:100',
            'website'=>'min:0|max:100',
        ]);

        $client = new ErpClient();
        $client->client_name = $request->get('client_name');
        $client->abbreviation = $request->get('abbreviation');
        $client->ministry = $request->get('ministry');
        $client->division = $request->get('division');
        $client->agency = $request->get('agency');
        $client->website = $request->get('website');
        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $image_name = $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/client_img');
            $image->move($destinationPath, $image_name);
            $client->client_image = '/public/uploads/client_img/'.$image_name;
        }
        $client->created_by = Auth::user()->id;

        $client->save();
        return redirect('/client')->with('message-success', 'Client has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = ErpClient::find($id);
        $documents = ErpClientDocument::where('client_id', '=', $id)->get();
        $users = User::all();
//        $setup = ErpSetup::latest()->first();
        return view('backEnd.clients.show', compact('client', 'documents', 'users'));
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
        $client = ErpClient::find($id);
        return view('backEnd.clients.edit', compact('client'));
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
            'client_name'=>'required|string|min:3|max:150',
            'abbreviation'=>'min:0|max:50',
            'ministry'=>'min:0|max:100',
            'division'=>'min:0|max:100',
            'agency'=>'min:0|max:100',
            'website'=>'min:0|max:100',
        ]);

        $client = ErpClient::find($id);
        $client->client_name = $request->get('client_name');
        $client->abbreviation = $request->get('abbreviation');
        $client->ministry = $request->get('ministry');
        $client->division = $request->get('division');
        $client->agency = $request->get('agency');
        $client->website = $request->get('website');
        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $image_name = $image->getClientOriginalName();
            $destinationPath = public_path('/uploads/client_img');
            $image->move($destinationPath, $image_name);
            $client->client_image = '/public/uploads/client_img/'.$image_name;
        }
        $client->updated_by = Auth::user()->id;

        $client->update();
        return redirect('/client')->with('message-success', 'Client has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteClientView($id){
         return view('backEnd.clients.deleteClientView', compact('id'));
    }

    public function deleteClient($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $client = ErpClient::find($id);
        $client->active_status = 0;

        $results = $client->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'The Client has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
