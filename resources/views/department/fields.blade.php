@extends('department.import')

@section('button')
<button type="submit" class="ui right floated teal submit button" form="uploadForm">
    <i class="file upload icon"></i> {{ __('Upload Data') }}
</button>
@endsection

@section('field_list')
<table class="ui unstackable selectable celled teal table">
    <thead>
        <tr class="center aligned">
            <th>{{ __('Last Name') }}</th>
            <th>{{ __('First Name') }}</th>
            <th>{{ __('M.I') }}</th>
            <th>{{ __('Gender') }}</th>
            <th>{{ __('Degree') }}</th>
            <th>{{ __('Major') }}</th>
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
            <input type="hidden" name="sy" value="{{ $schoolYear }}">
            <input type="hidden" name="batch" value="{{ $batch }}">
        </form>
    </tbody>
</table>
@endsection
