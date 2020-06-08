<div class="ui container">
    <div class="ui middle aligned grid basic segment">
        <div class="left floated column">
            <span class="ui big text">{{ __('Quick Links') }}</span>
        </div>
    </div>
</div>
<div class="ui container">
    <div class="ui three stackable horizontal centered cards">
        <a href="{{ route('users.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="users teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Users') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('accounts.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="users cog teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Accounts') }}
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
        <a href="{{ route('schools.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="school teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Schools') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('departments.index') }}" class="card">
            <div class="ui large teal icon message">
                <i class="building teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('Departments') }}
                    </div>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.profile') }}" class="card">
            <div class="ui large teal icon message">
                <i class="user outline teal icon"></i>
                <div class="content">
                    <div class="header">
                        {{ __('User Profile') }}
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
