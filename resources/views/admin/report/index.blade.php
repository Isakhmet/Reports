@extends('layouts.admin')
@section('content')
    @can('report_access')
        @can('report_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.report.create") }}">
                        {{ trans('global.add') }} {{ trans('cruds.report.title_single') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="card">
            <div class="card-header">
                {{ trans('global.list') }} {{ trans('cruds.report.title_singular') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable"
                           class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead class="thead-dark">
                        <tr style="text-align: center;">
                            <th>
                                {{ trans('cruds.report.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.code') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.category') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.is_active') }}
                            </th>
                            <th>
                                {{ trans('cruds.report.fields.created_at') }}
                            </th>
                            <th>
                                {{ trans('cruds.manage') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $key => $report)
                            <tr data-entry-id="{{ $report->id }}" data-sort="{{ $report->id }}">
                                <td style="text-align: center;">
                                    {{ $report->id ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $report->code ?? '' }}
                                </td>
                                <td>
                                    {{ $report->name ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    <h4>
                                        @foreach($report->category as $key => $item)
                                           <span class="badge badge-warning">{{ $item->name }}</span>
                                        @endforeach
                                    </h4>
                                </td>
                                <td style="text-align: center;">
                                    {{ $report->is_active == 1 ? 'Да' : 'Нет' }}
                                </td>
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