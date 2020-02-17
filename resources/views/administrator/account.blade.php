@extends('home')

@section('title', 'Manage Accounts')

@section('header')
<i class="ui users teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-account">
    <i class="plus icon"></i> {{ __('Add Account') }}
</button>
@endsection

@section('main')
<div class="ui container">
    <div class="ui equal width centered grid">
        <div class="row">
            <div class="column">
                <table class="ui compact unstackable selectable celled teal table">
                    <thead>
                        <tr class="center aligned">
                            <th>{{ __('Admin Type') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('School') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $adm)
                            @foreach ($adm->departments as $dept)
                                <tr class="center aligned">
                                    <td>{{ $adm->getRoleName() }}</td>
                                    <td>{{ $adm->username }}</td>
                                    <td>{{ $adm->getFullNameAttribute() }}</td>
                                    <td>{{ $dept->name }}</td>
                                    <td>{{ $adm->getSchoolName() }}</td>
                                    <td>
                                        <button class="ui compact icon green inverted button edit-account" data-value="{{ $adm->admin_id }}">
                                            <i class="pen icon"></i>
                                        </button>
                                        <button class="ui compact icon red inverted button mark-account" data-value="{{ $adm->admin_id }}">
                                            <i class="trash icon"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $admins->links('vendor.pagination.semantic-ui') }}
    </div>
</div>
@endsection

@section('modal')
<div class="ui overlay fullscreen modal" id="accountModal" role="dialog" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="header" id="accountModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add New Account') }}</span>
    </div>
    <div class="scrolling content" role="document">
        <form action="{{ route('accounts.store') }}" class="ui form" id="accountForm" method="POST">
            @csrf
            <input type="hidden" name="adminId" id="adminId" value="">
            <div class="required field username">
                <label for="username"><i class="ui user teal icon"></i>{{ __('Username') }}</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required>
            </div>
            <div class="two fields password">
                <div class="required field">
                    <label for="password"><i class="ui key teal icon"></i>{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" value="{{ old('password') }}" required>
                </div>
                <div class="required field">
                    <label for="password-confirm"><i class="ui key teal icon"></i>{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password-confirm" value="{{ old('password-confirm') }}" required>
                </div>
            </div>
            <input type="hidden" name="userId" id="userId" value="">
            <div class="equal width fields">
                <div class="seven wide required field">
                    <label for="lastname"><i class="ui user outline teal icon"></i>{{ __('Last Name') }}</label>
                    <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
                </div>
                <div class="seven wide required field">
                    <label for="firstname"><i class="ui user outline teal icon"></i>{{ __('First Name') }}</label>
                    <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
                </div>
                <div class="two wide required field">
                    <label for="midname"><i class="ui user outline teal icon"></i>{{ __('M.I.') }}</label>
                    <input type="text" name="midname" id="midname" value="{{ old('midname') }}" required>
                </div>
            </div>
            <div class="two fields">
                <div class="required field">
                    <label for="gender"><i class="ui venus mars teal icon"></i>{{ __('Gender') }}</label>
                    <select name="gender" id="gender" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- Select Gender --') }}</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="dob"><i class="ui calendar alternate teal icon"></i>{{ __('Date of Birth') }}</label>
                    <div class="ui calendar" id="birthdate">
                        <div class="ui input">
                            <input type="text" id="dob" name="dob" value="January 1, 1990" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="two fields">
                <div class="required field school">
                    <label for="school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                    <select name="school" id="school" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- Select School --') }}</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->name }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field department">
                    <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                    <select name="dept" id="dept" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- Select Department --') }}</option>
                    </select>
                </div>
            </div>
            <div class="required field">
                <label for="role"><i class="ui user cog teal icon"></i>{{ __('User Permission') }}</label>
                <select name="role" id="role" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- Select Role --') }}</option>
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
                name="btnAccount" value="added">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markAccountModal" tabindex="-1" role="dialog" aria-labelledby="markAccountModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markAccountModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Account') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('accounts.destroy', $adm->admin_id) }}" class="ui form" id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="username holder"></p>
            <p class="name holder"></p>
            <p class="department holder"></p>
            <p class="school holder"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-account" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
