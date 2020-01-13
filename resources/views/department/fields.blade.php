@extends('department.import')

@section('title', 'Preview List')

@section('header')
<i class="ui eye teal icon"></i> @yield('title')
@endsection

@section('button')
<button type="submit" class="ui right floated teal submit button" form="uploadForm">
    <i class="file upload icon"></i> {{ __('Upload Data') }}
</button>
@endsection

@section('field_list')
<h3 class="ui top attached center aligned header">
    {{ __("Graduate List for {$batch} {$schoolYear} ({$course})") }}
</h3>
<table class="ui unstackable selectable celled compact teal table">
    <thead>
        <tr class="center aligned">
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('M.I') }}</th>
            <th>{{ __('Gender') }}</th>
        </tr>
    </thead>
    <tbody>
        <form action="{{ route('import_process') }}" class="ui form" method="POST" id="uploadForm">
            @csrf
            @foreach ($csvData as $row)
                <tr class="center aligned">
                    @foreach ($row as $key => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
            <input type="hidden" name="data" value="{{ encrypt($csvFile->id) }}">
            <input type="hidden" name="school" value="{{ $admin->schools->first()->name }}">
            <input type="hidden" name="dept" value="{{ $admin->departments->first()->name }}">
            <input type="hidden" name="course" value="{{ $course }}">
            <input type="hidden" name="major" value="{{ $major }}">
            <input type="hidden" name="sy" value="{{ $schoolYear }}">
            <input type="hidden" name="batch" value="{{ $batch }}">
        </form>
    </tbody>
</table>
@endsection
