@extends('home')

@section('title', 'Manage Users')

@section('header')
<i class="ui users teal icon"></i> @yield('title')
@endsection

@section('main')
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            <table class="ui compact unstackable selectable celled teal table">
                <thead>
                    <tr class="center aligned">
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('First Name') }}</th>
                        <th>{{ __('Middle Name') }}</th>
                        <th>{{ __('Gender') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="center aligned">
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->middle_name }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>
                            <button class="ui compact icon green inverted button view-account" data-value="{{ $user->user_id }}">
                                <i class="eye icon"></i>
                            </button>
                            <button class="ui compact icon red inverted button mark-account" data-value="{{ $user->user_id }}">
                                <i class="trash icon"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $users->links('vendor.pagination.semantic-ui') }}
</div>
@endsection

