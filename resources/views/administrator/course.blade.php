@extends('home')

@section('title', 'Manage Courses')

@section('header')
<i class="ui book reader teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-course">
    <i class="plus icon"></i> {{ __('Add Course') }}
</button>
@endsection

@section('main')
<div class="ui centered grid">
    <div class="row">
        <div class="column">
            <table class="ui compact unstackable selectable celled teal table">
                <thead>
                    <tr class="center aligned">
                        <th>{{ __('Course Code') }}</th>
                        <th>{{ __('Course Name') }}</th>
                        <th>{{ __('Major') }}</th>
                        <th>{{ __('Department') }}</th>
                        <th>{{ __('School') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @foreach ($course->departments as $dept)
                            @foreach ($dept->schools as $school)
                            <tr class="center aligned">
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->major }}</td>
                                <td>{{ $dept->name }}</td>
                                <td>{{ $school->name }}</td>
                                <td>
                                    <button type="button" class="ui compact icon green inverted button edit-course"
                                        data-value="{{ $course->id . '+' . $dept->id . '+' . $school->id }}">
                                    <i class="pen icon"></i>
                                    </button>
                                    <button type="button" class="ui compact icon red inverted button mark-course"
                                        data-value="{{ $course->id . '+' . $dept->id . '+' . $school->id }}">
                                    <i class="trash icon"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $courses->links('vendor.pagination.semantic-ui') }}
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="header" id="courseModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add New Course') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('courses.store') }}" class="ui form" id="courseForm" method="POST" role="form">
            @csrf
            <div class="required field school">
                <label for="school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                <select id="school" name="school" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- Select School --') }}</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->name }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field dept">
                <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                <select id="dept" name="dept" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- Select Department --') }}</option>
                </select>
            </div>
            <div class="required field code">
                <label for="code"><i class="ui book reader teal icon"></i>{{ __('Course Code') }}</label>
                <select name="code" id="code" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('Code') }}</option>
                    @foreach ($courses->unique('code') as $course)
                        <option value="{{ $course->code }}">{{ $course->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field course">
                <label for="course"><i class="ui book reader teal icon"></i>{{ __('Course Name') }}</label>
                <select name="course" id="course" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('Course') }}</option>
                    @foreach ($courses->unique('name') as $course)
                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field major">
                <label for="major"><i class="ui medal teal icon"></i>{{ __('Major') }}</label>
                <select name="major" id="major" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('Major') }}</option>
                    @foreach ($courses->unique('major') as $course)
                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="courseForm" id="btnCourse"
                name="btnCourse" value="added">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markCourseModal" tabindex="-1" role="dialog" aria-labelledby="markCourseModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markCourseModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Course') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="course code"></p>
            <p class="course name"></p>
            <p class="major name"></p>
            <p class="department name"></p>
            <p class="school name"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-course" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
