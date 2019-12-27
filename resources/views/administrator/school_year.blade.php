@extends('home')

@section('title', 'Manage School Years')

@section('header')
    <i class="calendar alternate icon"></i>
    @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-sy">
        <i class="plus icon"></i>
        {{ __('Add School Year') }}
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
            <th>{{ __('School Year') }}</th>
            <th>{{ __('Remove') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($years as $year)
            <tr class="center aligned">
                <td>{{ $year->school_year }}</td>
                <td>
                    <button class="ui compact icon red inverted button mark-sy" data-value="{{ $year->school_year }}">
                        <i class="trash icon"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $years->links() }}
@endsection

@section('modal')
<div class="ui top aligned tiny modal" id="schoolYearModal" tabindex="-1" role="dialog" aria-labelledby="schoolYearModalLabel" aria-hidden="true">
    <div class="header" id="schoolYearModalLabel">
        <i class="question circle outline icon"></i>{{ __('Add New School Year') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_sy') }}" class="ui form" id="schoolYearForm" method="POST">
            @csrf
            <div class="required field">
                <label for="sy"><i class="school icon"></i>School Year</label>
                <input type="text" class="input-text" name="sy" id="sy" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="schoolYearForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </div>
    </div>
</div>
<div class="ui tiny basic modal" id="markSyModal" tabindex="-1" role="dialog" aria-labelledby="markSyModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markSyModalLabel">
        <i class="exclamation triangle icon"></i>{{ __('Remove School Year') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="sy name"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-sy">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
