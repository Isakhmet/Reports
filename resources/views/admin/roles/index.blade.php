@extends('layouts.admin')
@section('content')
    @can('role_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.roles.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    @can('role_access')
        <div class="card">
            <div class="card-header">
                {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                        <thead class="thead-dark">
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.role.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.role.fields.permissions') }}
                            </th>
                            <th>
                                Просмотр
                            </th>
                            <th>
                                Редактирование
                            </th>
                            <th>
                                Удаление
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $key => $role)
                            <tr data-entry-id="{{ $role->id }}">
                                <td>
                                    {{ $role->id ?? '' }}
                                </td>
                                <td>
                                    <h4>
                                        <span class="badge badge-pill {{ $role->badge_role }}">{{ $role->title ?? '' }}</span>
                                    </h4>
                                </td>
                                <td>
                                    <h6>
                                        @foreach($role->permissions as $key => $item)
                                            <span class="badge badge-success">{{ $item->title }}</span>
                                        @endforeach
                                    </h6>
                                </td>
                                <td>
                                    @can('role_show')
                                        @if ($role->id == 7)
                                            <a class="btn btn-sm btn-outline-primary disabled"
                                               href="{{ route('admin.roles.show', $role->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @else
                                            <a class="btn btn-sm btn-outline-primary"
                                               href="{{ route('admin.roles.show', $role->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                                <td>
                                    @can('role_edit')
                                        @if ($role->id == 7)
                                            <a class="btn btn-sm btn-outline-info disabled"
                                               href="{{ route('admin.roles.edit', $role->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @else
                                            <a class="btn btn-sm btn-outline-info"
                                               href="{{ route('admin.roles.edit', $role->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                                <td>
                                    @can('role_delete')
                                        @if ($role->id == 7)
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-sm btn-outline-danger"
                                                       value="{{ trans('global.delete') }}" disabled>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-sm btn-outline-danger"
                                                       value="{{ trans('global.delete') }}">
                                            </form>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
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
                order:      [[1, 'asc']],
                pageLength: 10,
            });
            $('.datatable-Role:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection