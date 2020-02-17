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
        /* $admin = Admin::authUser();
        $graduates = Graduate::all();
        $courses = $graduates->groupBy('code')->map(function ($values) {
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

        return view('department.reports', compact('admin', 'graduates', 'courseChart', 'yearChart')); */
        $borderColors = [
            "rgba(30,198,246, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(255, 99, 132, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"
        ];

        $admin = Admin::authUser();
        $graduates = Graduate::all();
        $courses = $graduates->groupBy('degree')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();
        $years = $graduates->groupBy('batch_year')->map(function ($values) {
            return $values->count();
        })->sort()->reverse();

        $employmentChart = new GraduatesChart;
        $employmentChart->title('Employment', 18, '#00B5AD', 'bold', 'Product Sans');
        $employmentChart->labels(['Employed','Unemployed']);
        $employmentChart->dataset('Employment','doughnut',[40,10])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors,
        ]);
        $employmentChart->height(300);
        $employmentChart->displayAxes(false);

        $alignedChart = new GraduatesChart;
        $alignedChart->title('Aligned', 18, '#00B5AD', 'bold', 'Product Sans');
        $alignedChart->labels(['Aligned','Not Aligned']);
        $alignedChart->dataset('Job Alignment','pie',[32,18])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors
        ]);
        $alignedChart->height(300);
        $alignedChart->displayAxes(false);

        $employabilityChart = new GraduatesChart;
        $employabilityChart->title('Employed within...', 18, '#00B5AD', 'bold', 'Product Sans');
        $employabilityChart->labels(['6 months','After 6 months']);
        $employabilityChart->dataset('Employment','doughnut',[36,14])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors
        ]);
        $employabilityChart->height(300);
        $employabilityChart->displayAxes(false);

        //for 5 year chart
        $fiveYearEmploymentChart = new GraduatesChart;
        $fiveYearEmploymentChart->title('', 18, '#00B5AD', 'bold', 'Product Sans');
        $fiveYearEmploymentChart->labels(['2017','2018','2019','2020','2021']);
        $fiveYearEmploymentChart->dataset('','bar',[39,50,62,30,45])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors,
        ]);
        $fiveYearEmploymentChart->height(300);
        $fiveYearEmploymentChart->displayLegend(false);

        $fiveYearAlignedChart = new GraduatesChart;
        $fiveYearAlignedChart->title('', 15, '#00B5AD', 'bold', 'Product Sans');
        $fiveYearAlignedChart->labels(['2017','2018','2019','2020','2021']);
        $fiveYearAlignedChart->dataset('No. of Graduates','bar',[32,45,52,27,39])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors
        ]);
        $fiveYearAlignedChart->height(300);
        $fiveYearAlignedChart->displayLegend(false);

        $fiveYearEmployabilityChart = new GraduatesChart;
        $fiveYearEmployabilityChart->title('', 15, '#00B5AD', 'bold', 'Product Sans');
        $fiveYearEmployabilityChart->labels(['2017','2018','2019','2020','2021']);
        $fiveYearEmployabilityChart->dataset('No. of Graduates','bar',[30,42,48,25,36])->options([
            'color' => $borderColors,
            'backgroundColor' => $borderColors
        ]);
        $fiveYearEmployabilityChart->height(300);
        $fiveYearEmployabilityChart->displayLegend(false);

        return view('department.reports', compact('admin', 'graduates','employmentChart','employabilityChart', 'alignedChart','fiveYearEmploymentChart','fiveYearAlignedChart','fiveYearEmployabilityChart'));
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
