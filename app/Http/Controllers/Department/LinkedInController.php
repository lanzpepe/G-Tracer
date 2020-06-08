<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CsvFile;
use App\Models\LinkedInProfile;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use League\Csv\Reader;
use League\Csv\Statement;

class LinkedInController extends Controller
{
    use StaticTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        CsvFile::truncate();
        $admin = Admin::authUser();
        $profiles = LinkedInProfile::all();

        return view('department.linkedin', compact('admin', 'profiles'));
    }

    public function parse(Request $request)
    {
        $admin = Admin::authUser();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();
            $file = Reader::createFromPath($path, 'r')->setHeaderOffset(0);
            $csvData = (new Statement)->process($file);

            $csvFile = CsvFile::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'has_header' => $request->has('header'),
                'data' => json_encode($csvData)
            ]);

            return view('department.fields_in', compact('admin', 'csvData', 'csvFile'));
        }

        return redirect()->route('profiles.index');
    }

    public function upload(Request $request)
    {
        try {
            $csv = CsvFile::find(Crypt::decrypt($request->data));
            $csvData = json_decode($csv->data, true);

            foreach ($csvData as $data) {
                LinkedInProfile::create([
                    'id' => $data['id'],
                    'full_name' => $data['Full name'],
                    'profile_url' => $data['Profile url'],
                    'first_name' => $data['First name'],
                    'last_name' => $data['Last name'],
                    'avatar' => empty($data['Avatar']) ? null : $data['Avatar'],
                    'title' => empty($data['Title']) ? null : $data['Title'],
                    'company' => empty($data['Company']) ? null : $data['Company'],
                    'position' => empty($data['Position']) ? null : $data['Position']
                ]);
            }

            $csv->delete();

            return redirect()->route('profiles.index')->with('success', 'Data uploaded successfully.');

        } catch (DecryptException $e) {
            echo($e->getMessage());
        }
    }
}
