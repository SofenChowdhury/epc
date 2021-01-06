<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpEmployeeCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpEmployeeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_category = ErpEmployeeCategory::where('active_status', '=', 1)->get();
        return view('backEnd.employees.category.index', compact('employee_category'));
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
            'category_name' => "required|string|min:1|max:50",
            'category_given_id' => "required|unique:erp_employee_categories,given_id,".$request->category_given_id."|string|min:3|max:50",
        ]);

       $category = new ErpEmployeeCategory();
       $category->given_id = $request->category_given_id;
       $category->category_name = $request->category_name;
       $category->description = $request->description;
       $category->created_by = Auth::user()->id;
       $results = $category->save();

       if($results){
           return redirect()->back()->with('message-success', 'New Employee Category has been added successfully');
       }else{
           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
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
        $editData = ErpEmployeeCategory::find($id);
        $employee_category = ErpEmployeeCategory::where('active_status', '=', 1)->get();
        return view('backEnd.employees.category.index', compact('editData', 'employee_category'));
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
            'category_name' => "required|string|min:1|max:50",
        ]);
       $category = ErpEmployeeCategory::find($id);
       $category->category_name = $request->category_name;
       $category->description = $request->description;
       $category->updated_by = Auth::user()->id;
       $results = $category->update();

       if($results){
           return redirect('/employee-category')->with('message-success', 'Category  has been updated successfully');
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
    public function deleteEmployeeCategoryView($id){

         return view('backEnd.employees.category.deleteEmployeeCategoryView', compact('id'));
    }

    public function deleteEmployeeCategory($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $category = ErpEmployeeCategory::find($id);
        $category->active_status = 0;

        $results = $category->update();

        if($results){
            return redirect()->back()->with('message-success-delete', 'Employee category has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
