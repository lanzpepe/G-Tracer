@extends('home')

@section('title', 'Import Graduates')

@section('header')
    <i class="ui file import teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button import-graduates">
    <i class="file import icon"></i> {{ __('Import Data') }}
</button>
@endsection

@section('main')
@yield('field_list')
@endsection

@section('modal')
<div class="ui modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="ui icon header" id="uploadModalLabel">
        <i class="question circle outline teal icon"></i>{{ __('Import Graduates') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('import_parse') }}" class="ui form" id="uploadForm" method="POST" enctype="multipart/form-data">
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
                    <label for="sy"><i class="ui calendar check outline teal icon"></i>{{ __('School Year') }}</label>
                    <select name="sy" id="sy" class="ui fluid dropdown" required>
                        @foreach ($schoolYears as $sy)
                            <option value="{{ $sy->school_year }}">{{ $sy->school_year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                    <select name="batch" id="batch" class="ui fluid dropdown" required>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
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
        </div>
    </div>
</div>
@endsection
