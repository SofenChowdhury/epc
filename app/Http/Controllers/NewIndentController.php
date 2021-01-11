<?php

namespace App\Http\Controllers;
use App\Notifications\TransactionApproval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class NewIndentController extends Controller
{
    public function index(Request $request)
    {
        $indentDataChild = DB::table('new_indent_child')->get();
        $indentDataMaster = DB::table('new_indent_master')->get();
        return view('backEnd.showIndent',compact('indentDataMaster','indentDataChild'));
    }
    public function create(Request $request)
    {
        return view('backEnd.addIndent');
    }
    public function insert(Request $request)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'inserted','path'=>url()->current())
        );
        $create = DB::table('new_indent_master')
                    ->insert([
                        'title' => $request->title,
                        'project' => $request->project,
                        'date' => $request->date,
                        'indent_no' => $request->voucher_no,
                        'note' => $request->note,
                        'accountant' => Auth::user()->name,
                        'accountant_remark' => $request->remarks
                    ]);
        $last_inserted_id = DB::table('new_indent_master')
            ->where('indent_no', $request->voucher_no)->first();
        for($i = 0; $i < count($request->vendor); $i++){
            DB::table('new_indent_child')
                ->insert([
                    'master_id' => $last_inserted_id->id,
                    'vendor' => $request->vendor[$i],
                    'purpose' => $request->purpose[$i],
                    'exp_code' => $request->exp_code[$i],
                    'amount' => $request->amount[$i]
                ]);
        }
        return redirect('check_indents')->with('message','Indent data inserted successfully');
    }
    function deleteView($id){
        return view('backEnd.deleteIndent', compact('id'));
    }
    function delete(Request $request, $id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
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
    public function check(Request $request)
    {
        $indentDataChild = DB::table('new_indent_child')->get();
        $indentDataMaster = DB::table('new_indent_master')->get();
        return view('backEnd.checkIndent',compact('indentDataMaster','indentDataChild'));
    }
    public function edit($id)
    {
        $indentDataChild = DB::table('new_indent_child')->where('master_id', '=', $id)->get();
        return view('backEnd.editIndent', compact('indentDataChild','id'));
    }
    public function update(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'indent permission','path'=>url()->current())
        );
        DB::table('new_indent_child')->where('master_id',$id)->delete();
        for($i = 0; $i < count($request->vendor); $i++){
             DB::table('new_indent_child')
                ->insert([
                    'master_id' => $id,
                    'vendor' => $request->vendor[$i],
                    'purpose' => $request->purpose[$i],
                    'exp_code' => $request->exp_code[$i],
                    'amount' => $request->amount[$i]
                ]);
        }
        DB::table('new_indent_master')->where('id',$id)->update([
           'confirm' => 1
        ]);
        return redirect('show_indents');
    }
    function action(Request $request){
        if ($request->indentUser == 'manager'){
            DB::table('new_indent_master')->where('id',$request->id)->update([
                'manager' => Auth::user()->name,
                'manager_action' => $request->action,
                'manager_remark' => $request->remark.' by '.Auth::user()->name
            ]);
        }elseif($request->indentUser == 'associate_director'){
            DB::table('new_indent_master')->where('id',$request->id)->update([
                'associate_director' => Auth::user()->name,
                'associate_director_action' => $request->action,
                'associate_director_remark' => $request->remark.' by '.Auth::user()->name
            ]);
        }elseif($request->indentUser == 'director_2'){
            DB::table('new_indent_master')->where('id',$request->id)->update([
                'director_2' => Auth::user()->name,
                'director_2_action' => $request->action,
                'director_2_remark' => $request->remark.' by '.Auth::user()->name
            ]);
        }elseif($request->indentUser == 'director_1'){
            DB::table('new_indent_master')->where('id',$request->id)->update([
                'director_1' => Auth::user()->name,
                'director_1_action' => $request->action,
                'director_1_remark' => $request->remark.' by '.Auth::user()->name
            ]);
        }elseif($request->indentUser == 'chairman'){
            DB::table('new_indent_master')->where('id',$request->id)->update([
                'chairman' => Auth::user()->name,
                'chairman_action' => $request->action,
                'chairman_remark' => $request->remark.' by '.Auth::user()->name
            ]);
        }
        return redirect()->back();
    }
    public function IndentPrint($id){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $indentDataChild = DB::table('new_indent_child')->where('master_id',$id)->get();
        $indentDataMaster = DB::table('new_indent_master')->where('id',$id)->first();
        $data = [
            'indentDataMaster'=>$indentDataMaster,
            'indentDataChild' =>$indentDataChild
        ];
        $pdf = PDF::loadView('backEnd.indentPrint', $data);
        return $pdf->stream('invoice.pdf');
    }
}
