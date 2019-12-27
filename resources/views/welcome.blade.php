@extends('layout.main')

@section('title')
    {{ __('Welcome to G-Tracer') }}
@endsection

@section('content')
<div class="ui large top fixed hidden borderless menu">
    <div class="ui container">
        <div class="header item">
            <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt="Brand Logo" class="logo">
        </div>
        <div class="right item">
            <button class="ui yellow button btn-login" data-target="{{ route('login') }}">
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
<div class="ui inverted vertical masthead center aligned segment" style="background-image: url('{{ asset('img/bg3.jpg') }}')">
    <div class="ui container">
        <div class="ui large secondary inverted menu">
            <div class="header item">
                <img src="https://fomantic-ui.com/examples/assets/images/logo.png" alt="Brand Logo" class="logo">
            </div>
            <div class="right item">
                <button class="ui yellow button btn-login" data-target="{{ route('login') }}">
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
            {{ __('Graduate Tracer System') }}
        </h1>
        <h2>A Web and Mobile Application using Crowdsourcing and Social Media Listening</h2>
    </div>
</div>
<div class="ui vertical stripe segment">
    <div class="ui middle aligned stackable grid container">
        <div class="row">
            <div class="eight wide column">
                <h3 class="ui header">
                    What does it means to you?
                </h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo, odit? Neque, consequuntur! Placeat, facere vitae! Aut quaerat veritatis nemo quo repudiandae aspernatur accusamus soluta odio, modi nihil totam. Distinctio, delectus!</p>
                <h3 class="ui header">
                    What does it means to you?
                </h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus, maxime. Exercitationem iste repellendus cumque voluptates, quidem neque, commodi aliquam impedit porro fuga earum et tempora, dolorum amet corporis sunt magnam.</p>
            </div>
            <div class="six wide right floated column">
                <img src="{{ asset('img/default_avatar_m.png') }}" alt="" class="ui large bordered rounded image">
            </div>
        </div>
    </div>
</div>
@endsection
