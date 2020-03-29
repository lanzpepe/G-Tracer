@extends('layout.main')

@section('title', 'Welcome to G-Tracer')

@section('content')
<div class="ui large top fixed hidden borderless menu">
    <div class="ui container">
        <div class="header item">
            <img src="{{ asset('img/logo.png') }}" alt="Brand Logo" class="logo">
        </div>
        <div class="right item">
            <button class="ui teal button btn-login" data-target="{{ route('login') }}">
                @if (Route::has('login'))
                    @auth
                        <i class="home icon"></i>
                        <small>{{ __('HOME') }}</small>
                    @else
                        <i class="sign in alternate icon"></i>
                        <small>{{ __('LOG IN') }}</small>
                    @endauth
                @endif
            </button>
        </div>
    </div>
</div>
<div class="ui inverted vertical center aligned masthead segment" style="background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url({{ asset('img/gtracer.jpg') }}); background-size: cover">
    <div class="ui container">
        <div class="ui large secondary inverted menu">
            <div class="header item">
                <img src="{{ asset('img/logo.png') }}" alt="Brand Logo" class="logo">
                <span class="ui teal inverted text">{{ env('APP_NAME') }}</span>
            </div>
            <div class="right item">
                <button class="ui teal inverted button btn-login" data-target="{{ route('login') }}">
                    @if (Route::has('login'))
                        @auth
                            <i class="home icon"></i>
                            <small>{{ __('HOME') }}</small>
                        @else
                            <i class="sign in alternate icon"></i>
                            <small>{{ __('LOG IN') }}</small>
                        @endauth
                    @endif
                </button>
            </div>
        </div>
    </div>
    <div class="ui text container">
        <h1 class="ui inverted header">
            {{ __('G-TRACER') }}
        </h1>
        <h2>{{ __('A Mobile-Web Application for Graduate Tracing using Crowdsourcing and Social Media Listening') }}</h2>
    </div>
</div>
@endsection
