@can ('user_management_access')
    @extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-dark" role="alert">
                    <h4 class="alert-heading text-center">Добро пожаловать, {{ Auth::user()->name }}!</h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-dark" href="{{ route('admin.users.index') }}">
                                <span class="info-box-icon bg-aqua">
                                    <i class="fa fa-users"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Пользователей в системе</span>
                                <span class="info-box-number">{{ $data['countUsers'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-dark" href="{{ route('admin.report.index') }}">
                                <span class="info-box-icon bg-green">
                                    <i class="fa fa-flag-o"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Отчетов в системе</span>
                                <span class="info-box-number">{{ $data['countReports'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-dark" href="{{ route('admin.users.index') }}">
                                <span class="info-box-icon bg-danger">
                                    <i class="fa fa-user-times"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Удаленных пользователей</span>
                                <span class="info-box-number">{{ $data['countDeletedUsers'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-dark" href="{{ route('admin.report.index') }}">
                                <span class="info-box-icon bg-purple">
                                    <i class="fa fa-flag-checkered"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Неактивных отчетов</span>
                                <span class="info-box-number">{{ $data['countDisabledReports'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-dark" href="{{ route('admin.report.index') }}">
                                <span class="info-box-icon bg-info">
                                    <i class="fa fa-user-plus"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Последний добавленный пользователь</span>
                                <span class="info-box-number">{{ $data['lastAddedUser'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
@endcan