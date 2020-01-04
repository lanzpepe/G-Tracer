@extends('home')

@section('title', 'Manage Departments')

@section('header')
    <i class="ui building teal icon"></i> @yield('title')
@endsection

@section('button')
    <button type="button" class="ui right floated teal button add-dept">
        <i class="plus icon"></i> {{ __('Add Department') }}
    </button>
@endsection

@section('main')
<div class="ui centered grid">
<div class="row">
    <div class="column">
    <div class="ui stackable three cards">
        @foreach ($depts as $dept)
            @foreach ($dept->schools as $school)
            <div class="card">
                <div class="center aligned content">
                    <div class="ui icon header">
                        <i class="building teal icon"></i>
                    </div>
                    <div class="header">{{ $dept->name }}</div>
                    <div class="description">{{ $school->name }}</div>
                </div>
                <div class="ui attached red inverted button mark-dept" data-value="{{ $dept->id . "+" . $school->id }}">
                    <i class="trash icon"></i>{{ __('Remove') }}
                </div>
            </div>
            @endforeach
        @endforeach
    </div>
    </div>
</div>
<div class="row">
    <div class="ui centered grid">
        <div class="column">
            {{ $depts->links('vendor.pagination.semantic-ui') }}
        </div>
    </div>
</div>
</div>
@endsection

@section('modal')
<div class="ui tiny modal" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="deptModalLabel" aria-hidden="true">
    <div class="ui icon header" id="deptModalLabel">
        <i class="question circle outline teal icon"></i>{{ __('Add New Department') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('departments.store') }}" class="ui form" id="deptForm" method="POST" role="form">
            @csrf
            <div class="required field school">
                <label for="school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                <select id="school" name="school" class="ui fluid dropdown" required>
                    <option value="" selected>{{ __('-- Select School --') }}</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->name }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="required field dept">
                <label for="dept"><i class="ui building teal icon"></i>{{ __('Department Name') }}</label>
                <select name="dept" id="dept" class="ui fluid search dropdown" required>
                    <option value="" selected>{{ __('Department Name') }}</option>
                    @foreach ($depts as $dept)
                        <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="deptForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markDeptModal" tabindex="-1" role="dialog" aria-labelledby="markDeptModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markDeptModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Department') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="department name"></p>
            <p class="school name"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-dept" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
@endsection
