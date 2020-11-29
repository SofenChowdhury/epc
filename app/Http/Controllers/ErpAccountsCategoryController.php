<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErpAccountsCategory;

class ErpAccountsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts_category = ErpAccountsCategory::all();
        return view('backEnd.chart_of_accounts.account_category.index', compact('accounts_category'));
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
//        $request->validate([
//            'category_name' => "required"
//        ]);
//
//       $category = new ErpAccountsCategory();
//       $category->category_name = $request->category_name;
//       $category->created_by = Auth::user()->id;
//       $results = $category->save();
//
//       if($results){
//           return redirect()->back()->with('message-success', 'New Account Category has been added successfully');
//       }else{
//           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
//       }
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
//        $editData = ErpAccountsCategory::find($id);
//        $accounts_category = ErpAccountsCategory::all();
//        return view('backEnd.chart_of_accounts.account_category.index', compact('editData', 'accounts_category'));
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
//         $request->validate([
//           'category_name' => "required"
//
//        ]);
//
//       $category = ErpAccountsCategory::find($id);
//       $category->category_name = $request->category_name;
//       $category->updated_by = Auth::user()->id;
//       $results = $category->update();
//
//       if($results){
//           return redirect()->back()->with('message-success', 'Category  has been updated successfully');
//       }else{
//           return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
//       }
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
