@extends('layout.main')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')
<div class="ui inverted vertical masthead center aligned segment" style="background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('../img/bg3.jpg');">
    <div class="ui container">
        <div class="ui large secondary inverted menu">
            <a href="{{ route('index') }}" class="header item">
                <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt="Brand Logo" class="logo">
            </a>
        </div>
    </div>
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <div class="ui message">
                <h2 class="ui green image header">
                    <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt="" class="image">
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
                <button class="ui fluid large green submit button">{{ __('Login') }}</button>
                @error('username')
                    <div class="ui negative message">
                        <ul class="list">
                            <li>{{ $message }}</li>
                        </ul>
                    </div>
                @enderror
            </form>
            <div class="ui message">
                {{ __('Copyright') }} &copy; <span class="year"></span> {{ __('USJ-R CICCT. All rights reserved.') }}
            </div>
        </div>
    </div>
</div>
@endsection
