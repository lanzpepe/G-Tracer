<div class="ui container">
    <div class="ui middle aligned grid basic segment">
        <div class="left floated column">
            <span class="ui big text">{{ __('Quick Links') }}</span>
        </div>
    </div>
</div>
<div class="ui grid container">
    <div class="three column row">
        <div class="column">
            <a href="{{ route('courses.index') }}" class="ui horizontal card">
                <div class="ui large teal icon message">
                    <i class="book reader teal icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Degree Programs') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href="{{ route('graduates.index') }}" class="ui horizontal card">
                <div class="ui large teal icon message">
                    <i class="user graduate teal icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Graduate List') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href="{{ route('import') }}" class="ui horizontal card">
                <div class="ui large teal icon message">
                    <i class="file import teal icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Import Data') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="three column row">
        <div class="column">
            <a href="{{ route('jobs.index') }}" class="ui horizontal card">
                <div class="ui large teal icon message">
                    <i class="briefcase teal icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Related Jobs') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href="{{ route('rewards.index') }}" class="ui horizontal card">
                <div class="ui large teal icon message">
                    <i class="gifts teal icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ __('Points & Rewards') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href="{{ route('file_manager') }}" class="ui horizontal card">
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
</div>
