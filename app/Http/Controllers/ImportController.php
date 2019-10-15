<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    private $departments = [
        'Arts and Sciences', 'Commerce', 'Education', 'Engineering',
        'ICCT', 'Law', 'Nursing'
    ];

    private $batches = [
        'October 2020', 'March 2020', 'October 2019', 'March 2019'
    ];

    public function import()
    {
        return view('import')->with([
            'departments' => $this->departments,
            'batches' => $this->batches
        ]);
    }

    public function parseImport(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $csv_data = array_map('str_getcsv', file($path));

            return view('import_fields')->with([
                'departments' => $this->departments,
                'batches' => $this->batches,
                'csv_data' => $csv_data
            ]);
        }
        else
            return redirect()->back();
    }

    public function processImport(Request $request)
    {

    }
}
