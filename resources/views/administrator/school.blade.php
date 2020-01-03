@extends('home')

@section('title', 'Manage Schools')

@section('header')
    <i class="ui school teal icon"></i> @yield('title')
@endsection

@section('button')
    <button class="ui right floated teal button add-school">
        <i class="plus icon"></i> {{ __('Add School') }}
    </button>
@endsection

@section('main')
<div class="ui centered grid">
    <div class="row">
        <div class="column">
            <div class="ui stackable three cards">
                @foreach ($schools as $school)
                <div class="card">
                    <div class="center aligned content">
                        <div class="ui icon header">
                            <i class="school teal icon"></i>
                        </div>
                        <div class="header">{{ $school->name }}</div>
                    </div>
                    <div class="ui attached red inverted button mark-school" data-value="{{ $school->name }}">
                        <i class="trash icon"></i>Remove
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="ui centered grid">
            <div class="column">
                {{ $schools->links('vendor.pagination.semantic-ui') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="schoolModal" tabindex="-1" role="dialog" aria-labelledby="schoolModalLabel" aria-hidden="true">
    <div class="ui icon header" id="schoolModalLabel">
        <i class="question circle outline teal icon"></i>{{ __('Add New School') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_school') }}" class="ui form" id="schoolForm" method="POST">
            @csrf
            <div class="required field">
                <label for="school"><i class="ui school teal icon"></i>{{ __('School Name') }}</label>
                <input type="text" name="school" id="school" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="schoolForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </div>
    </div>
</div>
<div class="ui tiny basic modal" id="markSchoolModal" tabindex="-1" role="dialog" aria-labelledby="markSchoolModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markSchoolModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove School') }}
    </div>
    <div class="content" role="document">
        <h3>{{ __('The following entries will be removed:') }}</h3>
        <p class="school name"></p>
        <h3>{{ __('Proceed anyway?') }}</h3>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-school">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
