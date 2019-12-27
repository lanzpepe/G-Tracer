@extends('home')

@section('title', 'Manage Related Jobs')

@section('header')
    <i class="briefcase icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-job">
        <i class="plus icon"></i> {{ __('Add Job') }}
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
            <th>{{ __('Course') }}</th>
            <th>{{ __('Major') }}</th>
            <th>{{ __('Related Job') }}</th>
            <th>{{ __('Remove') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jobs as $job)
            @foreach ($job->courses as $course)
                <tr class="center aligned">
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->major }}</td>
                    <td>{{ $job->name }}</td>
                    <td>
                        <button class="ui compact icon red inverted button mark-job"
                        data-value='["{{ $course->name }}", "{{ $course->major }}", "{{ $job->name }}"]'>
                            <i class="trash icon"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
{{ $jobs->links() }}
@endsection

@section('modal')
<div class="ui top aligned tiny modal" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="teal header" id="jobModalLabel">
        <i class="question circle outline icon"></i><span class="title">{{ __('Add Related Job') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_job') }}" class="ui form" id="jobForm" method="POST">
            @csrf
            <div class="required field job">
                <label for="job"><i class="briefcase icon"></i>{{ __('Job Name') }}</label>
                <select name="job" id="job" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('JOB NAME') }}</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->name }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field course">
                <label for="course"><i class="book open icon"></i>{{ __('Course') }}</label>
                {{-- <select id="course" name="course" class="ui fluid dropdown" multiple required>
                    <option value="" selected>{{ __('-- SELECT COURSE --') }}</option>
                    @foreach ($courses as $course)
                        <option value='["{{ $course->name }}", "{{ $course->major }}"]'>{{ $course->name }} @if ($course->major != 'NONE') {{ " - " . $course->major }} @endif</option>
                    @endforeach
                </select> --}}
                <div class="ui fluid multiple selection dropdown" id="course">
                    <input type="hidden" name="course">
                    <i class="dropdown icon"></i>
                    <div class="default text">-- SELECT COURSE --</div>
                    <div class="menu">
                        @foreach ($courses as $course)
                            <div class="item" data-value="{{ $course->name . " - " . $course->major }}">{{ $course->name }} @if ($course->major != 'NONE') {{ " - " . $course->major }} @endif</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="jobForm">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
{{-- <div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('add_job') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="jobModalLabel">{{ __('ADD JOB') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mt-4">
                        <label for="course"><span class="fa fa-book-open"></span>&emsp;Course</label>
                        <select name="course" class="form-control border border-success rounded" id="course">
                            <option value="" selected>{{ __('-- Select Course --') }}</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->name }} - {{ $course->major }}">{{ $course->major === "NONE" ? $course->name : $course->name . " - " . $course->major }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label for="jobName"><span class="fas fa-suitcase"></span>&emsp;Job</label>
                        <input id="jobName" type="text" class="form-control input-text" name="jobName" required>
                        <div class="dropdown" id="jobList"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-link">Apply</button>
                    <button class="btn btn-danger btn-link" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div> --}}
<div class="modal fade" id="markJobModal" tabindex="-1" role="dialog" aria-labelledby="markJobLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="markJobLabel">{{ __('REMOVE JOB') }}</h5>
            </div>
            <div class="modal-body">
                <h5 class="text-warning">{{ __('The following entries will be removed:') }}</h5>
                <p class="text-warning mx-3 job"></p>
                <p class="text-warning mx-3 course"></p>
                <p class="text-warning mx-3 major"></p>
                <h5 class="text-warning">{{ __('Proceed anyway?') }}</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-link delete-job">{{ __('Remove') }}</button>
                <button class="btn btn-danger btn-link" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
