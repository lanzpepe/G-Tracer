@extends('home')

@section('title', 'Manage Related Jobs')

@section('header')
    <i class="ui briefcase teal icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-job">
        <i class="plus icon"></i> {{ __('Add Job') }}
    </button>
@endsection

@section('main')
<div class="ui centered grid">
    <div class="row">
        <div class="column">
            <table class="ui compact unstackable structured celled teal table">
                <thead>
                    <tr class="center aligned">
                        <th>{{ __('Course Code') }}</th>
                        <th>{{ __('Course Name') }}</th>
                        <th>{{ __('Related Job') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses->unique('code') as $course)
                        @if ($course->jobs->count() > 0)
                        <tr class="center aligned">
                            <td rowspan="{{ $course->jobs->count() }}">{{ $course->code }}</td>
                            <td rowspan="{{ $course->jobs->count() }}">{{ $course->name }}</td>
                            @foreach ($course->jobs as $job)
                                @if ($loop->first)
                                <td>{{ $job->name }}</td>
                                <td>
                                    <button class="ui compact icon red inverted button mark-job"
                                    data-value="{{ $job->id . '+' . $course->id }}">
                                        <i class="trash icon"></i>
                                    </button>
                                </td>
                                @else
                                <tr class="center aligned">
                                    <td>{{ $job->name }}</td>
                                    <td>
                                        <button class="ui compact icon red inverted button mark-job"
                                        data-value="{{ $job->id . '+' . $course->id }}">
                                            <i class="trash icon"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $jobs->links('vendor.pagination.semantic-ui') }}
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="header" id="jobModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add Related Job') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('jobs.store') }}" class="ui form" id="jobForm" method="POST" role="form">
            @csrf
            <div class="required field job">
                <label for="job"><i class="ui briefcase teal icon"></i>{{ __('Job Name') }}</label>
                <select name="job" id="job" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('Job Name') }}</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->name }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field course">
                <label for="course"><i class="ui book reader teal icon"></i>{{ __('Course') }}</label>
                <div class="ui fluid multiple selection dropdown" id="course">
                    <input type="hidden" name="course">
                    <i class="dropdown icon"></i>
                    <div class="default text">{{ __('-- Select Course(s) --') }}</div>
                    <div class="menu">
                        @foreach ($courses as $course)
                            <div class="item" data-value="{{ $course->name . " - " . $course->major }}">{{ $course->code }}</div>
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
<div class="ui tiny basic modal" id="markJobModal" tabindex="-1" role="dialog" aria-labelledby="markJobModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markJobModalLabel">
        <i class="ui exclamation triangle red icon"></i>{{ __('Remove Job') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="job name"></p>
            <p class="course name"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-job" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
