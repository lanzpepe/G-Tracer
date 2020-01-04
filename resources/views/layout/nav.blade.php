<div class="ui top fixed segment borderless menu">
    <div class="ui unstackable container">
        <div class="item">
            {{-- <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt=""> --}}
            <div class="ui teal header">{{ __('G-Tracer') }}</div>
        </div>
        @if ($admin->roles->first()->name == config('constants.roles.admin'))
            <a href="{{ route('admin.index') }}" class="teal item {{ request()->is('admin') ? 'active' : '' }}">Home</a>
            <a href="{{ route('accounts.index') }}" class="teal item {{ request()->is('accounts') ? 'active' : '' }}">Accounts</a>
            <div class="ui simple dropdown teal item">{{ __('Institutions') }}<i class="dropdown icon"></i>
                <div class="menu">
                    <a href="{{ route('schools.index') }}" class="item {{ request()->is('schools') ? 'active' : '' }}">Schools</a>
                    <a href="{{ route('departments.index') }}" class="item {{ request()->is('departments') ? 'active' : '' }}">Departments</a>
                </div>
            </div>
            <div class="ui simple dropdown item">{{ __('Academics') }}<i class="dropdown icon"></i>
                <div class="menu">
                    <a href="{{ route('courses.index') }}" class="teal item {{ Request::is('courses') ? 'active' : '' }}">Courses</a>
                    <a href="{{ route('school_years.index') }}" class="item {{ Request::is('school_years') ? 'active' : '' }}">School Years</a>
                </div>
            </div>
            <a href="{{ route('jobs.index') }}" class="teal item {{ Request::is('jobs') ? 'active' : '' }}">Related Jobs</a>
            <a href="#" class="teal item">Set Rewards</a>
            <a href="{{ route('admin.profile') }}" class="teal item {{ Request::is('admin/profile') ? 'active' : '' }}">Profile</a>
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
