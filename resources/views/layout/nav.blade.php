<div class="ui top fixed segment borderless unstackable menu">
    <div class="ui container">
        <div class="item">
            <div class="ui teal header">
                {{-- <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt=""> --}}
                {{ __('G-Tracer') }}
            </div>
        </div>
        @if ($admin->roles->first()->name == config('constants.roles.admin'))
        <a href="{{ route('admin.index') }}" class="teal item {{ request()->is('admin') ? 'active' : '' }}">{{ __('Home') }}</a>
        <a class="browse item">{{ __('Manage') }}<i class="dropdown icon"></i></a>
        <div class="ui flowing popup bottom left transition hidden">
            <div class="ui five column divided center aligned grid">
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
                        <a href="#" class="item">{{ __('Reward List') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.profile') }}" class="teal item {{ request()->is('admin/profile') ? 'active' : '' }}">{{ __('Profile') }}</a>
        @else
            <a href="{{ route('dept') }}" class="teal item {{ Request::is('dept') ? 'active' : '' }}">Home</a>
            <div class="ui simple dropdown item">{{ __('Graduates') }}<i class="dropdown icon"></i>
                <div class="menu">
                    <a href="{{ route('graduates') }}" class="teal item {{ Request::is('graduates') ? 'active' : '' }}">Graduate List</a>
                    <a href="{{ route('import') }}" class="teal item {{ Request::is('import') ? 'active' : '' }}">Import Graduates</a>
                </div>
            </div>
            <a href="{{ route('reports') }}" class="teal item {{ Request::is('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('dept_profile') }}" class="teal item {{ Request::is('dept/profile') ? 'active' : '' }}">Profile</a>
        @endif
        <div class="right item">
            <button class="ui teal icon basic button logout" data-target="{{ route('logout') }}">
                <i class="sign out alternate icon"></i>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>
</div>
