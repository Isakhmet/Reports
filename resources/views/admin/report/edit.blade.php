@extends('layouts.admin')
@section('content')
    @can('report_access')

        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.report.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.report.update", [$report->id]) }}" method="POST"
                      enctype="multipart/form-data">

                    @method('PUT')
                    @csrf
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.report.fields.title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title', isset($report) ? $report->title : '') }}" required>
                        @if($errors->has('title'))
                            <em class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.title_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">{{ trans('cruds.report.fields.description') }}*</label>
                        <input type="text" id="description" name="description" class="form-control"
                               value="{{ old('description', isset($report) ? $report->description : '') }}" required>
                        @if($errors->has('description'))
                            <em class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.report.fields.description_helper') }}
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