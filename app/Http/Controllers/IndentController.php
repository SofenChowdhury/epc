<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IndentController extends Controller
{
    function select(){
       $indent_value = DB::table('indents')->where('active_status', '=', 1)->get();
       return view('backEnd.Indent.index', compact('indent_value'));
    }
    function insert(Request $request){
        $request->validate([
            'vendor' => "required|string|min:1|max:50",
            'purpose' => "required|string|min:1|max:50",
            'code' => "required|string|min:1|max:50",
            'amount' => "required|integer|min:1|max:50"
        ]);
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $results = DB::table('indents')->insert(
            array('vendor'=>$request->vendor,'purpose'=>$request->purpose,'code'=>$request->code,'amount'=>$request->amount,'remark'=>$request->remark,'created_by'=>Auth::user()->name)
        );
        if($results){
            return redirect()->back()->with('message-success', 'New Indent has been added successfully');
        }else{
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }
    public function edit($id){
        $editData = DB::table('indents')->find($id);
        $indent_value = DB::table('indents')->where('active_status', '=', 1)->get();
        return view('backEnd.Indent.index', compact('editData','indent_value'));
    }
    function update(Request $request, $id){
        $request->validate([
            'vendor' => "required|string|min:1|max:50",
            'purpose' => "required|string|min:1|max:50",
            'code' => "required|string|min:1|max:50",
            'amount' => "required|integer|min:1|max:50"
        ]);
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $results = DB::table('indents')->where('id',$id)->update(
            array('vendor'=>$request->vendor,'purpose'=>$request->purpose,'code'=>$request->code,'amount'=>$request->amount,'remark'=>$request->remark,'created_by'=>Auth::user()->name)
        );
        if($results){
            return redirect('select')->with('message-success', 'New Indent has been updated successfully');
        }else{
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }
    function deleteView($id){
        return view('backEnd.indent.deleteIndent', compact('id'));
    }
    function delete($id){
        $results = DB::table('indents')->where('id',$id)->delete();
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        if($results){
            return redirect()->back()->with('message-success', 'New Indent has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }
    
}
