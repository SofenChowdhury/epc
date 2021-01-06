<?php

namespace App\Http\Controllers;

use App\ErpChartOfAccounts;
use App\ErpDepreciation;
use App\ErpEmployee;
use App\ErpEmployeeMaterial;
use App\ErpInventory;
use App\ErpLocation;
use App\ErpProduct;
use App\ErpProject;
use App\ErpProjectMaterial;
use App\ErpRoomNo;
use App\ErpTransaction;
use App\ErpTransactionDetails;
use App\ErpVendor;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpInventoryController extends Controller
{
    public function index()
    {
       $products = ErpInventory::where('category', '=', 1)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
        $users = User::all();
        $employees = ErpEmployee::where('active_status', 1)->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $category = 1;
        return view('backEnd.inventory.index', compact('products', 'users', 'employees', 'projects', 'category'));
    }
    public function equipment()
    {
        ErpDepreciation::depreciation_calculate();
        $products = ErpInventory::where('category', '=', 2)
            ->where('quantity', '>', 0)
            ->where('active_status', '=', 1)
            ->get();
            $assigns = ErpInventory::leftjoin('erp_employee_materials','erp_employee_materials.inventory_id','erp_inventories.id')
                ->where('erp_inventories.category', '=', 2)
                ->where('erp_inventories.quantity', '=', 0)
                ->where('erp_employee_materials.room_no', '!=', null)
                ->where('erp_inventories.active_status', '=', 1)
                ->orderBy('erp_inventories.room_no')
                ->get();
        $users = User::all();
        $employees = ErpEmployee::where('active_status', 1)->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $rooms = ErpRoomNo::all();
        $category = 2;
        $depreciations = ErpDepreciation::all();
        return view('backEnd.inventory.index', compact('products', 'users', 'employees', 'projects', 'category', 'assigns', 'depreciations', 'rooms'));
    }
    public function vehicles()
    {
        ErpDepreciation::depreciation_calculate();
        $products = ErpInventory::where('category', '=', 3)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
        $assigns = ErpInventory::where('category', '=', 3)->where('quantity', '=', 0)->where('active_status', '=', 1)->get();
        $users = User::all();
        $employees = ErpEmployee::where('active_status', 1)->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $category = 3;
        $depreciations = ErpDepreciation::all();
        return view('backEnd.inventory.index', compact('products', 'users', 'employees', 'projects', 'category', 'assigns', 'depreciations'));
    }
    public function furniture()
    {
        $depreciations = ErpDepreciation::all();
        foreach ($depreciations as $depreciation) {
            if ($depreciation->purchase_date == '1970-01-01') {
                $x = ErpDepreciation::find($depreciation->id);
                $x->purchase_date = null;
                $x->update();
            }
        }
        ErpDepreciation::depreciation_calculate();
        $products = ErpInventory::where('category', '=', 4)
            ->where('quantity', '>', 0)
            ->where('active_status', '=', 1)
            ->get();
        $assigns = ErpInventory::leftjoin('erp_employee_materials','erp_employee_materials.inventory_id','erp_inventories.id')
            ->where('erp_inventories.category', '=', 4)
            ->where('erp_inventories.quantity', '=', 0)
            ->where('erp_employee_materials.room_no', '!=', null)
            ->where('erp_inventories.active_status', '=', 1)
            ->orderBy('erp_inventories.room_no')
            ->get();
        $users = User::all();
        $employees = ErpEmployee::where('active_status', 1)->get();
        $projects = ErpProject::where('active_status', 1)->get();
        $category = 4;
        return view('backEnd.inventory.index', compact('products', 'users', 'employees', 'projects', 'category', 'assigns', 'depreciations'));
    }
    public function create($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $employees = ErpEmployee::where('active_status', '=', '1')->get();
        $projects = ErpProject::all();
        $locations = ErpLocation::all();
        $rooms = ErpRoomNo::all();
        $vendors = ErpVendor::where('active_status', 1)->get();
        if ($id == 2) {
            $product_lists = ErpProduct::where('product_type', '=', 1)->get();
            $coa_list = true;
            $coas = ErpChartOfAccounts::where('coa_header_id', 150201)->get();
        } elseif ($id == 3) {
            $product_lists = ErpProduct::where('product_type', '=', 1)->get();
            $coa_list = true;
            $coas = ErpChartOfAccounts::where('coa_header_id', 150203)->get();
        } elseif ($id == 4) {
            $product_lists = ErpProduct::where('product_type', '=', 1)->get();
            $coa_list = true;
            $coas = ErpChartOfAccounts::where('coa_header_id', 150204)->get();
        } else {
            $product_lists = ErpProduct::where('product_type', '=', 0)->get();
            $coa_list = false;
            $coas = 0;
        }
        $banks = ErpChartOfAccounts::where('coa_reference_no','LIKE', '20202%')->get();
        $cashes = ErpChartOfAccounts::where('coa_reference_no','LIKE', '20201%')->get();

        $category = $id;
        return view('backEnd.inventory.create', compact('id', 'product_lists', 'employees', 'projects', 'coa_list', 'coas', 'locations', 'vendors', 'rooms', 'category', 'cashes', 'banks'));
    }
    
    public function store(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
//            'product_name'=>'required',
            'min_amount'=>'numeric|min:0|max:12',
            'upload_document'=> 'mimes:jpeg,jpg,pdf,png',
            'serial_no'=>'min:0|max:200',
            'brand_name'=>'min:0|max:200',
            'chasis_no'=>'min:0|max:200',
            'cc'=>'min:0|max:100',
        ]);
        $category = $request->category;
        $product = new ErpInventory();
        if($request->new_product != null){
            $code = new ErpProduct();
            if ($category == 1)
                $code->product_type = 0;
            else
                $code->product_type = 1;
            $code->product = $request->new_product;
            $code->unit = $request->unit;
            $code->save();
            $product->product_id = $code->id;
            $name = $request->new_product;
        }else{
            $code = ErpProduct::find($request->product_name);
            $product->product_id = $code->id;
            $name = $code->product;
        }
        $product->category = $category;
        $product->serial_no = $request->get('serial_no');
        $product->brand_name = $request->get('brand_name');
        $product->location = $request->get('location');
        $product->room_no = $request->get('room_no');
        $product->depreciation_rate = $request->get('depreciation_rate');
        $product->chasis_no = $request->get('chasis_no');
        $product->cc = $request->get('cc');
        $product->price = $request->get('price');
        if ($request->get('purchase_date') != '') {
            $product->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
        }
        if ($category == 1) {
            $product->min_amount = $request->get('min_amount');
            $product->quantity = $request->get('quantity');
        } else
            $product->quantity = 1;
        $product->payment_method = $request->get('payment_method');
        $product->vendor_id = $request->get('vendor_id');
        if ($request->hasFile('upload_document')) {
            $upload_document = $request->file('upload_document');
            $document_name = time() . $upload_document->getClientOriginalName();
            $destinationPath = public_path('/uploads/product_voucher');
            $upload_document->move($destinationPath, $document_name);
            $product->upload_document = '/uploads/product_voucher/'.$document_name;
        }
        $product->description = $request->get('description');
        $product->created_by = Auth::user()->id;
        $result = $product->save();
//        CREATING CHART OF ACCOUNT
        if($category != 1){
//            Creating Chart of Account
            $parent = $request->coa_parent;
            $coa_parent = ErpChartOfAccounts::where('coa_reference_no','=', $parent)->latest()->first();
            $p = $parent - 15000000;
            $p_sql = $p.'%';
            $asset_coa = ErpChartOfAccounts::select('coa_reference_no')->where('coa_reference_no','LIKE', $p_sql)->latest()->first();
            if($asset_coa){
                $asset_coa_last=$asset_coa->coa_reference_no+1;
            }else{
                $asset_coa_last= ($p*100)+1;
            }
            $coa = new ErpChartOfAccounts();
            $coa->coa_parent = $parent;
            $coa->coa_reference_no = $asset_coa_last;
            $coa->coa_name = $name;
            $coa->account_type = 'debit';
            $results = $coa->save();
            $coa_parent->child = 1;
            $coa_parent->update();
            $new_coa = ErpChartOfAccounts::find($coa->id);
            $new_product = ErpInventory::find($product->id);
            $new_product->type = 1;
            $new_product->coa_id = $new_coa->id;
            $new_product->coa_reference_no = $new_coa->coa_reference_no;
            $new_product->update();
            $asset = new ErpDepreciation();
            $asset->product_id = $product->id;
            $asset->coa_reference_no = $new_coa->coa_reference_no;
            if ($product->purchase_date != null) {
                $asset->purchase_date = date('Y-m-d', strtotime($product->purchase_date));
            }
            $asset->cost_price = $product->price;
            $asset->depreciation_rate = $product->depreciation_rate;
            $asset->save();
            if ($request->room_no != null) {
                $employees = ErpEmployee::where('room_no', '=', $request->room_no)->get();
                if ($employees) {
                    foreach ($employees as $employee) {
                        $employee_material = new ErpEmployeeMaterial();
                        $employee_material->inventory_id = $product->id;
//                        $employee_material->employee_id = $employee->id;
                        $employee_material->coa_id = $new_coa->id;
                        $employee_material->product_name = $product->product_name;
                        $employee_material->quantity = $request->quantity;
                        $employee_material->room_no = $request->room_no;
                        $employee_material->created_by = Auth::user()->id;
                        $employee_material->save();
                    }
                    $product->quantity = 0;
                    $product->update();
                }
            }
        }
//        AUTO TRANSACTION FOR INVENTORY
        if ($category == 1){
            if ($request->cash_account != NULL || $request->bank_account != NULL){
                $transaction = new ErpTransaction;
                if ($request->purchase_date != '') {
                    $transaction->transaction_date = date('Y-m-d', strtotime($request->purchase_date));
                } else
                    $transaction->transaction_date = Carbon::now();
                $transaction->description = 'Purchase Inventory Item: ' . $name;
                $latest = ErpTransaction::latest()->first();
                if ($latest)
                    $transaction->voucher_no = ++$latest->voucher_no;
                else
                    $transaction->voucher_no = 1;
                $transaction->total_transaction = $product->quantity * $product->price;
                $transaction->active_status = 1;
                $transaction->created_by = Auth::user()->id;
                $transaction->save();
//                Asset account (credited)
                $transaction_detail1 = new ErpTransactionDetails;
                $transaction_detail1->transaction_id = $transaction->id;
                if ($request->cash_account)
                    $transaction_detail1->coa_id = $request->cash_account;
                else
                    $transaction_detail1->coa_id = $request->bank_account;
                $transaction_detail1->credit_amount = $transaction->total_transaction;
                $transaction_detail1->active_status = 1;
                $transaction_detail1->type = 'C';
                $transaction_detail1->save();
//                Expense account->Stationary & office supplies (debited)
                $transaction_detail2 = new ErpTransactionDetails;
                $transaction_detail2->transaction_id = $transaction->id;
                $transaction_detail2->coa_id = 127;
                $transaction_detail2->debit_amount = $transaction->total_transaction;
                $transaction_detail2->active_status = 1;
                $transaction_detail2->type = 'D';
                $transaction_detail2->save();
            }
        }
        ErpDepreciation::depreciation_calculate();
        if($result) {
            if($category == 1){
                return redirect('/inventory')->with('message-success', 'Product has been added.');
            } elseif($category == 2){
                return redirect('/equipment')->with('message-success', 'Product has been added.');
            } elseif($category == 3){
                return redirect('/vehicles')->with('message-success', 'Product has been added.');
            } elseif($category == 4){
                return redirect('/furniture')->with('message-success', 'Product has been added.');
            }
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong.');
        }
    }
    public function show($id)
    {
    
    }
    
    public function edit($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'edited','path'=>url()->current())
        );
        
        $product        = ErpInventory::find($id);
        $product_lists  = ErpProduct::all();
        $locations      = ErpLocation::all();
        $rooms          = ErpRoomNo::all();
        $vendors        = ErpVendor::where('active_status', 1)->get();
        return view('backEnd.inventory.edit', compact('product', 'product_lists', 'locations', 'rooms', 'vendors'));
    }
    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'serial_no'=>'min:0|max:200',
            'brand_name'=>'min:0|max:200',
            'chasis_no'=>'min:0|max:200',
            'cc'=>'min:0|max:100',
        ]);
        $product = ErpInventory::find($id);
        $product->serial_no = $request->get('serial_no');
        $product->status = $request->get('status');
        $product->brand_name = $request->get('brand_name');
        $product->payment_method = $request->get('payment_method');
        $product->location = $request->get('location');
        $product->room_no = $request->get('room_no');
        $product->price = $request->get('price');
        $product->depreciation_rate = $request->get('depreciation_rate');
        if($request->get('purchase_date') != ''){
            $product->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
        }
        if ($product->category == 1){
            $product->min_amount = $request->get('min_amount');
            $product->quantity = $request->get('quantity');
        }
        $product->vendor_id = $request->get('vendor_id');
        if ($request->hasFile('upload_document')) {
            $upload_document = $request->file('upload_document');
            $document_name = time() . $upload_document->getClientOriginalName();
            $destinationPath = public_path('/uploads/product_voucher');
            $upload_document->move($destinationPath, $document_name);
            $product->upload_document = '/uploads/product_voucher/'.$document_name;
        }
        $product->description = $request->get('description');
        $product->updated_by = Auth::user()->id;
        $result = $product->update();
        if($product->category != 1){
            if($request->room_no != null){
                $employees = ErpEmployee::where('room_no', '=', $request->room_no)->get();
                if($employees) {
                    foreach ($employees as $employee) {
                        $employee_material = new ErpEmployeeMaterial();
                        $employee_material->inventory_id = $product->id;
//                        $employee_material->employee_id = $employee->id;
                        $employee_material->product_name = $product->product_name;
                        $employee_material->quantity = $request->quantity;
                        $employee_material->room_no = $request->room_no;
                        $employee_material->coa_id = $request->coa_id;
                        $employee_material->created_by = Auth::user()->id;
                        $employee_material->save();
                    }
                    $product->quantity = 0;
                    $product->update();
                }
            }
        }
        $asset = ErpDepreciation::where('product_id', '=', $id)->first();
        if ($asset) {
            if ($request->get('purchase_date') != '') {

                $asset->purchase_date = date('Y-m-d', strtotime($request->purchase_date));
            }
            $asset->cost_price = $request->get('price');
            $asset->depreciation_rate = $request->get('depreciation_rate');
            $asset->save();
        }
        if ($product->category == 1) {
            $page = '/inventory';
        } elseif ($product->category == 2) {
            $page = '/equipment';
        } elseif ($product->category == 3) {
            $page = '/vehicles';
        }
        if ($product->category == 4) {
            $page = '/furniture';
        }
        ErpDepreciation::depreciation_calculate();

        if ($result) {
            return redirect($page)->with('message-success', 'Product has been updated.');
        } else {
            return redirect($page)->with('message-danger', 'Something went wrong.');
        }
    }
    public function assign(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'assigned','path'=>url()->current())
        );
        $request->validate([
            'quantity' => 'required'
        ]);
        $employee = ErpEmployee::where('id',$request->employee_id)->first();
        $product = ErpInventory::find($id);
        if ($request->quantity > $product->quantity) {
            return redirect('/inventory')->with('message-danger', 'You cannot assign more that available quantity.');
        } else {
            $category = $request->category;
            if ($request->project_id != null) {
                $project = ErpProject::find($request->project_id);
                $project_material = ErpProjectMaterial::where('product_id', '=', $product->product_id)->where('project_id', $request->project_id)->first();
                if ($project_material) {
                    $project_material->inventory_id = $id;
                    $project_material->quantity_sanctioned += $request->quantity;
                    $project_material->quantity_required -= $request->quantity;
                    if ($project_material->quantity_required < 0)
                        $project_material->quantity_required = 0;
                    $project_material->created_by = Auth::user()->id;
                    $project_material->update();
                }else {
                    $project_material = new ErpProjectMaterial();
                    if ($request->project_id == 0) {
                        $project_material->project_id = $request->project_id;
                    } else {
                        $project_material->project_id = $project->id;
                        $project_material->project_phase = $project->project_phase;
                    }
                    $project_material->inventory_id = $id;
                    $project_material->coa_id = $product->coa_id;
                    $project_material->product_id = $product->product_id;
                    $project_material->unit = $product->unit;
//                  $project_material->quantity = $request->quantity;
                    $project_material->quantity_sanctioned = $request->quantity;
                    $project_material->description = $product->description;
                    $project_material->created_by =  Auth::user()->id;
                    $project_material->save();
                }
            }
            if($request->employee_id != null){
                $employee_material = new ErpEmployeeMaterial();
                $employee_material->inventory_id = $id;
                $employee_material->employee_id = $request->employee_id;
                $employee_material->driver_id = $request->driver;
                $employee_material->coa_id = $product->coa_id;
                $employee_material->product_name = $product->product_name;
                $employee_material->indent_no = $request->indent_no;
                $employee_material->location = $product->location;
                $employee_material->room_no = $employee->room_no;
                $employee_material->quantity = $request->quantity;
                $employee_material->created_by =  Auth::user()->id;
                $employee_material->save();
            }
            $product->quantity -= $request->quantity;
            $result = $product->update();
            if($result) {
                if($category == 1){
                    return redirect('/inventory')->with('message-success', 'Product has been added.');
                } elseif($category == 2){
                    return redirect('/equipment')->with('message-success', 'Product has been added.');
                } elseif($category == 3){
                    return redirect('/vehicles')->with('message-success', 'Product has been added.');
                } elseif($category == 4){
                    return redirect('/furniture')->with('message-success', 'Product has been added.');
                }
            } else {
                return redirect()->back()->with('message-danger', 'Something went wrong.');
            }
            return redirect('/inventory')->with('message-success', 'Product has been assigned successfully.');
        }
    }
    public function assignBackView($id){
        return view('backEnd.inventory.assignBackView', compact('id'));
    }
    public function assignBack($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'assigned back','path'=>url()->current())
        );
        $product = ErpInventory::find($id);
        $product->room_no = null;
        $product->quantity++;
        $results = $product->update();
        $employee_materials = ErpEmployeeMaterial::where('inventory_id', $id)->get();
        if($employee_materials) {
            foreach ($employee_materials as $employee_material) {
//                $employee_material->quantity = 0;
//                $employee_material->update();
                $employee_material->delete();

            }
        }
        if($results){
            return redirect()->back()->with('message-success', 'Product has been assigned back to inventory');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
    public function printList($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        if ($id == 2) {
            $products = ErpInventory::where('category', '=', 2)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
            $category = 2;
        } elseif ($id == 3) {
            $products = ErpInventory::where('category', '=', 3)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
            $category = 3;
        } elseif ($id == 4) {
            $products = ErpInventory::where('category', '=', 4)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
            $category = 4;
        } else {
            $products = ErpInventory::where('category', '=', 1)->where('quantity', '>', 0)->where('active_status', '=', 1)->get();
            $category = 1;
        }
        $users = User::all();
        return view('backEnd.inventory.printList', compact('products', 'users', 'category'));
    }
    public function printAssignedList($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        if ($id == 2) {
            $products = ErpInventory::where('category', '=', 2)
                ->where('quantity', '=', 0)
                ->where('room_no', '!=', null)
                ->where('active_status', '=', 1)
                ->orderBy('room_no')
                ->get();
            $category = 2;
        } elseif ($id == 3) {
            $products = ErpInventory::where('category', '=', 3)->where('quantity', '=', 0)->where('active_status', '=', 1)->get();
            $category = 3;
        } else {
            $products = ErpInventory::where('category', '=', 4)
                ->where('quantity', '=', 0)
                ->where('room_no', '!=', null)
                ->where('active_status', '=', 1)
                ->orderBy('room_no')
                ->get();
            $category = 4;
        }
        $users = User::all();
        return view('backEnd.inventory.printList', compact('products', 'users', 'category'));
    }
    public function deleteInventoryView($id){
        $module = 'deleteInventory';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }
    public function deleteInventory($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $product = ErpInventory::find($id);
        $product->active_status = 0;

        $results = $product->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Product has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
