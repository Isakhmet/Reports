<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryReportRequest;
use App\Http\Requests\UpdateCategoryReportRequest;
use App\CategoriesReport;


class CategoryReportController extends Controller
{
    public function index()
    {
        $categories = CategoriesReport::all();
        return view('admin.categoryReport.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categoryReport.create');
    }

    public function store(StoreCategoryReportRequest $request)
    {
        $category = CategoriesReport::create($request->all());

        return redirect()->route('admin.category.index');
    }

    public function edit(CategoriesReport $category)
    {
        return view('admin.categoryReport.edit', compact( 'category'));
    }

    public function update(UpdateCategoryReportRequest $request, CategoriesReport $category)
    {
        $category->update($request->all());

        return redirect()->route('admin.category.index');
    }

    public function show(CategoriesReport $category)
    {
        return view('admin.categoryReport.show', compact('category'));
    }

    public function destroy(CategoriesReport $category)
    {
        $category->delete();

        return back();
    }
}