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
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            <table class="ui unstackable selectable collapsing compact teal table" style="display:block; overflow-x:auto">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Full Name') }}</th>
                        <th>{{ __('Profile') }}</th>
                        <th>{{ __('First Name') }}</th>
                        <th>{{ __('Last Name') }}</th>
                        <th>{{ __('Avatar') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Position') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($csvData as $row)
                    <tr>
                        @foreach ($row as $key => $value)
                        <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <form action="{{ route('in.upload') }}" id="uploadForm" method="POST" role="form">
        @csrf
        <input type="hidden" name="data" value="{{ encrypt($csvFile->id) }}">
    </form>
</div>
@endsection
