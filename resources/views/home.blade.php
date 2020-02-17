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
        {{-- <div class="ui middle aligned segment"> --}}
        @if (Request::is('import'))
        <div class="ui container">
            <div class="ui placeholder segment">
                <div class="ui icon header">
                    <i class="file import teal icon"></i>
                    {{ __('Click the \'Import Data\' button to display it here.') }}
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
        {{-- </div> --}}
        @yield('modal')
    </div>
</main>
@yield('scripts')
@endsection
