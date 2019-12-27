@extends('home')

@section('title', 'Manage Accounts')

@section('header')
    <i class="users icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-account">
        <i class="plus icon"></i> {{ __('Add Account') }}
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
            <th>{{ __('Username') }}</th>
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('M.I.') }}</th>
            <th>{{ __('School') }}</th>
            <th>{{ __('Department') }}</th>
            <th>{{ __('Manage') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $adm)
            @foreach ($adm->departments as $dept)
                <tr class="center aligned">
                    <td>{{ $adm->username }}</td>
                    <td>{{ $adm->user->last_name }}</td>
                    <td>{{ $adm->user->first_name }}</td>
                    <td>{{ $adm->user->middle_name }}</td>
                    <td>{{ $adm->schools()->first()->name }}</td>
                    <td>{{ $dept->name }}</td>
                    <td>
                        <button class="ui compact icon green inverted button edit-account" data-value="{{ $adm->username }}">
                            <i class="pen icon"></i>
                        </button>
                        <button class="ui compact icon red inverted button mark-account" data-value="{{ $adm->username }}">
                            <i class="trash icon"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
{{ $admins->links() }}
@endsection

@section('modal')
<div class="ui top aligned longer modal" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="header" id="accountModalLabel">
        <i class="question circle outline icon"></i><span class="title">{{ __('Add Account') }}</span>
    </div>
    <div class="scrolling content" role="document">
        <form action="{{ route('add_account') }}" class="ui form" id="accountForm" method="POST">
            @csrf
            <input type="hidden" name="adminId" id="adminId" value="">
            <div class="required field username">
                <label for="username"><i class="user outline icon"></i>Username</label>
                <input type="text" name="username" id="username" value="" required>
            </div>
            <div class="two fields password">
                <div class="required field">
                    <label for="password"><i class="key icon"></i>Password</label>
                    <input type="password" name="password" id="password" value="" required>
                </div>
                <div class="required field">
                    <label for="password-confirm"><i class="key icon"></i>Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password-confirm" value="" required>
                </div>
            </div>
            <input type="hidden" name="userId" id="userId" value="">
            <div class="fields">
                <div class="seven wide required field">
                    <label for="lastname"><i class="user icon"></i>Last Name</label>
                    <input type="text" class="input-text" name="lastname" id="lastname" value="" required>
                </div>
                <div class="seven wide required field">
                    <label for="firstname"><i class="user icon"></i>First Name</label>
                    <input type="text" class="input-text" name="firstname" id="firstname" value="" required>
                </div>
                <div class="two wide required field">
                    <label for="midname"><i class="user icon"></i>M.I.</label>
                    <input type="text" class="input-text" name="midname" id="midname" value="" required>
                </div>
            </div>
            <div class="two fields">
                <div class="required field">
                    <label for="gender"><i class="venus mars icon"></i>Gender</label>
                    <select name="gender" id="gender" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- SELECT GENDER --') }}</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="dob"><i class="calendar icon"></i>Date of Birth</label>
                    <div class="ui calendar" id="birthdate">
                        <div class="ui input">
                            <input type="text" id="dob" name="dob" value="01/01/1990" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="two fields">
                <div class="required field school">
                    <label for="school"><i class="school icon"></i>School</label>
                    <select name="school" id="school" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- SELECT SCHOOL --') }}</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->name }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field department">
                    <label for="department"><i class="building icon"></i>Department</label>
                    <select name="department" id="department" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- SELECT DEPARTMENT --') }}</option>
                    </select>
                </div>
            </div>
            <div class="required field">
                <label for="role"><i class="user cog icon"></i>User Permission</label>
                <select name="role" id="role" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- SELECT ROLE --') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="accountForm" id="btnAccount"
                name="btnAccount" value="add">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markAccountModal" tabindex="-1" role="dialog" aria-labelledby="markAccountModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markAccountModalLabel">
        <i class="exclamation triangle icon"></i>{{ __('Remove Account') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="username holder"></p>
        <p class="name holder"></p>
        <p class="department holder"></p>
        <p class="school holder"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-account">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
