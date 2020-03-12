@extends('layouts.admin')
@section('content')
    @can('category_access')
        @can('category_show')
            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.category.title_singular') }}
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.category.fields.id') }}
                                </th>
                                <td>
                                    {{ $category->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.category.fields.code') }}
                                </th>
                                <td>
                                    {{ $category->code }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.category.fields.name') }}
                                </th>
                                <td>
                                    {{ $category->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.category.fields.is_active') }}
                                </th>
                                <td>
                                    {{ $category->is_active == 1 ? 'Да' : 'Нет' }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>

                    <nav class="mb-3">
                        <div class="nav nav-tabs">

                        </div>
                    </nav>
                    <div class="tab-content">

                    </div>
                </div>
            </div>
        @endcan
    @endcan
@endsection