@extends('layout.main')

@section('title', 'Login')

@section('content')
<div class="ui inverted vertical masthead segment" style="background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url({{ asset('img/gtracer.jpg') }}); background-size: cover">
    <div class="ui container">
        <div class="ui large secondary inverted menu">
            <a href="{{ route('index') }}" class="header item">
                <img src="{{ asset('img/logo.png') }}" alt="Brand Logo" class="logo">
                <span class="ui teal inverted text">{{ env('APP_NAME') }}</span>
            </a>
        </div>
    </div>
    <div class="ui fluid container login">
        <div class="ui center aligned grid">
            <div class="six wide column">
                <div class="ui message">
                    <h2 class="ui teal image header">
                        <img src="{{ asset('img/logo.png') }}" alt="" class="image">
                        <div class="content">{{ __('Administrative Login') }}</div>
                    </h2>
                </div>
                <form action="{{ route('login') }}" class="ui large left aligned form segment" method="POST">
                    @csrf
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Password" required autocomplete="password">
                        </div>
                    </div>
                    <div class="inline field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember" id="remember" tabindex="0" class="hidden">
                            <label for="remember" class="">{{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <input type="hidden" name="token" id="token">
                    <button class="ui fluid large teal submit button">{{ __('Login') }}</button>
                    @error('username')
                        <div class="ui negative message">
                            <ul class="list">
                                <li>{{ $message }}</li>
                            </ul>
                        </div>
                    @enderror
                </form>
                <div class="ui message">
                    {{ __('Copyright') }} &copy; <span class="year"></span> {{ __('G-Tracer Team. All rights reserved.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
