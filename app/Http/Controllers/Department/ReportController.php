<?php

namespace App\Http\Controllers\Department;

use App\Charts\GraduatesChart;
use App\Charts\ResponsesChart;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Graduate;

class ReportController extends Controller
{
    public function reports()
    {
        $admin = Admin::authUser();
        $graduates = Graduate::all();
        $courses = $graduates->groupBy('degree')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();
        $years = $graduates->groupBy('batch_year')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();

        $courseChart = new GraduatesChart;
        $courseChart->title('Degree/Course', 18, '#00B5AD', 'bold', 'Product Sans');
        $courseChart->labels($courses->keys());
        $courseChart->dataset('Graduates', 'horizontalBar', $courses->values())->options([
            'color' => 'rgb(255, 196, 0)',
            'backgroundColor' => 'rgb(255, 196, 0)'
        ]);
        $courseChart->height(300);

        $yearChart = new GraduatesChart;
        $yearChart->title('School Year and Batch', 18, '#00B5AD', 'bold', 'Product Sans');
        $yearChart->labels($years->keys());
        $yearChart->dataset('Graduates', 'horizontalBar', $years->values())->options([
            'color' => 'rgb(255, 108, 97)',
            'backgroundColor' => 'rgb(255, 108, 97)'
        ]);
        $yearChart->height(300);

        return view('department.reports', compact('admin', 'graduates', 'courseChart', 'yearChart'));
    }

    public function report($graduateId)
    {
        $admin = Admin::authUser();
        $graduate = Graduate::find($graduateId);
        $responses = $graduate->responses;
        $names = $responses->groupBy('company_name')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();
        $addresses = $responses->groupBy('company_address')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();
        $positions = $responses->groupBy('job_position')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();
        $datesEmployed = $responses->groupBy('date_employed')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();

        $nameChart = new ResponsesChart;
        $nameChart->title('Company Name', 20, '#00B5AD', 'bold', 'Product Sans');
        $nameChart->labels($names->keys());
        $nameChart->dataset('Respondents', 'horizontalBar', $names->values())->options([
            'color' => 'rgb(255, 196, 0)',
            'backgroundColor' => 'rgb(255, 196, 0)'
        ]);
        $nameChart->height(300);

        $addressChart = new ResponsesChart;
        $addressChart->title('Company Address', 20, '#00B5AD', 'bold', 'Product Sans');
        $addressChart->labels($addresses->keys());
        $addressChart->dataset('Respondents', 'horizontalBar', $addresses->values())->options([
            'color' => 'rgb(255, 108, 97)',
            'backgroundColor' => 'rgb(255, 108, 97)'
        ]);
        $addressChart->height(300);

        $positionChart = new ResponsesChart;
        $positionChart->title('Job Position', 20, '#00B5AD', 'bold', 'Product Sans');
        $positionChart->labels($positions->keys());
        $positionChart->dataset('Respondents', 'horizontalBar', $positions->values())->options([
            'color' => 'rgb(108, 183, 97)',
            'backgroundColor' => 'rgb(108, 183, 97)'
        ]);
        $positionChart->height(300);

        $dateEmployedChart = new ResponsesChart;
        $dateEmployedChart->title('Date Employed', 20, '#00B5AD', 'bold', 'Product Sans');
        $dateEmployedChart->labels($datesEmployed->keys());
        $dateEmployedChart->dataset('Respondents', 'horizontalBar', $datesEmployed->values())->options([
            'color' => 'rgb(10, 103, 191)',
            'backgroundColor' => 'rgb(10, 103, 191)'
        ]);
        $dateEmployedChart->height(300);

        return view('department.report', compact('admin', 'graduate', 'nameChart', 'addressChart',
                'positionChart', 'dateEmployedChart', 'responses'));
    }
}
