@extends('layout.main')

@section('title', 'Dashboard')

@section('header')
<i class="ui home teal icon"></i> @yield('title')
@endsection

@section('content')
@include('layout.nav')
<main role="main">
    <div class="ui fluid container">
        @if (!Request::is('file_manager'))
        <div class="ui container">
            <div class="ui middle aligned grid segment">
                <div class="left floated eight wide column">
                    <h3 class="ui left floated header">
                        @yield('header')
                    </h3>
                </div>
                <div class="right floated eight wide column">
                    @yield('button')
                </div>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="ui red notify toast">
            <div class="content">
                <div class="ui header">
                    <i class="exclamation circle icon"></i>{{ __('Message') }}
                </div>
                <ul class="list">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="ui green notify toast">
            <div class="content">
                <div class="ui header">
                    <i class="check circle outline icon"></i>{{ __('Message') }}
                </div>
                <ul class="list">
                    <li>{{ $message }}</li>
                </ul>
            </div>
        </div>
        @endif
        @if (Request::is('import'))
        <div class="ui container">
            <div class="ui placeholder segment">
                <div class="ui two column very relaxed stackable center aligned grid">
                    <div class="middle aligned row">
                        <div class="column">
                            <div class="ui icon header">
                                <i class="user graduate teal icon"></i>
                                {{ __('Graduate Data') }}
                            </div>
                            <div class="ui teal button import-graduates">{{ __('Import') }}</div>
                        </div>
                        <div class="column">
                            <div class="ui icon header">
                                <i class="linkedin in teal icon"></i>
                                {{ __('LinkedIn Data') }}
                            </div>
                            <div class="ui teal button import-linkedin">{{ __('Import') }}</div>
                        </div>
                        <div class="ui vertical divider">{{ __('OR') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @elseif (Request::is('dept'))
            @include('department.dept')
        @elseif (Request::is('admin'))
            @include('administrator.admin')
        @else
            @yield('main')
        @endif
        @yield('modal')
    </div>
</main>
@yield('scripts')
<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.1/firebase-messaging.js"></script>
<script src="{{ asset('js/init.js') }}"></script>
<script src="{{ asset('js/firebase.js') }}"></script>
@endsection
