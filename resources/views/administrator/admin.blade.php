<div class="ui four doubling cards">
    <a href="{{ route('accounts.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui users teal icon"></i>{{ __('Accounts') }}
            </div>
        </div>
    </a>
    <a href="{{ route('schools.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui school teal icon"></i>{{ __('Schools') }}
            </div>
        </div>
    </a>
    <a href="{{ route('departments.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui building teal icon"></i>{{ __('Departments') }}
            </div>
        </div>
    </a>
    <a href="{{ route('courses.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui book reader teal icon"></i>{{ __('Courses') }}
            </div>
        </div>
    </a>
    <a href="{{ route('school_years.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui calendar check teal icon"></i>{{ __('School Years') }}
            </div>
        </div>
    </a>
    <a href="{{ route('jobs.index') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui briefcase teal icon"></i>{{ __('Related Jobs') }}
            </div>
        </div>
    </a>
    <a href="#" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui gifts teal icon"></i>{{ __('Set Rewards') }}
            </div>
        </div>
    </a>
    <a href="{{ route('admin.profile') }}" class="teal card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui user outline teal icon"></i>{{ __('Profile') }}
            </div>
        </div>
    </a>
</div>
