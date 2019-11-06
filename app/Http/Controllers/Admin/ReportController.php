<?php

namespace App\Http\Controllers\Admin;

use App\CategoriesReport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Report;


class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();

        return view('admin.report.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.report.create');
    }

    public function store(StoreReportRequest $request)
    {
        $report = Report::create($request->all());

        return redirect()->route('admin.report.index');
    }

    public function edit(Report $report)
    {
        $category = CategoriesReport::all()
                                    ->pluck('code', 'id')
        ;
        $report->load('category');

        return view('admin.report.edit', compact('report', 'category'));
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        $report = Report::find($request->input('id'));

        $report->code        = $request->input('code');
        $report->name        = $request->input('name');
        $report->category_id = $request->input('category_id');
        $report->is_active   = $request->input('is_active');
        $report->save();

        return redirect()->route('admin.report.index');
    }

    public function show(Report $report)
    {
        return view('admin.report.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return back();
    }
}