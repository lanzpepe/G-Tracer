@extends('home')

@section('title', 'Manage Departments')

@section('header')
    <i class="building icon"></i>
    @yield('title')
@endsection

@section('button')
    <button type="button" class="ui right floated teal button add-dept">
        <i class="plus icon"></i>
        {{ __('Add Department') }}
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
            <th>{{ __('Department Name') }}</th>
            <th>{{ __('School') }}</th>
            <th>{{ __('Remove') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($depts as $dept)
            @foreach ($dept->schools as $school)
            <tr class="center aligned">
                <td>{{ $dept->name }}</td>
                <td>{{ $school->name }}</td>
                <td>
                    <button type="button" class="ui compact icon red inverted button mark-dept"
                            data-value='["{{ $dept->name }}", "{{ $school->name }}"]'>
                        <i class="trash icon"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
{{ $depts->links() }}
@endsection

@section('modal')
<div class="ui top aligned tiny modal" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="deptModalLabel" aria-hidden="true">
    <div class="teal header" id="deptModalLabel">
        <i class="question circle outline icon"></i>{{ __('Add New Department') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_dept') }}" class="ui form" id="deptForm" method="POST">
            @csrf
            <div class="required field">
                <label for="school"><i class="school icon"></i>{{ __('School') }}</label>
                <select id="school" name="school" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- Select School --') }}</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->name }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field">
                <label for="department"><i class="building icon"></i>{{ __('Department Name') }}</label>
                <input type="text" class="input-text" name="department" id="department" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="deptForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </div>
    </div>
</div>
<div class="ui tiny basic modal" id="markDeptModal" tabindex="-1" role="dialog" aria-labelledby="markDeptModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markDeptModalLabel">
        <i class="exclamation triangle icon"></i>{{ __('Remove Department') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="department name"></p>
        <p class="school name"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="button" class="ui red submit inverted button delete-dept">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
