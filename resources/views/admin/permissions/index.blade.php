@extends('layouts.admin')
@section('content')
    @can('permission_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.permissions.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.permission.title_singular_one') }}
                </a>
            </div>
        </div>
    @endcan

    @can('permission_access')
        <div class="card">
            <div class="card-header">
                {{ trans('global.list') }} {{ trans('cruds.permission.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                        <thead class="thead-dark">
                        <tr>
                            <th>
                                {{ trans('cruds.permission.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.permission.fields.code') }}
                            </th>
                            <th colspan="3" style="text-align: center;">
                                {{ trans('cruds.manage') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $key => $permission)
                            @if ($permission->id == 18)
                                @else

                            <tr data-entry-id="{{ $permission->id }}" data-sort="{{ $permission->id }}">
                                <td>
                                    {{ $permission->title ?? '' }}
                                </td>
                                <td>
                                    {{ $permission->code ?? '' }}
                                </td>
                                <td>
                                    @can('permission_show')
                                        <a class="btn btn-sm btn-primary"
                                           href="{{ route('admin.permissions.show', $permission->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                </td>
                                <td class="align-content-center">
                                    @can('permission_edit')
                                        <a class="btn btn-sm btn-info "
                                           href="{{ route('admin.permissions.edit', $permission->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                </td>
                                <td class="table-danger">
                                    @can('permission_delete')
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                              style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-danger"
                                                   value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>

                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @endcan
            </div>
        </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $.extend(true, $.fn.dataTable.defaults, {
                order:      [[0, 'asc']],
                pageLength: 25,
            });
            $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection