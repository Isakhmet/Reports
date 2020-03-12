<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a href="/" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.redirect_to_site') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.home_admin") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-universal-access ">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}"
                                   class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}"
                                   class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}"
                                   class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-bar-chart nav-icon">

                        </i>
                        {{ trans('cruds.reportManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('report_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.report.index") }}"
                                   class="nav-link {{ request()->is('admin/report') || request()->is('admin/report/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-bar-chart nav-icon">

                                    </i>
                                    {{ trans('cruds.report.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('category_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.category.index") }}"
                                   class="nav-link {{ request()->is('admin/category') || request()->is('admin/category/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-life-ring nav-icon">

                                    </i>
                                    {{ trans('cruds.category.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>