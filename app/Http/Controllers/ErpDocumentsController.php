<?php

namespace App\Http\Controllers;

use App\ErpClientDocument;
use App\ErpDocument;
use App\ErpEmployee;
use App\ErpEmployeeDocument;
use App\ErpEmployeeEducation;
use App\ErpEmployeeWorkExperience;
use App\ErpInventory;
use App\ErpProject;
use App\ErpProjectDocument;
use App\ErpVendorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ErpDocumentsController extends Controller
{
    public function index()
    {
        $documents = ErpDocument::all();
        return view('backEnd.document.index', compact('documents'));
    }

    public function store(Request $request){
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'stored','path'=>url()->current())
        );
        $request->validate([
            'document_name'=>'required|string|min:1|max:100',
            'upload_document'=> 'required|mimes:pdf,xls,xlsx,csv,zip,png,jpg,jpeg'
        ]);

        $document = new ErpDocument();
        $document->document_name = $request->get('document_name');
        if ($request->hasFile('upload_document')) {
            $upload = $request->file('upload_document');
            $upload_name =  time() . $upload->getClientOriginalName();
            $destinationPath = public_path('/uploads/documents');
            $upload->move($destinationPath, $upload_name);
            $document->upload_document = '/uploads/documents/'.$upload_name;
        }
        $document->description = $request->get('description');
        $document->created_by = Auth::user()->id;

        $result = $document->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Document has been uploaded successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function documentPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpDocument::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;
        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function uploadEmployeeDocument(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'updated','path'=>url()->current())
        );
        $request->validate([
            'document_name'=>'required|string|min:1|max:100',
            'upload_document'=> 'required|mimes:pdf,xls,xlsx,csv,zip,png,jpg,jpeg'
        ]);

        $document = new ErpEmployeeDocument();
        $document->employee_id = $id;
        $document->document_name = $request->get('document_name');
        if ($request->hasFile('upload_document')) {
            $upload = $request->file('upload_document');
            $upload_name =  time() . $upload->getClientOriginalName();
            $destinationPath = public_path('/uploads/documents');
            $upload->move($destinationPath, $upload_name);
            $document->upload_document = '/uploads/documents/'.$upload_name;
        }
        $document->description = $request->get('description');

        $result = $document->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Document has been uploaded successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function employeePdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $employee = ErpEmployee::find($id);
        $file=$employee->joining_letter;
        $pathToFile = public_path().$file;

        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function employeeDocumentPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpEmployeeDocument::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;

        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function employeeEducationPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpEmployeeEducation::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;

        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function employeeWorkExperiencePdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpEmployeeWorkExperience::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;

        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function uploadProjectDocument(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'uploaded','path'=>url()->current())
        );
        $request->validate([
            'document_name'=>'required|string|min:1|max:100',
            'upload_document'=> 'required|mimes:pdf,xls,xlsx,csv,png,jpg,jpeg',
        ]);

        $project = ErpProject::find($id);

        $document = new ErpProjectDocument();
        $document->project_id = $id;
        $document->project_phase = $project->project_phase;
        $document->document_name = $request->get('document_name');
        if ($request->hasFile('upload_document')) {
            $upload = $request->file('upload_document');
            $upload_name =  time() . $upload->getClientOriginalName();
            $destinationPath = public_path('/uploads/documents');
            $upload->move($destinationPath, $upload_name);
            $document->upload_document = '/uploads/documents/'.$upload_name;
        }
        $document->description = $request->get('description');
        $document->created_by = Auth::user()->id;

        $result = $document->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Document has been uploaded successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function projectPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpProjectDocument::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;
        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function uploadClientDocument(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'uploaded','path'=>url()->current())
        );
        $request->validate([
            'document_name'=>'required|string|min:1|max:100',
            'upload_document'=> 'required|mimes:pdf,xls,xlsx,csv,zip,png,jpg,jpeg',
        ]);

        $document = new ErpClientDocument();
        $document->client_id = $id;
        $document->document_name = $request->get('document_name');
        if ($request->hasFile('upload_document')) {
            $upload = $request->file('upload_document');
            $upload_name =  time() . $upload->getClientOriginalName();
            $destinationPath = public_path('/uploads/client_documents');
            $upload->move($destinationPath, $upload_name);
            $document->upload_document = '/uploads/client_documents/'.$upload_name;
        }
        $document->description = $request->get('description');
        $document->created_by = Auth::user()->id;

        $result = $document->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Document has been uploaded successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function clientPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpClientDocument::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;
        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function uploadVendorDocument(Request $request, $id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'uploaded','path'=>url()->current())
        );
        $request->validate([
            'document_name'=>'required|string|min:1|max:100',
            'upload_document'=> 'required|mimes:pdf,xls,xlsx,csv,zip,png,jpg,jpeg',
        ]);

        $document = new ErpVendorDocument();
        $document->vendor_id = $id;
        $document->document_name = $request->get('document_name');
        if ($request->hasFile('upload_document')) {
            $upload = $request->file('upload_document');
            $upload_name =  time() . $upload->getClientOriginalName();
            $destinationPath = public_path('/uploads/vendor_documents');
            $upload->move($destinationPath, $upload_name);
            $document->upload_document = '/uploads/vendor_documents/'.$upload_name;
        }
        $document->description = $request->get('description');
        $document->created_by = Auth::user()->id;

        $result = $document->save();

        if($result) {
            return redirect()->back()->with('message-success', 'Document has been uploaded successfully');
        } else {
            return redirect()->back()->with('message-danger', 'Something went wrong. Please try again');
        }
    }

    public function vendorPdf($id) {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpVendorDocument::find($id);
        $file=$document->upload_document;
        $pathToFile = public_path().$file;
        if (file_exists(public_path().$file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function inventoryPdf($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'printed','path'=>url()->current())
        );
        $document = ErpInventory::find($id);
        $file = $document->upload_document;
        $pathToFile = public_path() . $file;
        if (file_exists(public_path() . $file))
            return Response::file($pathToFile);
        else
            return redirect()->back()->with('message-danger', 'Sorry, the file could not be found.');
    }

    public function deleteDocumentView($id)
    {
        $module = 'deleteDocument1';
        return view('backEnd.showDeleteModal', compact('id', 'module'));
    }

    public function deleteDocument($id)
    {
        DB::table('history_log')->insert(
            array('user'=>Auth::user()->name,'history_type'=>'deleted','path'=>url()->current())
        );
        $documentk = ErpDocument::find($id);
        $documentk->delete();
        $documents = ErpDocument::all();
        return view('backEnd.document.index', compact('documents'));
    }
}
