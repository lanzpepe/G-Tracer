@extends('home')

@section('title', 'User Profile')

@section('header')
    <i class="ui user outline teal icon"></i> @yield('title')
@endsection

@section('main')
<div class="ui center aligned grid container">
    <div class="row">
        <img class="ui circular image profile" src="{{ $user->image() }}" alt="Profile Image">
    </div>
    <div class="row">
        <h2 class="ui center aligned header">
            <div class="content"> {{ $user->getFullNameAttribute() }}
                <div class="sub header">{{ $admin->getDepartmentName() }} &middot; {{ $admin->getSchoolName() }}</div>
            </div>
        </h2>
    </div>
    <div class="row">
        <div class="three wide column">
            <h4 class="ui center aligned grey header">
                <i class="venus mars teal icon"></i>{{ $user->gender }}
            </h4>
        </div>
        <div class="three wide column">
            <h4 class="ui center aligned grey header">
                <i class="calendar alternate teal icon"></i>{{ $user->birth_date }}
            </h4>
        </div>
        <div class="three wide column">
            <h4 class="ui center aligned grey header">
                <i class="user cog teal icon"></i>{{ $admin->getRoleName() }}
            </h4>
        </div>
    </div>
</div>
@endsection
