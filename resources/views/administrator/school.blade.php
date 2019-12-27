@extends('home')

@section('title', 'Manage Schools')

@section('header')
    <i class="school icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-school">
        <i class="plus icon"></i> {{ __('Add School') }}
    </button>
@endsection

@section('alert')
@if ($errors->any())
    <div class="ui negative message">
        <ul class="list">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@elseif ($message = Session::get('success'))
    <div class="ui positive message">
        <ul class="list">
            <li>{{ $message }}</li>
        </ul>
    </div>
@endif
@endsection

@section('main')
<table class="ui unstackable selectable celled teal table">
    <thead>
        <tr class="center aligned">
            <th>{{ __('School Name') }}</th>
            <th>{{ __('Remove') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($schools as $school)
            <tr class="center aligned">
                <td>{{ $school->name }}</td>
                <td>
                    <button class="ui compact icon red inverted button mark-school" data-value="{{ $school->name }}">
                        <i class="trash icon"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $schools->links() }}
@endsection

@section('modal')
<div class="ui top aligned tiny modal" id="schoolModal" tabindex="-1" role="dialog" aria-labelledby="schoolModalLabel" aria-hidden="true">
    <div class="teal header" id="schoolModalLabel">
        <i class="question circle outline icon"></i>{{ __('Add New School') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_school') }}" class="ui form" id="schoolForm" method="POST">
            @csrf
            <div class="required field">
                <label for="school"><i class="school icon"></i>School Name</label>
                <input type="text" class="input-text" name="school" id="school" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="schoolForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </div>
    </div>
</div>
<div class="ui tiny basic modal" id="markSchoolModal" tabindex="-1" role="dialog" aria-labelledby="markSchoolModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markSchoolModalLabel">
        <i class="exclamation triangle icon"></i>{{ __('Remove School') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="school name"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-school">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
