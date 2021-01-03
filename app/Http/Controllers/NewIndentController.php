<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NewIndentController extends Controller
{
    public function index(Request $request)
    {
        $indentDataChild = DB::table('new_indent_master')->get();
        $indentDataMaster = DB::table('new_indent_master')->get();
        return view('backEnd.showIndent',compact('indentDataMaster'));
    }
    public function create(Request $request)
    {
        return view('backEnd.addIndent');
    }
    public function insert(Request $request)
    {
        $create = DB::table('new_indent_master')
                    ->insert([
                        'title' => $request->title,
                        'indent_no' => $request->voucher_no,
                        'date' => $request->date,
                        'note' => $request->note,
                        'accountant' => Auth::user()->name,
                        'accountant_remark' => $request->remarks
                    ]);
        $last_inserted_id = DB::table('new_indent_master')
            ->where('indent_no', $request->voucher_no)->first();
        for($i = 0; $i < count($request->vendor); $i++){
            $childcreate = DB::table('new_indent_child')
                ->insert([
                    'master_id' => $last_inserted_id->id,
                    'vendor' => $request->vendor[$i],
                    'purpose' => $request->purpose[$i],
                    'exp_code' => $request->exp_code[$i],
                    'amount' => $request->amount[$i]
                ]);
        }
        return redirect('show_indents')->with('message','Indent data inserted successfully');
    }
    function deleteView($id){
        return view('backEnd.deleteIndent', compact('id'));
    }
    function delete(Request $request, $id){
        $limit = DB::table('new_indent_child')->get();
        for($i = 0; $i < count($limit); $i++){
            DB::table('new_indent_child')->where('master_id',$id)->delete();
        }
        $results = DB::table('new_indent_master')->where('id',$id)->delete();
        
        if($results){
            return redirect()->back()->with('message-success', 'New Indent has been deleted successfully');
        }else{
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }
}
