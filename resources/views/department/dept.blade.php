<div class="ui four cards">
    <div class="teal raised card">
        <a href="{{ route('graduates') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui user graduate teal icon"></i>{{ __('Graduate List') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('import') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui file import teal icon"></i>{{ __('Import Graduate') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('reports') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui chart bar outline teal icon"></i>{{ __('Summary Reports') }}
            </div>
        </a>
    </div>
    <div class="teal raised card">
        <a href="{{ route('dept_profile') }}" class="ui placeholder segment">
            <div class="ui icon header">
                <i class="ui user outline teal icon"></i>{{ __('Profile') }}
            </div>
        </a>
    </div>
</div>
