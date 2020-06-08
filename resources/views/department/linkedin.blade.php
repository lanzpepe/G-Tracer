@extends('home')

@section('title', 'LinkedIn Data')

@section('header')
<i class="linkedin in teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button import-linkedin">
    <i class="file import import icon"></i> {{ __('Import LinkedIn Data') }}
</button>
@endsection

@section('main')
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            @if (count($profiles) > 0)
            <table class="ui unstackable selectable compact teal table" id="linkedin" style="display:block; overflow-x:auto">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Full Name') }}</th>
                        <th>{{ __('Profile') }}</th>
                        <th>{{ __('First Name') }}</th>
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('Avatar') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Position') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                    <tr>
                        <td>{{ $profile->id }}</td>
                        <td>{{ $profile->full_name }}</td>
                        <td>{{ $profile->profile_url }}</td>
                        <td>{{ $profile->first_name }}</td>
                        <td>{{ $profile->last_name }}</td>
                        <td>{{ $profile->avatar }}</td>
                        <td>{{ $profile->title }}</td>
                        <td>{{ $profile->company }}</td>
                        <td>{{ $profile->position }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="ui placeholder basic segment">
                <div class="ui icon header">
                    <i class="grin beam sweat outline teal icon"></i>
                    {{ __('LinkedIn data is empty.') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('modal')
@include('layout.modal.profile.import')
@endsection
