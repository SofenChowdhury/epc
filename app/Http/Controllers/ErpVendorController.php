<?php

namespace App\Http\Controllers;

use App\ErpVendorDocument;
use Illuminate\Http\Request;
use App\erpSetup;
use App\ErpVendor;
use App\ErpVendorBank;
use App\ErpChartOfAccounts;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = ErpVendor::where('active_status', '=', 1)->get();
        return view('backEnd.vendors.index', compact('vendors'));
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
        return view('backEnd.vendors.create');
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
            'vendor_name'=>'required|string|min:3|max:200',
            'phone_number'=>'required|string|min:3|max:100',
            'unique_id'=>'min:0|max:100',
            'service_type'=>'min:0|max:200',
            'service_acc_no'=>'min:0|max:100',
            'service_meter_no'=>'min:0|max:100',
            'email'=>'min:0|max:100',
            'contact_person_name'=>'min:0|max:100',
            'designation'=>'min:0|max:100',
            'contact_person_phone'=>'min:0|max:100',
            'contact_person_email'=>'min:0|max:100',
            'trade_licence_no'=>'min:0|max:100',
        ]);

        //create vendor details
        $vendor = new ErpVendor();
        $vendor->vendor_name = $request->get('vendor_name');
        $vendor->unique_id = $request->get('unique_id');
        $vendor->service_type = $request->get('service_type');
        $vendor->service_acc_no = $request->get('service_acc_no');
        $vendor->service_meter_no = $request->get('service_meter_no');
        $vendor->trade_licence_no = $request->get('trade_licence_no');
        $vendor->phone_number = $request->get('phone_number');
        $vendor->email = $request->get('email');
        $vendor->contact_person_name = $request->get('contact_person_name');
        $vendor->designation = $request->get('designation');
        $vendor->contact_person_phone = $request->get('contact_person_phone');
        $vendor->contact_person_email = $request->get('contact_person_email');
        $vendor->office_address = $request->get('office_address');
        $vendor->created_by = Auth::user()->id;
        $vendor->save();

        $vendor_id = $vendor->id;

        //create vendor bank details
        $vendor_bank = new ErpVendorBank();
        $vendor_bank->vendor_id = $vendor_id;
        $vendor_bank->bank_name = $request->get('bank_name');
        $vendor_bank->account_number = $request->get('account_number');
        $vendor_bank->bank_branch = $request->get('bank_branch');
        $vendor_bank->bank_address = $request->get('bank_address');
        $vendor_bank->routing_number = $request->get('routing_number');
        $vendor_bank->swift_code = $request->get('swift_code');
        $result = $vendor_bank->save();

        //Create Vendor Chart of Account
        $vendor_coa = ErpChartOfAccounts::select('coa_reference_no')->where('coa_reference_no','LIKE',"60120%")->latest()->first();
        if($vendor_coa){
            $vendor_coa_last=$vendor_coa->coa_reference_no+1;
        }else{
            $vendor_coa_last= 6012001;
        }

        $coa = new ErpChartOfAccounts();
        $coa->coa_parent = 15060120;
        $coa->coa_reference_no = $vendor_coa_last;
        $coa->coa_name = $vendor->vendor_name;
        $coa->account_type = 'debit';
        $result_coa = $coa->save();

        if ($result_coa){
            $new_vendor = ErpVendor::find($vendor->id);
            $new_vendor->coa_id = $coa->id;
            $new_vendor->update();
        }

        if ($result) {
            return redirect('/vendors')->with('message-success', 'Vendor has been added');
        } else {
            return redirect('/vendors')->with('message-danger', 'Something went wrong. Please try again');
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
        $vendor = ErpVendor::find($id);
        $users = User::all();
        $documents = ErpVendorDocument::where('vendor_id', '=', $id)->get();
//        $setup = ErpSetup::latest()->first();
        return view('backEnd.vendors.show', compact('vendor', 'users', 'documents'));
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
        $vendor = ErpVendor::find($id);
        return view('backEnd.vendors.edit', compact('vendor'));
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
            'vendor_name'=>'required|string|min:3|max:200',
            'phone_number'=>'required|string|min:3|max:100',
            'unique_id'=>'min:0|max:100',
            'service_type'=>'min:0|max:200',
            'service_acc_no'=>'min:0|max:100',
            'service_meter_no'=>'min:0|max:100',
            'email'=>'min:0|max:100',
            'contact_person_name'=>'min:0|max:100',
            'designation'=>'min:0|max:100',
            'contact_person_phone'=>'min:0|max:100',
            'contact_person_email'=>'min:0|max:100',
            'trade_licence_no'=>'min:0|max:100',
        ]);

        // update Vendor details
        $vendor = ErpVendor::find($id);
        $vendor->vendor_name = $request->get('vendor_name');
        $vendor->unique_id = $request->get('unique_id');
        $vendor->service_type = $request->get('service_type');
        $vendor->service_acc_no = $request->get('service_acc_no');
        $vendor->service_meter_no = $request->get('service_meter_no');
        $vendor->trade_licence_no = $request->get('trade_licence_no');
        $vendor->phone_number = $request->get('phone_number');
        $vendor->email = $request->get('email');
        $vendor->contact_person_name = $request->get('contact_person_name');
        $vendor->designation = $request->get('designation');
        $vendor->contact_person_phone = $request->get('contact_person_phone');
        $vendor->contact_person_email = $request->get('contact_person_email');
        $vendor->office_address = $request->get('office_address');
        $vendor->updated_by = Auth::user()->id;

        $vendor_coa = ErpChartOfAccounts::find($vendor->coa_id);
        if ($vendor_coa){
            $vendor_coa->coa_name = $vendor->vendor_name;
            $vendor_coa->update();
        }
        $vendor->update();

        //update Vendor Bank Details
        $vendor_bank = ErpVendorBank::where('vendor_id', $id)->first();
        $vendor_bank->bank_name = $request->get('bank_name');
        $vendor_bank->account_number = $request->get('account_number');
        $vendor_bank->bank_branch = $request->get('bank_branch');
        $vendor_bank->bank_address = $request->get('bank_address');
        $vendor_bank->routing_number = $request->get('routing_number');
        $vendor_bank->swift_code = $request->get('swift_code');
        $vendor_bank->update();

        return redirect('/vendors')->with('message-success', 'Vendor has been updated');
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

    public function deleteVendorView($id){
         return view('backEnd.vendors.deleteVendorView', compact('id'));
    }

    public function deleteVendor($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $vendor = ErpVendor::find($id);
        $vendor->active_status = 0;

        $results = $vendor->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'The Vendor has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
