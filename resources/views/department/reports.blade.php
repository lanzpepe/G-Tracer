@extends('home')

@section('title', 'Graduate Statistics')

@section('header')
<i class="ui chart bar teal icon"></i> @yield('title')
@endsection

@section('main')
<div class="ui container">
<div class="ui top attached tabular menu">
    <a class="item active" data-tab="first">{{ __('1 year') }}</a>
    <a class="item" data-tab="second">{{ __('5 years') }}</a>
</div>

<div class="ui bottom attached tab segment active" data-tab="first">
<div class="ui centered celled grid">
<div class="six wide column">
    {{ $employmentChart->container() }}
</div>
<div class="ten wide blue column">
    <h2 class="ui top attached blue header">
      Employment
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  50
                </div>
                <div class="label">
                  number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui two statistics">
            <div class="blue statistic">
                <div class="value">
                  80% (40)
                </div>
                <div class="label">
                  Employed
                </div>
            </div>
            <div class="blue statistic">
                <div class="value">
                  20% (10)
                </div>
                <div class="label">
                  Unemployed
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="ui centered celled grid">
<div class="ten wide teal column">
    <h2 class="ui top attached teal header">
      Job alignment to the degree graduated
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  50
                </div>
                <div class="label">
                  number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui two statistics">
            <div class="teal statistic">
                <div class="value">
                  64% (32)
                </div>
                <div class="label">
                  Aligned
                </div>
            </div>
            <div class="teal statistic">
                <div class="value">
                  20% (18)
                </div>
                <div class="label">
                  Not Aligned
                </div>
            </div>
        </div>
    </div>
</div>
<div class="six wide column">
    {{ $alignedChart->container() }}
</div>
</div>
<div class="ui centered celled grid">
<div class="six wide column">
    {{ $employabilityChart->container() }}
</div>
<div class="ten wide olive  column">
    <h2 class="ui top attached olive header">
      Employed within...
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  50
                </div>
                <div class="label">
                number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui two statistics">
            <div class="olive statistic">
                <div class="value">
                  72% (36)
                </div>
                <div class="label">
                     Within 6 months
                </div>
            </div>
            <div class="olive statistic">
                <div class="value">
                  28% (14)
                </div>
                <div class="label">
                  After 6 months
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- SECOND TAB -->
<div class="ui bottom attached tab segment" data-tab="second">

    <div class="ui centered celled grid">
<div class="six wide column">
    {{ $fiveYearEmploymentChart->container() }}
</div>
<div class="ten wide blue column">
    <h2 class="ui top attached blue header">
      Report on the number of Employed Graduates per year
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  45
                </div>
                <div class="label">
                 average number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui five statistics">
            <div class="blue statistic">
                <div class="value">
                  39
                </div>
                <div class="label">
                  2017
                </div>
            </div>
            <div class="blue statistic">
                <div class="value">
                  50
                </div>
                <div class="label">
                  2018
                </div>
            </div>
            <div class="blue statistic">
                <div class="value">
                  62
                </div>
                <div class="label">
                  2019
                </div>
            </div>
            <div class="blue statistic">
                <div class="value">
                  30
                </div>
                <div class="label">
                  2020
                </div>
            </div>
            <div class="blue statistic">
                <div class="value">
                  45
                </div>
                <div class="label">
                  2021
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="ui centered celled grid">
<div class="ten wide teal column">
    <h2 class="ui top attached teal header">
      Number of Graduates with jobs aligned with their degree program
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  39
                </div>
                <div class="label">
                  Average number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui five statistics">
            <div class="teal statistic">
                <div class="value">
                  32
                </div>
                <div class="label">
                  2017
                </div>
            </div>
            <div class="teal statistic">
                <div class="value">
                  45
                </div>
                <div class="label">
                  2018
                </div>
            </div>
            <div class="teal statistic">
                <div class="value">
                  52
                </div>
                <div class="label">
                  2019
                </div>
            </div>
            <div class="teal statistic">
                <div class="value">
                  27
                </div>
                <div class="label">
                  2020
                </div>
            </div>
            <div class="teal statistic">
                <div class="value">
                  39
                </div>
                <div class="label">
                  2021
                </div>
            </div>
        </div>
    </div>
</div>
<div class="six wide column">
    {{ $fiveYearAlignedChart->container() }}
</div>
</div>
<div class="ui centered celled grid">
<div class="six wide column">
    {{ $fiveYearEmployabilityChart->container() }}
</div>
<div class="ten wide olive column">
    <h2 class="ui top attached olive header">
      Number of Graduates that are employed within 6 months after graduation
    </h2>
    <div class="ui attached segment">
        <div class="ui one statistics">
            <div class="statistic">
                <div class="value">
                  36
                </div>
                <div class="label">
                average number of graduates
                </div>
            </div>
        </div>
    </div>
    <div class="ui attached segment">
        <div class="ui five statistics">
            <div class="olive statistic">
                <div class="value">
                  30
                </div>
                <div class="label">
                  2017
                </div>
            </div>
            <div class="olive statistic">
                <div class="value">
                  42
                </div>
                <div class="label">
                  2018
                </div>
            </div>
            <div class="olive statistic">
                <div class="value">
                  48
                </div>
                <div class="label">
                  2019
                </div>
            </div>
            <div class="olive statistic">
                <div class="value">
                  25
                </div>
                <div class="label">
                  2020
                </div>
            </div>
            <div class="olive statistic">
                <div class="value">
                  36
                </div>
                <div class="label">
                  2021
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
    {{ $employmentChart->script() }}
    {{ $employabilityChart->script() }}
    {{ $alignedChart->script() }}
    {{ $fiveYearEmploymentChart->script() }}
    {{ $fiveYearEmployabilityChart->script() }}
    {{ $fiveYearAlignedChart->script() }}
@endsection
