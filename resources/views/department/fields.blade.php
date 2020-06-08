@extends('home')

@section('title', 'Preview Data')

@section('header')
<i class="ui eye teal icon"></i> @yield('title')
@endsection

@section('button')
<button type="submit" class="ui right floated teal submit button" form="uploadForm" role="button">
    <i class="file upload icon"></i> {{ __('Upload Data') }}
</button>
@endsection

@section('main')
<div class="ui container">
    <div class="ui center aligned grid basic segment">
        <div class="column">
            <span class="ui large text">{{ __("List of {$batch} {$year} {$course->code} Graduates") }}</span>
        </div>
    </div>
</div>
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            <table class="ui unstackable selectable celled compact teal table">
                <thead>
                    <tr class="center aligned">
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('First Name') }}</th>
                        <th>{{ __('M.I.') }}</th>
                        <th>{{ __('Gender') }}</th>
                        <th>{{ __('Address') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($csvData as $row)
                    <tr class="center aligned">
                        @foreach ($row as $key => $value)
                        <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <form action="{{ route('g.upload') }}" id="uploadForm" method="POST" role="form">
        @csrf
        <input type="hidden" name="data" value="{{ encrypt($csvFile->id) }}">
        <input type="hidden" name="school" value="{{ $admin->schools->first()->name }}">
        <input type="hidden" name="dept" value="{{ $admin->departments->first()->name }}">
        <input type="hidden" name="course" value="{{ $course->name }}">
        <input type="hidden" name="major" value="{{ $course->major }}">
        <input type="hidden" name="sy" value="{{ $year }}">
        <input type="hidden" name="batch" value="{{ $batch }}">
    </form>
</div>
@endsection
