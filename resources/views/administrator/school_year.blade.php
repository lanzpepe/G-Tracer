@extends('home')

@section('title', 'Manage School Years')

@section('header')
    <i class="ui calendar check teal icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-sy">
        <i class="plus icon"></i> {{ __('Add School Year') }}
    </button>
@endsection

@section('main')
<div class="ui centered grid">
    <div class="row">
        <div class="column">
            <div class="ui three doubling cards">
                @foreach ($years as $year)
                <div class="card">
                    <div class="center aligned content">
                        <div class="ui icon header">
                            <i class="calendar check teal icon"></i>
                        </div>
                        <div class="header">{{ $year->school_year }}</div>
                    </div>
                    <div class="ui attached red inverted button mark-sy" data-value="{{ $year->id }}">
                        <i class="trash icon"></i>{{ __('Remove') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{ $years->links('vendor.pagination.semantic-ui') }}
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="schoolYearModal" tabindex="-1" role="dialog" aria-labelledby="schoolYearModalLabel" aria-hidden="true">
    <div class="header" id="schoolYearModalLabel">
        <i class="ui question circle outline teal icon"></i>{{ __('Add School Year') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('school_years.store') }}" class="ui form" id="schoolYearForm" method="POST" role="form">
            @csrf
            <div class="required field">
                <label for="sy"><i class="ui calendar check teal icon"></i>School Year</label>
                <input type="text" name="sy" id="sy" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="schoolYearForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markSyModal" tabindex="-1" role="dialog" aria-labelledby="markSyModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markSyModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove School Year') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="sy name"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-sy" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
