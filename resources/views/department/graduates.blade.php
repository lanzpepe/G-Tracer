@extends('home')

@section('title', 'Graduate List')

@section('header')
<i class="ui user graduate teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-graduate">
    <i class="plus icon"></i> {{ __('Add Graduate') }}
</button>
@endsection

@section('main')
<div class="ui container">
    <div class="ui equal width centered grid">
        <div class="row">
            <div class="column">
                @if (count($graduates) > 0)
                <table class="ui unstackable selectable compact teal table">
                    <thead>
                        <tr class="center aligned">
                            <th></th>
                            <th>{{ __('Name of Graduate') }}</th>
                            <th>{{ __('Degree') }}</th>
                            <th>{{ __('Batch / School Year') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($graduates as $graduate)
                            <tr class="center aligned">
                                <td><img class="ui middle aligned tiny circular image" src="{{ $graduate->image() }}"></td>
                                <td><a href="{{ route('report', ['id' => $graduate->graduate_id]) }}">{{ $graduate->getFullNameAttribute() }}</a></td>
                                <td>{{ $graduate->degree }}</td>
                                <td>{{ $graduate->school_year }} / {{ $graduate->batch }}</td>
                                <td class="center aligned">
                                    <div class="center">
                                        <div class="ui compact icon green inverted button edit-graduate" data-value="{{ $graduate->graduate_id }}">
                                            <i class="pen icon"></i>
                                        </div>
                                        <div class="ui compact icon red inverted button mark-graduate" data-value="{{ $graduate->graduate_id }}">
                                            <i class="trash icon"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $graduates->links('vendor.pagination.semantic-ui') }}
        @else
        <div class="row">
            <div class="column">
                <div class="ui placeholder segment">
                    <div class="ui icon header">
                        <i class="frown outline teal icon"></i>
                        {{ __('No graduates displayed.') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('modal')
<div class="ui overlay fullscreen modal" id="graduateModal" tabindex="-1" role="dialog" aria-labelledby="graduateModalLabel" aria-hidden="true">
    <div class="header" id="graduateModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add Graduate') }}</span>
    </div>
    <div class="scrolling content" role="document">
        <form action="{{ route('graduates.store') }}" class="ui form" id="graduateForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="ui grid container">
                <div class="row">
                <div class="six wide column">
                <div class="ui special cards">
                    <div class="card">
                    <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                        <div class="center">
                        <button type="button" class="ui teal inverted button">
                            <label for="image">{{ __('Upload Image') }}</label>
                            <input type="file" name="image" id="image" accept="image/*">
                        </button>
                        </div>
                        </div>
                    </div>
                    <img src="{{ asset('storage/defaults/default_avatar_m.png') }}" alt="Preview Image" id="preview">
                    </div>
                </div>
                </div>
                </div>
                    <div class="ten wide column">
                        <div class="equal width fields">
                            <div class="required field sy">
                                <label for="sy"><i class="ui calendar check outline teal icon"></i>{{ __('School Year') }}</label>
                                <select name="sy" id="sy" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select School Year --') }}</option>
                                    @foreach ($schoolYears as $year)
                                        <option value="{{ $year->school_year }}">{{ $year->school_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="required field batch">
                                <label for="batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                                <select name="batch" id="batch" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Batch --') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="five wide required field">
                                <label for="lastname"><i class="ui user outline teal icon"></i>Last Name</label>
                                <input type="text" name="lastname" id="lastname" value="" required>
                            </div>
                            <div class="five wide required field">
                                <label for="firstname"><i class="ui user outline teal icon"></i>First Name</label>
                                <input type="text" name="firstname" id="firstname" value="" required>
                            </div>
                            <div class="two wide field">
                                <label for="midname"><i class="ui user outline teal icon"></i>M.I.</label>
                                <input type="text" name="midname" id="midname" value="">
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="four wide required field">
                                <label for="gender"><i class="ui venus mars teal icon"></i>Gender</label>
                                <select name="gender" id="gender" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Gender --') }}</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="course"><i class="ui book reader teal icon"></i>{{ __('Degree') }}</label>
                                <select name="course" id="course" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Course --') }}</option>
                                    @foreach ($courses->unique('name') as $course)
                                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="field">
                                <label for="major"><i class="ui award teal icon"></i>{{ __('Major') }}</label>
                                <select name="major" id="major" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Major --') }}</option>
                                    @foreach ($courses->unique('major') as $course)
                                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="school"><i class="ui school teal icon"></i>School</label>
                                <select name="school" id="school" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->schools->first()->name }}">{{ $admin->schools->first()->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                                <select name="dept" id="dept" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->departments->first()->name }}">{{ $admin->departments->first()->name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="graduateForm" id="btnGraduate"
                name="btnGraduate" value="added">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markGraduateModal" tabindex="-1" role="dialog" aria-labelledby="markGraduateModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markGraduateModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Graduate') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="graduate name"></p>
            <p class="graduate course"></p>
            <p class="graduate school"></p>
            <p class="graduate sy"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-graduate" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
