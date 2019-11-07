@extends('layouts.admin')
@section('content')
    @can('category_access')

        <div class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.category.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.category.update", [$category->id]) }}" method="POST"
                      enctype="multipart/form-data">

                    @method('PUT')
                    @csrf
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                        <label for="code">{{ trans('cruds.category.fields.code') }}*</label>
                        <input type="text" id="code" name="code" class="form-control"
                               value="{{ old('code', isset($category) ? $category->code : '') }}" required>
                        @if($errors->has('code'))
                            <em class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.category.fields.code_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.category.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ old('name', isset($category) ? $category->name : '') }}" required>
                        @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.category.fields.name_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                        <label for="is_active">{{ trans('cruds.category.fields.is_active') }}</label>
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
                            {{ trans('cruds.category.fields.is_active_helper') }}
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