<?php

namespace App\Http\Controllers;

use App\ErpEmployeeIndent;
use App\Notifications\EmployeeMaterialIndent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;

class ErpEmployeeIndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indents = ErpEmployeeIndent::where('active_status', 1)->get();
        return view('backEnd.indents.index', compact('indents'));
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
        $request->validate([
            'employee_id' =>'required',
            'product' =>'required',
        ]);

        $material = new ErpEmployeeIndent();
        $material->employee_id = $request->employee_id;
        $material->product_name = $request->product;
        $material->quantity = $request->get('quantity');
        $material->description = $request->get('description');
        $id = $material->created_by = Auth::user()->id;
        $material->save();

        $material->indent_no = Carbon::now()->format('YM').$material->id;
        $result = $material->update();

        $user = User::find(1);
        Notification::send($user, new EmployeeMaterialIndent($material));

        if($result) {
            return redirect('/employee/'.$id)->with('message-success', 'Material Indent has been requested successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteIndentView($id)
    {
        $module = 'deleteEmployeeIndent';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteEmployeeIndent($id){
        $indent = ErpEmployeeIndent::find($id);
        $indent->active_status = 0;
        $results = $indent->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Employee indent has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
