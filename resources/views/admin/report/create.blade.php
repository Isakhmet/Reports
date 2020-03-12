@extends('layouts.admin')
@section('content')
    @can('user_access')
        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.report.title_singular_one') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.report.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
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
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                        <label for="category_id">{{ trans('cruds.report.fields.category') }}*</label>
                        <select name="category_id" id="category_id" class="form-control select2"
                                required>
                            <option selected></option>
                        @foreach($categories as $id => $category)
                                <option value="{{ $id }}">
                                    {{ $category }}
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
@endsection