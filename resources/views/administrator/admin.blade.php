<div class="ui four cards">
    <div class="teal raised card">
        <a href="{{ route('accounts.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui users teal icon"></i>{{ __('Accounts') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('schools.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui school teal icon"></i>{{ __('Schools') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('departments.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui building teal icon"></i>{{ __('Departments') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('courses.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui book reader teal icon"></i>{{ __('Courses') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('school_years.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui calendar check teal icon"></i>{{ __('School Years') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('jobs.index') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui briefcase teal icon"></i>{{ __('Related Jobs') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="#" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui gifts teal icon"></i>{{ __('Set Rewards') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('admin.profile') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui user outline teal icon"></i>{{ __('Profile') }}
            </div>
        </a>
    </div>
</div>
