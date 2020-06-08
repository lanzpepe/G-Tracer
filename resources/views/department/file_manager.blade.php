@extends('home')

@section('title', 'File Manager')

@section('header')
<i class="ui folder open teal icon"></i> @yield('title')
@endsection

@section('main')
<div class="ui 21:9 embed" data-url="{{ route('unisharp.lfm.show') }}"></div>
@endsection
