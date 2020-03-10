@extends('layouts.admin')
@section('content')
    @can('role_access')

        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.role.title_singular_one') }}
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.id') }}
                            </th>
                            <td>
                                {{ $role->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.title') }}
                            </th>
                            <td>
                                {{ $role->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.badge_role') }}
                            </th>
                            <td>
                                <span class="badge badge-pill {{ $role->badge_role }}">{{ $role->badge_role }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.permissions') }}
                            </th>
                            <td>
                                @foreach($role->permissions as $id => $permissions)
                                    <span class="label label-success label-many" style="font-size: large">{{ $permissions->title }}<br></span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.created_at') }}
                            </th>
                            <td>
                                {{ $role->created_at }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.updated_at') }}
                            </th>
                            <td>
                                {{ $role->updated_at }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }} {{ trans('cruds.role.title_singular') }}
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