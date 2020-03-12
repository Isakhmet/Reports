@can ('user_management_access')
    @extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading text-center">Добро пожаловать, {{ Auth::user()->name }}!</h4>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-info" href="{{ route('admin.users.index') }}">
                                <span class="info-box-icon bg-aqua" >
                                     <i class="fa fa-users"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text"><h6>Пользователей</h6></span>
                                <span class="info-box-number"><h5>{{ $data['countUsers'] }}</h5></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <a class="bg-info" href="{{ route('admin.report.index') }}">
                                <span class="info-box-icon bg-green">
                                    <i class="fa fa-flag-o"></i>
                                </span>
                            </a>
                            <div class="info-box-content">
                                <span class="info-box-text">Отчетов</span>
                                <span class="info-box-number">{{ $data['countReports'] }}</span>
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