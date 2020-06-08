<div class="ui overlay fullscreen modal" id="graduateModal" tabindex="-1" role="dialog" aria-labelledby="graduateModalLabel" aria-hidden="true">
    <div class="header" id="graduateModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add Graduate') }}</span>
    </div>
    <div class="scrolling content" role="document">
        <form action="{{ route('graduates.store') }}" class="ui form" id="graduateForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="temp" name="temp" value="">
            <div class="ui grid container">
                <div class="row">
                <div class="six wide column">
                <div class="ui special cards">
                    <div class="card">
                    <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                        <div class="center">
                        <button type="button" class="ui teal inverted button">
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
                                <select name="sy" class="ui fluid dropdown sy" required>
                                    <option value="" selected>{{ __('-- Select School Year --') }}</option>
                                    @foreach ($years as $y)
                                    <option value="{{ $y->year }}">{{ $y->year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="required field">
                                <label for="batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                                <select name="batch" class="ui fluid dropdown batch" required>
                                    <option value="" selected>{{ __('-- Select Batch --') }}</option>
                                    @foreach ($batches as $batch)
                                    <option value="{{ $batch->month }}">{{ $batch->month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="five wide required field">
                                <label for="lastname"><i class="ui user outline teal icon"></i>{{ __('Last Name') }}</label>
                                <input type="text" name="lastname" id="lastname" value="" required>
                            </div>
                            <div class="five wide required field">
                                <label for="firstname"><i class="ui user outline teal icon"></i>{{ __('First Name') }}</label>
                                <input type="text" name="firstname" id="firstname" value="" required>
                            </div>
                            <div class="two wide field">
                                <label for="midname"><i class="ui user outline teal icon"></i>{{ __('M.I.') }}</label>
                                <input type="text" name="midname" id="midname" value="">
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="four wide required field">
                                <label for="gender"><i class="ui venus mars teal icon"></i>{{ __('Gender') }}</label>
                                <select name="gender" class="ui fluid dropdown gender" required>
                                    <option value="" selected>{{ __('-- Select Gender --') }}</option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="required field">
                            <label for="address"><i class="ui home teal icon"></i>{{ __('Address') }}</label>
                            <input type="text" name="address" id="address" value="" required>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="course"><i class="ui book reader teal icon"></i>{{ __('Degree') }}</label>
                                <select name="course" class="ui fluid dropdown course" required>
                                    <option value="" selected>{{ __('-- Select Course --') }}</option>
                                    @foreach ($courses->unique('name') as $course)
                                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="major"><i class="ui award teal icon"></i>{{ __('Major') }}</label>
                                <select name="major" class="ui fluid dropdown major" required>
                                    <option value="" selected>{{ __('-- Select Major --') }}</option>
                                    @foreach ($courses->unique('major') as $course)
                                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                                <select name="dept" id="dept" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->department }}">{{ $admin->department }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="equal width fields">
                            <div class="required field">
                                <label for="school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                                <select name="school" id="school" class="ui fluid dropdown" required>
                                    <option value="{{ $admin->school }}">{{ $admin->school }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
