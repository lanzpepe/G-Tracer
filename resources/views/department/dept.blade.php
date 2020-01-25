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
    <a href="{{ route('file_manager') }}" class="teal raised card">
        <div class="ui placeholder segment">
            <div class="ui icon header">
                <i class="folder open teal icon"></i>{{ __('File Manager') }}
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
</div>
