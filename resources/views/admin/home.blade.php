@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading text-center">Добро пожаловать, {{ Auth::user()->name }}!</h4>
                </div>
                @can ('user_management_access')
                    <a type="button" class="btn btn-danger btn-lg btn-block" href="{{ route('admin.users.index') }}">Управление
                        пользователями</a>
                    <a type="button" class="btn btn-success btn-lg btn-block" href="{{ route('admin.roles.index') }}">Управление
                        ролями</a>
                    <a type="button" class="btn btn-primary btn-lg btn-block"
                       href="{{ route('admin.permissions.index') }}">Управление доступами</a>
                @endcan
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent

@endsection