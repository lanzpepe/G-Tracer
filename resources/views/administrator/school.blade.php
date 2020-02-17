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
<div class="ui container">
    <div class="ui equal width centered grid">
        <div class="row">
            <div class="column">
                <div class="ui five doubling cards">
                    @foreach ($schools as $school)
                    <div class="card">
                        <div class="image">
                            <img src="{{ 'storage/' . rawurldecode($school->logo) }}">
                        </div>
                        <div class="center aligned content">
                            <div class="header">{{ $school->name }}</div>
                        </div>
                        <div class="ui attached red inverted button mark-school" data-value="{{ $school->id }}">
                            <i class="trash icon"></i> {{ __('Remove') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{ $schools->links('vendor.pagination.semantic-ui') }}
    </div>
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="schoolModal" tabindex="-1" role="dialog" aria-labelledby="schoolModalLabel" aria-hidden="true">
    <div class="header" id="schoolModalLabel">
        <i class="ui question circle outline teal icon"></i>{{ __('Add New School') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('schools.store') }}" class="ui form" id="schoolForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="required field">
                <label for="school"><i class="ui school teal icon"></i>{{ __('School Name') }}</label>
                <input type="text" name="school" id="school" required>
            </div>
            <div class="field">
                <label for="logo"><i class="file image teal icon"></i>{{ __('School Logo (if applicable)') }}</label>
                <input type="file" name="logo" id="logo" accept="image/*">
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="schoolForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markSchoolModal" tabindex="-1" role="dialog" aria-labelledby="markSchoolModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markSchoolModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove School') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="school name"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-school" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
