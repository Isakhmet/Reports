@extends('layouts.admin')
@section('content')
    @can('permission_access')

        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.permission.title_singular_one') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.id') }}
                            </th>
                            <td>
                                {{ $permission->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.title') }}
                            </th>
                            <td>
                                {{ $permission->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.code') }}
                            </th>
                            <td>
                                {{ $permission->code }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.created_at') }}
                            </th>
                            <td>
                                {{ $permission->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $permission->updated_at }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }} {{ trans('cruds.permission.title_singular') }}
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
@endsection