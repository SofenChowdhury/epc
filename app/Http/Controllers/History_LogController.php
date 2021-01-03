<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class History_LogController extends Controller
{
    function history(){
        $history_value = DB::table('history_log')->get();
        return view('backEnd.history_log.index', compact('history_value'));
    }
}
