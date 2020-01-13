@extends('home')

@section('title', 'Graduate Statistics')

@section('header')
<i class="ui chart bar teal icon"></i> @yield('title')
@endsection

@section('main')
<div class="ui equal width centered grid">
    <div class="column">
        {{ $courseChart->container() }}
    </div>
    <div class="column">
        {{ $yearChart->container() }}
    </div>
</div>
@endsection

@section('scripts')
    {{ $courseChart->script() }}
    {{ $yearChart->script() }}
@endsection
