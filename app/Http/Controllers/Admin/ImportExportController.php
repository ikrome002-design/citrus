<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\BulkExport;
use App\Imports\BulkImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
class ImportExportController extends Controller
{
  
    public function importExportView()
    {
       return view('importexport');
    }
    public function import(Request $request) 
    {
        $this->validate($request, [
            'file' => ['required'],
        ]);
        Excel::import(new BulkImport,request()->file('file'));
           
        return back()->with('message', 'Import Done!');;
    }
    public function export(){

       return Excel::download(new BulkExport, 'list.xlsx');

    }
}