<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndentController extends Controller
{
    function select(){
       DB::table('indents')->get();
       return view('backEnd.Indent.index');
    }
    function insert(Request $request){
        DB::table('indents')->insert(
            array('vendor'=>$request->vendor,'purpose'=>'check')
        );
        return view('backEnd.Indent.index');
    }
    function update(){
        DB::table('indents')->where('id',3)->update(
            array('vendor'=>'well','purpose'=>'check')
        );
        return view('backEnd.Indent.index');
    }
    function delete(){
        DB::table('indents')->where('id',6)->delete();
        return view('backEnd.Indent.index');
    }
    
}
