@extends('layouts.admin')
@section('content')
    @can('report_access')
    @can('report_edit')
        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.report.title_single') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.report.update", [$report->id]) }}" method="POST"
                      enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="id" name="id" class="form-control" value="{{ old('id', isset($report) ? $report->id : '') }}" required>
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">{{ trans('cruds.report.fields.code') }}*</label>
                        <input type="text" id="code" name="code" class="form-control"
                               value="{{ old('code', isset($report) ? $report->code : '') }}" required>
                        @if($errors->has('code'))
                            <em class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.code_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.report.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ old('name', isset($report) ? $report->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.name_helper') }}
                        </p>
                    </div>

                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label for="category_id">{{ trans('cruds.report.fields.category') }}*</label>
                        <select name="category_id" id="category_id" class="form-control select2"
                                required>
                            @foreach($category as $id => $categories)
                                    <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || isset($report) && $report->category->contains($id)) ? 'selected' : '' }}>
                                        {{ $categories }}
                                    </option>
                            @endforeach
                        </select>
                        @if($errors->has('category_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('category_id') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.category_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label for="is_active">{{ trans('cruds.report.fields.is_active') }}</label>
                        <select name="is_active" id="is_active" class="form-control select2" required>
                            <option value="1" name="is_active">Активен</option>
                            <option value="0" name="is_active">Не активен</option>
                        </select>
                        @if($errors->has('is_active'))
                            <em class="invalid-feedback">
                                {{ $errors->first('is_active') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.is_active_helper') }}
                        </p>
                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
                </form>


            </div>
        </div>
        @endcan
    @endcan
@endsection