<?php

namespace App\Http\Controllers;

use App\ErpProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ErpProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ErpProduct::where('product_type', '=', 0)->get();
        $type = 0;
        return view('backEnd.inventory.product.index', compact('products', 'type'));
    }

    public function products()
    {
        $products = ErpProduct::where('product_type', '=', 1)->get();
        $type = 1;
        return view('backEnd.inventory.product.index', compact('products', 'type'));
    }
    public function printList()
    {
        $products = ErpProduct::where('product_type', '=', 1)->get();

        $type = 1;
        return view('backEnd.inventory.product.printList', compact('products', 'type'));
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
            'product_name'=>'required|string|min:1|max:150',
            'unit'=>'min:0|max:100',
        ]);

        $product = new ErpProduct();
        $product->product_type = $request->product_type;
        $product->product = $request->product_name;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $result = $product->save();

        if($result && $product->product_type == 0) {
            return redirect('/product')->with('message-success', 'Product has been updated.');
        }
        elseif ($result && $product->product_type == 1)
            return redirect('/assets')->with('message-success', 'Product has been updated.');
        else {
            return redirect('/product')->with('message-success', 'Something went wrong.');
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
        $editData = ErpProduct::find($id);
        $products = ErpProduct::all();
        $type = $editData->product_type;
        return view('backEnd.inventory.product.index', compact('editData','products', 'type'));
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
            'product_name'=>'required|string|min:1|max:150',
            'unit'=>'min:0|max:100',
        ]);

        $product = ErpProduct::find($id);
        $product->product = $request->product_name;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $result = $product->update();

        if($result && $product->product_type == 0) {
            return redirect('/product')->with('message-success', 'Product has been updated.');
        }
        elseif ($result && $product->product_type == 1)
            return redirect('/assets')->with('message-success', 'Product has been updated.');
        else {
            return redirect('/product')->with('message-success', 'Something went wrong.');
        }
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

    public function deleteProductView($id){
        $module = 'deleteProduct';
        return view('backEnd.showDeleteModal', compact('id','module'));
    }

    public function deleteProduct($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $result = ErpProduct::destroy($id);
        if($result){
            return redirect()->back()->with('message-success-delete', 'Product has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger-delete', 'Something went wrong, please try again');
        }
    }
}
