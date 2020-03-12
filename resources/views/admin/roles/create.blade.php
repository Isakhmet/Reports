@extends('layouts.admin')
@section('content')
    @can('role_access')
        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('cruds.role.title_singular_one') }}
            </div>

            <div class="card-body">
                <form action="{{ route("admin.roles.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        <label for="title">{{ trans('cruds.role.fields.title') }}*</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title', isset($role) ? $role->title : '') }}" required>
                        @if($errors->has('title'))
                            <em class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.role.fields.title_helper') }}
                        </p>
                    </div>
                    <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                        <label for="permissions">{{ trans('cruds.role.fields.permissions') }}
                            <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                        <select name="permissions[]" id="permissions" class="form-control select2" multiple="multiple">
                            @foreach($permissions as $id => $permission)
                                <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions->contains($id)) ? 'selected' : '' }}>
                                    {{ $permission }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('permissions'))
                            <em class="invalid-feedback">
                                {{ $errors->first('permissions') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.role.fields.permissions_helper') }}
                        </p>
                        <label for="badge_role">{{ trans('cruds.role.fields.badge') }}
                            <select name="badge_role" id="badge_role" class="form-control">
                                <option value="badge-info" selected></option>
                                <option value="badge-light">light</option>
                                <option value="badge-danger">danger</option>
                                <option value="badge-dark">dark</option>
                                <option value="badge-info">info</option>
                                <option value="badge-pill ">pill</option>
                                <option value="badge-primary">primary</option>
                                <option value="badge-secondary">secondary</option>
                                <option value="badge-success">success</option>
                                <option value="badge-warning">warning</option>
                            </select>
                        </label>
                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
                </form>


            </div>
        </div>
    @endcan
@endsection