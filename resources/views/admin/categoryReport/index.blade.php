@extends('layouts.admin')
@section('content')
    @can('category_access')
        @can('category_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.category.create") }}">
                        {{ trans('global.add') }} {{ trans('cruds.category.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="card">
            <div class="card-header">
                {{ trans('global.list') }} {{ trans('cruds.category.title_singular_many') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable"
                           class=" table table-bordered table-striped table-hover datatable datatable-User">
                        <thead class="thead-dark">
                        <tr style="text-align: center;">
                            <th>
                                {{ trans('cruds.category.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.code') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.is_active') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.created_at') }}
                            </th>

                            <th>
                                {{ trans('cruds.manage') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr data-entry-id="{{ $category->id }}" data-sort="{{ $category->id }}">
                                <td style="text-align: center;">
                                    {{ $category->id ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $category->code ?? '' }}
                                </td>
                                <td>
                                    {{ $category->name ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $category->is_active == 1 ? 'Да' : 'Нет' }}
                                </td>
                                <td>
                                    {{ $category->created_at ?? '' }}
                                </td>
                                <td>
                                    @can('category_show')
                                        <a class="btn btn-xs btn-primary"
                                           href="{{ route('admin.category.show', $category->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('category_edit')
                                        <a class="btn btn-xs btn-info"
                                           href="{{ route('admin.category.edit', $category->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('category_delete')
                                        <form action="{{ route('admin.category.destroy', $category->id) }}"
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