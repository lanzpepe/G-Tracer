<div class="ui container">
    <div class="ui middle aligned grid basic segment">
        <div class="left floated column">
            <span class="ui big text">{{ __('Quick Links') }}</span>
        </div>
    </div>
</div>
<div class="ui container">
    <div class="ui three stackable horizontal centered cards">
        <a href="{{ route('courses.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="book reader teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Degree Programs') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('graduates.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="user graduate teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Graduate List') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('profiles.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="linkedin in teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('LinkedIn Data') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('jobs.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="briefcase teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Course Related Jobs') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('rewards.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="gifts teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Points & Rewards') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('file_manager') }}" class="card">
            <div class="ui large teal icon message">
                <i class="folder open teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('File Manager') }}
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
