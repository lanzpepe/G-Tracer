@extends('home')

@section('title', 'Import Data')

@section('header')
<i class="ui file import teal icon"></i> @yield('title')
@endsection

@section('main')
@yield('field_list')
@endsection

@section('modal')
<div class="ui modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="header" id="uploadModalLabel">
        <i class="ui question circle outline teal icon"></i>
        {{ __('Import Graduate Data') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('import.g.parse') }}" class="ui form" id="uploadForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="equal width fields">
                <div class="required field">
                    <label for="school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                    <select name="school" id="school" class="ui fluid dropdown" required>
                        <option value="{{ $admin->schools->first()->name }}">{{ $admin->schools->first()->name }}</option>
                    </select>
                </div>
                <div class="required field">
                    <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                    <select name="dept" id="dept" class="ui fluid dropdown" required>
                        <option value="{{ $admin->departments->first()->name }}">{{ $admin->departments->first()->name }}</option>
                    </select>
                </div>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label for="course"><i class="ui book reader teal icon"></i>{{ __('Degree') }}</label>
                    <select name="course" id="course" class="ui fluid dropdown">
                        @foreach ($courses->unique('name') as $course)
                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="major"><i class="ui award teal icon"></i>{{ __('Major') }}</label>
                    <select name="major" id="major" class="ui fluid dropdown">
                        @foreach ($courses->unique('major') as $course)
                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label for="sy"><i class="ui calendar check outline teal icon"></i>{{ __('School Year') }}</label>
                    <select name="sy" id="sy" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- Select School Year --') }}</option>
                        @foreach ($years as $y)
                        <option value="{{ $y->year }}">{{ $y->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                    <select name="batch" id="batch" class="ui fluid dropdown" required>
                        <option value="" selected>{{ __('-- Select Batch --') }}</option>
                        @foreach ($batches as $batch)
                        <option value="{{ $batch->month }}">{{ $batch->month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="required field">
                <label for="file"><i class="ui file outline teal icon"></i>{{ __('Graduate List (.csv)') }}</label>
                <input type="file" accept=".csv" name="file" id="file" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="uploadForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
<div class="ui modal" id="linkedInUploadModal" tabindex="-1" role="dialog" aria-labelledby="linkedInUploadModalLabel" aria-hidden="true">
    <div class="header" id="linkedInUploadModalLabel">
        <i class="ui question circle outline teal icon"></i>
        {{ __('Import LinkedIn Data') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('import.in.parse') }}" class="ui form" id="uploadInForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="required field">
                <label for="file"><i class="ui file outline teal icon"></i>{{ __('LinkedIn Data (.csv)') }}</label>
                <input type="file" accept=".csv" name="file" id="file" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="uploadInForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
@endsection
