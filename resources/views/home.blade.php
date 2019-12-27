@extends('layout.main')

@section('title')
    Dashboard
@endsection

@section('header')
    <i class="home icon"></i>
    @yield('title')
@endsection

@section('content')
@include('layout.nav')
<main role="main">
    <div class="ui container">
        <div class="ui raised middle aligned grid container segment">
            <div class="left floated eight wide column">
                <h3 class="ui left floated teal header">
                    @yield('header')
                </h3>
            </div>
            <div class="right floated eight wide column">
                @yield('button')
            </div>
        </div>
        @yield('alert')
        <div class="ui raised middle aligned grid container segment">
            @yield('main')
        </div>
        @yield('modal')
    </div>
</main>
@endsection
