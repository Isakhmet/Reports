@extends('layouts.admin')
@section('content')
    @can('permission_access')

        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.permission.title_singular_one_edit') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.permission.fields.title') }}</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title', isset($permission) ? $permission->title : '') }}">
                        <p class="helper-block">
                            {{ trans('cruds.permission.fields.title_helper') }}
                        </p>
                        <label for="code">{{ trans('cruds.permission.fields.code') }}*</label>
                        <input type="text" id="code" name="code" class="form-control"
                               value="{{ old('code', isset($permission) ? $permission->code : '') }}" required>
                        @if($errors->has('code'))
                            <em class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.permission.fields.title_helper') }}
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