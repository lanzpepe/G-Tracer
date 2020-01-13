<div class="ui four doubling cards">
    <a href="{{ route('graduates') }}" class="teal raised card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="user graduate teal icon"></i>{{ __('Graduate List') }}
            </div>
        </div>
    </a>
    <a href="{{ route('import') }}" class="teal raised card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="file import teal icon"></i>{{ __('Import Graduate') }}
            </div>
        </div>
    </a>
    <a href="{{ route('reports') }}" class="teal raised card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="chart bar outline teal icon"></i>{{ __('Statistics') }}
            </div>
        </div>
    </a>
    <a href="{{ route('dept_profile') }}" class="teal raised card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="user outline teal icon"></i>{{ __('Profile') }}
            </div>
        </div>
    </a>
</div>
