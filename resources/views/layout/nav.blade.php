<div class="ui top fixed borderless unstackable large teal inverted menu">
    <div class="ui container">
        <div class="item">
            <h3 class="header">{{ __('G-Tracer') }}</h3>
        </div>
        @if ($admin->roles->first()->name == config('constants.roles.admin'))
        <a href="{{ route('admin.index') }}" class="item {{ request()->is('admin') ? 'active' : '' }}">{{ __('Home') }}</a>
        <a class="browse item">{{ __('Manage') }}<i class="dropdown icon"></i></a>
        <div class="ui flowing popup bottom left transition hidden">
            <div class="ui five column relaxed divided center aligned grid">
                <div class="column">
                    <h4 class="ui header">{{ __('Account') }}</h4>
                    <div class="ui link list">
                        <a href="{{ route('accounts.index') }}" class="teal item {{ request()->is('accounts') ? 'active' : '' }}">{{ __('Accounts') }}</a>
                    </div>
                </div>
                <div class="column">
                    <h4 class="ui header">{{ __('Institution') }}</h4>
                    <div class="ui link list">
                        <a href="{{ route('schools.index') }}" class="teal item {{ request()->is('schools') ? 'active' : '' }}">{{ __('Schools') }}</a>
                        <a href="{{ route('departments.index') }}" class="teal item {{ request()->is('departments') ? 'active' : '' }}">{{ __('Departments') }}</a>
                    </div>
                </div>
                <div class="column">
                    <h4 class="ui header">{{ __('Academic') }}</h4>
                    <div class="ui link list">
                        <a href="{{ route('courses.index') }}" class="teal item {{ request()->is('courses') ? 'active' : '' }}">{{ __('Courses') }}</a>
                        <a href="{{ route('school_years.index') }}" class="teal item {{ request()->is('school_years') ? 'active' : '' }}">{{ __('School Years') }}</a>
                    </div>
                </div>
                <div class="column">
                    <h4 class="ui header">{{ __('Course Related') }}</h4>
                    <div class="ui link list">
                        <a href="{{ route('jobs.index') }}" class="teal item {{ request()->is('jobs') ? 'active' : '' }}">{{ __('Jobs') }}</a>
                    </div>
                </div>
                <div class="column">
                    <h4 class="ui header">{{ __('Reward') }}</h4>
                    <div class="ui link list">
                        <a href="#" class="teal item">{{ __('Reward List') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.profile') }}" class="item {{ request()->is('admin/profile') ? 'active' : '' }}">{{ __('Profile') }}</a>
        @else
            <a href="{{ route('dept') }}" class="item {{ request()->is('dept') ? 'active' : '' }}">Home</a>
            <div class="ui simple dropdown item">{{ __('Manage') }}<i class="dropdown icon"></i>
                <div class="menu">
                    <a href="{{ route('graduates') }}" class="item {{ request()->is('graduates') ? 'active' : '' }}">{{ __('Graduate List') }}</a>
                    <a href="{{ route('import') }}" class="item {{ request()->is('import') ? 'active' : '' }}">{{ __('Import Graduates') }}</a>
                    <a href="{{ route('file_manager') }}" class="item {{ request()->is('file_manager') ? 'active' : '' }}">{{ __('File Manager') }}</a>
                </div>
            </div>
            <a href="{{ route('reports') }}" class="item {{ request()->is('reports') ? 'active' : '' }}">{{ __('Statistics') }}</a>
            <a href="{{ route('dept_profile') }}" class="item {{ request()->is('dept/profile') ? 'active' : '' }}">{{ __('Profile') }}</a>
        @endif
        <div class="ui search right item">
            <div class="ui icon input">
                <input type="text" class="prompt" id="search" name="search" placeholder="Search" value="{{ old('search') }}">
                <i class="search teal icon"></i>
            </div>
            <div class="results"></div>
        </div>
        <div class="right item">
            <button class="ui icon inverted button logout">
                <i class="sign out alternate icon"></i>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>
</div>
