@extends('home')

@section('title', 'Manage Courses')

@section('header')
    <i class="book open icon"></i>
    @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-course">
        <i class="plus icon"></i>
        {{ __('Add Course') }}
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
            <th>{{ __('Course Name') }}</th>
            <th>{{ __('Major') }}</th>
            <th>{{ __('Department') }}</th>
            <th>{{ __('School') }}</th>
            <th>{{ __('Manage') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($courses as $course)
            @foreach ($course->departments as $dept)
                @foreach ($dept->schools as $school)
                <tr class="center aligned">
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->major }}</td>
                    <td>{{ $dept->name }}</td>
                    <td>{{ $school->name }}</td>
                    <td>
                        <button type="button" class="ui compact icon green inverted button edit-course"
                            data-value='["{{ $course->name }}", "{{ $course->major }}", "{{ $dept->name }}", "{{ $school->name }}"]'>
                        <i class="pen icon"></i>
                        </button>
                        <button type="button" class="ui compact icon red inverted button remove-course"
                            data-value='["{{ $course->name }}", "{{ $course->major }}", "{{ $dept->name }}", "{{ $school->name }}"]'>
                        <i class="trash icon"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
{{ $courses->links() }}
@endsection

@section('modal')
<div class="ui top aligned tiny modal" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="teal header" id="courseModalLabel">
        <i class="question circle outline icon"></i><span class="title">{{ __('Add New Course') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_course') }}" class="ui form" id="courseForm" method="POST">
            @csrf
            <div class="required field school">
                <label for="school"><i class="school icon"></i>{{ __('School') }}</label>
                <select id="school" name="school" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- SELECT SCHOOL --') }}</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->name }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field department">
                <label for="department"><i class="building icon"></i>{{ __('Department') }}</label>
                <select id="department" name="department" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- SELECT DEPARTMENT --') }}</option>
                </select>
            </div>
            <div class="required field course">
                <label for="course"><i class="book open icon"></i>{{ __('Course Name') }}</label>
                <select name="course" id="course" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('COURSE') }}</option>
                    @foreach ($courses->unique('name') as $course)
                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field major">
                <label for="major"><i class="medal icon"></i>{{ __('Major') }}</label>
                <select name="major" id="major" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('MAJOR') }}</option>
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
                name="btnCourse" value="add">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markCourseModal" tabindex="-1" role="dialog" aria-labelledby="markCourseModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markCourseModalLabel">
        <i class="exclamation triangle icon"></i>{{ __('Remove Course') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="course name"></p>
        <p class="major name"></p>
        <p class="department name"></p>
        <p class="school name"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-course">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
