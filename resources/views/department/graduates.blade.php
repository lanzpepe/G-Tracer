@extends('home')

@section('title', 'Graduate List')

@section('header')
    <i class="ui user graduate teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-graduate">
    <i class="plus icon"></i> {{ __('Add Graduate') }}
</button>
@endsection

@section('main')
<div class="ui centered grid">
    <div class="row">
        <div class="column">
            <div class="ui four special cards">
                @foreach ($graduates as $graduate)
                <div class="ui teal raised card">
                    <div class="blurring dimmable image">
                        <div class="ui dimmer">
                            <div class="content">
                                <div class="center">
                                    <div class="ui inverted button edit-graduate" data-value="{{ $graduate->graduate_id }}">{{ __('Update') }}</div>
                                </div>
                            </div>
                        </div>
                        <img src="{{ $graduate->image() }}">
                    </div>
                    <div class="content">
                        <div class="header">{{ $graduate->first_name . " " . $graduate->middle_name . " " . $graduate->last_name }}</div>
                        <div class="meta">{{ $graduate->degree }}</div>
                        <div class="description">
                            <p>{{ "S.Y. Graduated: " . $graduate->school_year }}</p>
                            <p>{{ "Batch: " . $graduate->batch }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="ui centered grid">
            <div class="column">
                {{ $graduates->links('vendor.pagination.semantic-ui') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="ui overlay fullscreen modal" id="graduateModal" tabindex="-1" role="dialog" aria-labelledby="graduateModalLabel" aria-hidden="true">
    <div class="ui icon header" id="graduateModalLabel">
        <i class="question circle outline teal icon"></i><span class="title">{{ __('Add Graduate') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('add_graduate') }}" class="ui form" id="graduateForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ui grid container">
                <div class="row">
                <div class="six wide column">
                <div class="ui special cards">
                    <div class="card">
                    <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                        <div class="center">
                        <button type="button" class="ui inverted button">
                            <label for="image">{{ __('Upload Image') }}</label>
                            <input type="file" name="image" id="image" accept="image/*">
                        </button>
                        </div>
                        </div>
                    </div>
                    <img src="{{ asset('storage/defaults/default_avatar_m.png') }}" alt="Preview Image" id="preview">
                    </div>
                </div>
                </div>
                </div>
                    <div class="ten wide column">
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="sy"><i class="ui calendar check outline teal icon"></i>{{ __('School Year') }}</label>
                                <select name="sy" id="sy" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select School Year --') }}</option>
                                    @foreach ($schoolYears as $year)
                                        <option value="{{ $year->school_year }}">{{ $year->school_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="required field">
                                <label for="batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                                <select name="batch" id="batch" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Batch --') }}</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="five wide required field">
                                <label for="lastname"><i class="ui user outline teal icon"></i>Last Name</label>
                                <input type="text" name="lastname" id="lastname" value="" required>
                            </div>
                            <div class="five wide required field">
                                <label for="firstname"><i class="ui user outline teal icon"></i>First Name</label>
                                <input type="text" name="firstname" id="firstname" value="" required>
                            </div>
                            <div class="two wide field">
                                <label for="midname"><i class="ui user outline teal icon"></i>M.I.</label>
                                <input type="text" name="midname" id="midname" value="">
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="four wide required field">
                                <label for="gender"><i class="ui venus mars teal icon"></i>Gender</label>
                                <select name="gender" id="gender" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Gender --') }}</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="course"><i class="ui book reader teal icon"></i>{{ __('Degree') }}</label>
                                <select name="course" id="course" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Course --') }}</option>
                                    @foreach ($courses->unique('name') as $course)
                                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="field">
                                <label for="major"><i class="ui award teal icon"></i>{{ __('Major') }}</label>
                                <select name="major" id="major" class="ui fluid dropdown" required>
                                    <option value="" selected>{{ __('-- Select Major --') }}</option>
                                    @foreach ($courses->unique('major') as $course)
                                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="school"><i class="ui school teal icon"></i>School</label>
                                <select name="school" id="school" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->schools->first()->name }}">{{ $admin->schools->first()->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                                <select name="dept" id="dept" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->departments->first()->name }}">{{ $admin->departments->first()->name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="temp" id="temp" value="">
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="graduateForm" id="btnGraduate"
                name="btnGraduate" value="added">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
<div class="ui tiny basic modal" id="markGraduateModal" tabindex="-1" role="dialog" aria-labelledby="markGraduateModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markGraduateModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Graduate') }}
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
