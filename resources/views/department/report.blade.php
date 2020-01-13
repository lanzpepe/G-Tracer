@extends('home')

@section('title', "View Report - {$graduate->getFullNameAttribute()}")

@section('header')
<i class="ui chart bar teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button graduates" data-target="{{ route('graduates') }}">
    <i class="arrow left icon"></i> {{ __('Back to List') }}
</button>
@endsection

@section('main')
<div class="ui fluid container">
    <div class="ui top attached tabular menu">
        <a class="item active" data-tab="first">{{ __('Chart') }}</a>
        <a class="item" data-tab="second">{{ __('Table') }}</a>
        <a class="item" data-tab="third">{{ __('Info') }}</a>
    </div>
    <div class="ui bottom attached tab segment active" data-tab="first">
        <div class="column">
            {{ $nameChart->container() }}
        </div>
        <hr>
        <div class="column">
            {{ $addressChart->container() }}
        </div>
        <hr>
        <div class="column">
            {{ $positionChart->container() }}
        </div>
        <hr>
        <div class="column">
            {{ $dateEmployedChart->container() }}
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="second">
        <table class="ui unstackable selectable celled compact teal table">
            <thead>
                <tr class="center aligned">
                    <th>{{ __('Response ID') }}</th>
                    <th>{{ __('Company Name') }}</th>
                    <th>{{ __('Company Address') }}</th>
                    <th>{{ __('Job Position') }}</th>
                    <th>{{ __('Date Employed') }}</th>
                    <th>{{ __('Remarks') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($responses as $response)
                <tr class="center aligned">
                    <td>{{ $response->response_id }}</td>
                    <td>{{ $response->company_name }}</td>
                    <td>{{ $response->company_address }}</td>
                    <td>{{ $response->job_position }}</td>
                    <td>{{ $response->date_employed }}</td>
                    <td>{{ $response->remarks }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="ui bottom attached tab segment" data-tab="third">
        <div class="ui centered grid">
            <div class="row">
                <div class="ui large teal statistic">
                    <div class="value">{{ $responses->count() }}</div>
                    <div class="label">{{ __('Respondents') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{!! $nameChart->script() !!}
{!! $addressChart->script() !!}
{!! $positionChart->script() !!}
{!! $dateEmployedChart->script() !!}
@endsection
