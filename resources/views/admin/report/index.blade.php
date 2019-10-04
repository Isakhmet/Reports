@extends('layouts.admin')
@section('content')
    @can('report_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.report.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.report.title_single') }}
                </a>
            </div>
        </div>
    @endcan
    @can('report_access')
        <div class="card">
            <div class="card-header">
                {{ trans('global.list') }} {{ trans('cruds.report.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable"
                           class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead class="thead-dark">
                        <tr>
                            <th>
                                {{ trans('cruds.report.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.description') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.is_active') }}
                            </th>
                            @can('root')
                                <th>
                                    {{ trans('cruds.report.fields.created_at') }}
                                </th>

                                <th>
                                    {{ trans('cruds.manage') }}
                                </th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $key => $report)
                            <tr data-entry-id="{{ $report->id }}" data-sort="{{ $report->id }}">
                                <td>
                                    {{ $report->id ?? '' }}
                                </td>
                                <td>
                                    {{ $report->title ?? '' }}
                                </td>
                                <td>
                                    {{ $report->description ?? '' }}
                                </td>
                                <td>
                                    {{ $report->is_active == 1 ? 'Да' : 'Нет' }}
                                </td>
                                @can('root')
                                    <td>
                                        {{ $report->created_at ?? '' }}
                                    </td>
                                    <td>
                                        @can('report_show')
                                            <a class="btn btn-xs btn-primary"
                                               href="{{ route('admin.report.show', $report->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('report_edit')
                                            <a class="btn btn-xs btn-info"
                                               href="{{ route('admin.report.edit', $report->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('report_delete')
                                            <form action="{{ route('admin.report.destroy', $report->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                  style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger"
                                                       value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
                                    </td>
                                @endcan
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
            $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection