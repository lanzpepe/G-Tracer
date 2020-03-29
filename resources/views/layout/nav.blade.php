<div class="ui top fixed stackable secondary teal inverted large menu">
    <div class="ui container">
        <div class="item">
            <h3 class="header">{{ __('G-Tracer') }}</h3>
        </div>
        @if ($admin->roles->first()->name == config('constants.roles.admin'))
        <a href="{{ route('admin.index') }}" class="item {{ request()->is('admin') ? 'active' : '' }}">{{ __('Home') }}</a>
        <div class="ui simple dropdown item">
            {{ __('Manage') }} <i class="dropdown icon"></i>
            <div class="menu">
                <div class="item">
                    <i class="users open teal icon"></i> {{ __('Users') }} <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ route('users.index') }}" class="item {{ request()->is('users') ? 'active' : '' }}">{{ __('All Users') }}</a>
                        <a href="{{ route('accounts.index') }}" class="item {{ request()->is('accounts') ? 'active' : '' }}">{{ __('Accounts') }}</a>
                    </div>
                </div>
                <div class="item">
                    <i class="school open teal icon"></i> {{ __('Institutions') }} <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ route('schools.index') }}" class="item {{ request()->is('schools') ? 'active' : '' }}">{{ __('Schools') }}</a>
                        <a href="{{ route('departments.index') }}" class="item {{ request()->is('departments') ? 'active' : '' }}">{{ __('Departments') }}</a>
                    </div>
                </div>
                <a href="{{ route('file_manager') }}" class="item {{ request()->is('file_manager') ? 'active' : '' }}">
                    <i class="folder open teal icon"></i> {{ __('Admin File Manager') }}
                </a>
            </div>
        </div>
        <a href="{{ route('admin.profile') }}" class="item {{ request()->is('admin/profile') ? 'active' : '' }}">{{ __('Profile') }}</a>
        @else
        <a href="{{ route('dept') }}" class="item {{ request()->is('dept') ? 'active' : '' }}">{{ __('Home') }}</a>
        <div class="ui simple dropdown item">
            {{ __('Manage') }} <i class="dropdown icon"></i>
            <div class="menu">
                <a href="{{ route('courses.index') }}" class="teal item {{ request()->is('courses') ? 'active' : '' }}">
                    <i class="book reader teal icon"></i> {{ __('Degree Programs') }}
                </a>
                <div class="item">
                    <i class="user teal icon"></i> {{ __('User Data') }} <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ route('graduates.index') }}" class="item {{ request()->is('graduates') ? 'active' : '' }}">{{ __('Graduates') }}</a>
                        <a href="{{ route('linkedin') }}" class="item {{ request()->is('linkedin') ? 'active' : '' }}">{{ __('LinkedIn') }}</a>
                    </div>
                </div>
                <a href="{{ route('jobs.index') }}" class="teal item {{ request()->is('jobs') ? 'active' : '' }}">
                    <i class="briefcase teal icon"></i> {{ __('Related Jobs') }}
                </a>
                <a href="{{ route('rewards.index') }}" class="teal item {{ request()->is('rewards') ? 'active' : '' }}">
                    <i class="gifts teal icon"></i> {{ __('Points & Rewards') }}
                </a>
                <div class="item">
                    <i class="folder open teal icon"></i> {{ __('Manage Files') }} <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ route('import') }}" class="teal item {{ request()->is('import') ? 'active' : '' }}">{{ __('Import Data') }}</a>
                        <a href="{{ route('file_manager') }}" class="teal item {{ request()->is('file_manager') ? 'active' : '' }}">{{ __('File Manager') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('reports') }}" class="item {{ request()->is('reports') ? 'active' : '' }}">{{ __('Reports') }}</a>
        <a href="{{ route('dept.profile') }}" class="item {{ request()->is('dept/profile') ? 'active' : '' }}">{{ __('Profile') }}</a>
        @endif
        <div class="ui search center item">
            <div class="ui icon input">
                <input type="text" class="prompt" placeholder="Search">
                <i class="search link teal icon"></i>
            </div>
            <div class="results"></div>
        </div>
        @if ($admin->roles->first()->name == config('constants.roles.dept'))
        <div class="right floated item notification">
            <a class="ui compact pointing scrolling top right teal dropdown icon button">
                <i class="bell icon"></i>
                <div class="ui floating circular red mini label notification-count">{{ $count }}</div>
                <div class="menu notifications" style="display: none !important;">
                    <div class="header">{{ __('Notifications') }}</div>
                    <div class="ui divider"></div>
                    <div class="item"></div>
                    <div class="ui divider"></div>
                </div>
            </a>
        </div>
        @endif
        <div class="item">
            <button type="button" class="ui icon inverted button btn-logout">
                <i class="sign out alternate icon"></i>
            </button>
        </div>
    </div>
</div>
