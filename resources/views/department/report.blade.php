@extends('home')

@section('title', "View Report - {$graduate->getFullNameAttribute()}")

@section('header')
<i class="ui chart bar teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button graduates" data-target="{{ route('graduates.index') }}">
    <i class="arrow left icon"></i> {{ __('Back to List') }}
</button>
@endsection

@section('main')
<div class="ui container">
    <div class="ui divided grid">
        <div class="twelve wide column">
            <h1 class="ui teal header">
                {{$graduate->getFullNameAttribute()}}
                <div class="sub header">
                    {{$graduate->degree}}
                </div>
                <div class="sub header">
                    Batch: {{$graduate->batch}}
                </div>
                <div class="sub header">
                    School Year: {{$graduate->school_year}}
                </div>
            </h1>
        </div>
        <div class="two wide column">
            <div class="ui teal statistic">
              <div class="label">
                Respondents
              </div>
              <div class="value">
                {{ $responses->count() }}
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="first">{{ __('Chart') }}</a>
                <a class="item" data-tab="second">{{ __('Table') }}</a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="first">
                <div class="ui grid">
                    <div class="eight wide column">
                        {{ $nameChart->container() }}
                    </div>
                    <div class="eight wide column">
                        {{ $addressChart->container() }}
                    </div>
                </div>
                <div class="ui grid">
                    <div class="eight wide column">
                        {{ $positionChart->container() }}
                    </div>
                    <div class="eight wide column">
                        {{ $dateEmployedChart->container() }}
                    </div>
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
    {{-- <div class="ui divided grid">
        <div class="twelve wide column">
            <h1 class="ui teal header">
                {{$graduate->getFullNameAttribute()}}
                <div class="sub header">
                    {{$graduate->degree}}
                </div>
                <div class="sub header">
                    Batch: {{$graduate->batch}}
                </div>
                <div class="sub header">
                    School Year: {{$graduate->school_year}}
                </div>
            </h1>
        </div>
        <div class="two wide column">
            <div class="ui teal statistic">
              <div class="label">
                Respondents
              </div>
              <div class="value">
                {{ $responses->count() }}
              </div>
            </div>
        </div>
    </div>
    <div class="ui top attached tabular menu">
        <a class="item active" data-tab="first">{{ __('Chart') }}</a>
        <a class="item" data-tab="second">{{ __('Table') }}</a>
    </div>
    <div class="ui bottom attached tab segment active" data-tab="first">

        <div class="ui grid">
            <div class="eight wide column">
                {{ $nameChart->container() }}
            </div>
            <div class="eight wide column">
                {{ $addressChart->container() }}
            </div>
        </div>
        <div class="ui grid">
            <div class="eight wide column">
                {{ $positionChart->container() }}
            </div>
            <div class="eight wide column">
                {{ $dateEmployedChart->container() }}
            </div>
        </div>
    </div>
    <div class="ui bottom attached tab segment" data-tab="second">
        <table class="ui unstackable selectable celled compact teal table">
            <thead>
                <tr class="center aligned">
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
                    <td>{{ $response->company_name }}</td>
                    <td>{{ $response->company_address }}</td>
                    <td>{{ $response->job_position }}</td>
                    <td>{{ $response->date_employed }}</td>
                    <td>{{ $response->remarks }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
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
