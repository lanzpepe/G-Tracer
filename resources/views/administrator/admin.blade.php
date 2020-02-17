<div class="ui container">
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
        {{-- <a href="{{ route('school_years.index') }}" class="teal card">
            <div class="ui placeholder segment">
                <div class="ui icon header">
                    <i class="ui calendar check teal icon"></i>{{ __('School Years') }}
                </div>
            </div>
        </a> --}}
        <a href="#" class="teal card">
            <div class="ui placeholder segment">
                <div class="ui icon header">
                    <i class="ui gifts teal icon"></i>{{ __('Set Rewards') }}
                </div>
            </div>
        </a>
    </div>
</div>
