<div class="ui modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="header" id="uploadModalLabel">
        <i class="ui question circle outline teal icon"></i>
        {{ __('Import Graduate List') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('g.parse') }}" class="ui form" id="uploadForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="equal width fields">
                <div class="required field">
                    <label for="_school"><i class="ui school teal icon"></i>{{ __('School') }}</label>
                    <select name="_school" id="_school" class="ui fluid dropdown" required>
                        <option value="{{ $admin->school }}">{{ $admin->school }}</option>
                    </select>
                </div>
                <div class="required field">
                    <label for="_dept"><i class="ui building teal icon"></i>{{ __('Department') }}</label>
                    <select name="_dept" id="_dept" class="ui fluid dropdown" required>
                        <option value="{{ $admin->department }}">{{ $admin->department }}</option>
                    </select>
                </div>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label for="_course"><i class="ui book reader teal icon"></i>{{ __('Degree') }}</label>
                    <select name="_course" id="_course" class="ui fluid dropdown">
                        @foreach ($courses->unique('name') as $course)
                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="_major"><i class="ui award teal icon"></i>{{ __('Major') }}</label>
                    <select name="_major" id="_major" class="ui fluid dropdown">
                        @foreach ($courses->unique('major') as $course)
                        <option value="{{ $course->major }}">{{ $course->major }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label for="_sy"><i class="ui calendar check outline teal icon"></i>{{ __('School Year') }}</label>
                    <select name="_sy" id="_sy" class="ui fluid dropdown" required>
                        @foreach ($years as $y)
                        <option value="{{ $y->year }}">{{ $y->year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="required field">
                    <label for="_batch"><i class="ui calendar check outline teal icon"></i>{{ __('Batch') }}</label>
                    <select name="_batch" id="_batch" class="ui fluid dropdown" required>
                        @foreach ($batches as $batch)
                        <option value="{{ $batch->month }}">{{ $batch->month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="required field">
                <label for="_file"><i class="ui file outline teal icon"></i>{{ __('Graduate List (.csv)') }}</label>
                <input type="file" accept=".csv" name="_file" id="_file" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="uploadForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
