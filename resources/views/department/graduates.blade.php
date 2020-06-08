@extends('home')

@section('title', 'Graduate List')

@section('header')
<i class="ui user graduate teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button import-graduates">
    <i class="file import icon"></i> {{ __('Import List') }}
</button>
<button class="ui right floated teal button add-graduate">
    <i class="plus icon"></i> {{ __('Add Graduate') }}
</button>
@endsection

@section('main')
<div class="ui equal width centered grid container">
    @if (count($graduates) > 0)
    <div class="row">
        <div class="column">
            <table id="graduates" class="ui unstackable selectable compact teal table">
                <thead>
                    <tr class="center aligned" role="row">
                        <th></th>
                        <th>{{ __('Name of Graduate') }}</th>
                        <th>{{ __('Degree') }}</th>
                        <th>{{ __('Graduated') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($graduates as $graduate)
                        <tr class="center aligned">
                            <td><img class="ui middle aligned tiny circular image" src="{{ $graduate->image }}"></td>
                            <td><a href="{{ route('report', ['id' => $graduate->graduate_id]) }}">{{ $graduate->full_name }}</a></td>
                            <td>{{ $graduate->academic->degree }}</td>
                            <td>{{ "{$graduate->academic->batch} {$graduate->academic->year}" }}</td>
                            <td class="center aligned">
                                <div class="center">
                                    <div class="ui compact icon green inverted button edit-graduate" data-value="{{ $graduate->graduate_id }}">
                                        <i class="pen icon"></i>
                                    </div>
                                    <div class="ui compact icon red inverted button mark-graduate" data-value="{{ $graduate->graduate_id }}">
                                        <i class="trash icon"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $graduates->links('vendor.pagination.semantic-ui') }}
    @else
    <div class="ui placeholder basic segment">
        <div class="ui icon header">
            <i class="grin beam sweat outline teal icon"></i>
            {{ __('No graduates displayed.') }}
        </div>
    </div>
    @endif
</div>
@endsection

@section('modal')
@include('layout.modal.graduate.import')
@include('layout.modal.graduate.add')
@include('layout.modal.graduate.delete')
@endsection
