@extends('layouts.admin')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular_one') }}
                </a>
            </div>
        </div>
    @endcan
    @can('user_access')
    <div class="card">
            <div class="card-header">
                {{ trans('global.list') }} {{ trans('cruds.user.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead class="thead-dark table table-bordered table-striped table-hover datatable datatable-User">
                        <tr>
                            <th>
                                {{ trans('cruds.user.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.roles') }}
                            </th>
                            <th colspan="3" style="text-align: center;">
                                {{ trans('cruds.manage') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr data-entry-id="{{ $user->id }}">
                                <td>
                                    {{ $user->id ?? '' }}
                                </td>
                                <td>
                                    {{ $user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $user->email ?? '' }}
                                </td>
                                <td>
                                        {{ $user->created_at ?? '' }}
                                </td>
                                <td>
                                    @foreach($user->roles as $key => $item)
                                        <span class="badge badge-pill {{ $item->badge_role }}">{{ $item->title }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('user_show')
                                        @if ($item->id == 1)
                                                <a class="btn btn-sm btn-primary disabled"
                                                   href="#">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @else
                                        <a class="btn btn-sm btn-primary"
                                           href="{{ route('admin.users.show', $user->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                            @endif
                                    @endcan
                                </td>
                                <td>
                                    @can('user_edit')
                                            @if ($item->id == 1)
                                                    <a class="btn btn-sm btn-primary disabled"
                                                       href="#">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @else
                                                <a class="btn btn-sm btn-primary"
                                                   href="{{ route('admin.users.edit', $user->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                @endif

                                    @endcan
                                </td>
                                <td class="table-danger">
                                    @can('user_delete')
                                        @if ($item->id == 1)
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-sm btn-danger disabled"
                                                               value="{{ trans('global.delete') }}" disabled>
                                                    </form>
                                        @else
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-sm btn-danger"
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
                order:      [[0, 'asc']],
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