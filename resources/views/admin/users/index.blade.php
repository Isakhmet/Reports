@extends('layouts.admin')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
                @can('root')
                    <a class="btn btn-success" href="{{ route("admin.users.create") }}">
                        {{ trans('cruds.root.users_view') }}
                    </a>
                @endcan
            </div>
        </div>
    @endcan
    @can('user_access')
        <div class="card">
            <div class="card-header">
                {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead class="thead-dark">
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
                            @can('root')
                                <th>
                                    {{ trans('cruds.user.fields.created_at') }}
                                </th>
                            @endcan
                            <th>
                                {{ trans('cruds.user.fields.roles') }}
                            </th>
                            <th>
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
                                @can('root')
                                    <td>
                                        {{ $user->created_at ?? '' }}
                                    </td>
                                @endcan
                                <td>
                                    @foreach($user->roles as $key => $item)
                                        <span class="badge badge-pill {{ $item->badge_role }}">{{ $item->title }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('user_show')
                                        @if ($item->id == 7)
                                                <a class="btn btn-xs btn-primary disabled"
                                                   href="#">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @else
                                        <a class="btn btn-xs btn-primary"
                                           href="{{ route('admin.users.show', $user->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                            @endif
                                    @endcan

                                    @can('user_edit')
                                            @if ($item->id == 7)
                                                    <a class="btn btn-xs btn-info disabled"
                                                       href="#">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @else
                                                <a class="btn btn-xs btn-info"
                                                   href="{{ route('admin.users.edit', $user->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                @endif

                                    @endcan

                                    @can('user_delete')
                                        @if ($item->id == 7)
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger disabled"
                                                               value="{{ trans('global.delete') }}" disabled>
                                                    </form>
                                        @else
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger"
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
            $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

        function myGeeks() {
            var g                                     = document.getElementById("toogle-on").defaultChecked;
            document.getElementById("sudo").innerHTML = g;
        }

    </script>
@endsection