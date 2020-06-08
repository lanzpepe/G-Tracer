<div class="ui modal" id="linkedInUploadModal" tabindex="-1" role="dialog" aria-labelledby="linkedInUploadModalLabel" aria-hidden="true">
    <div class="header" id="linkedInUploadModalLabel">
        <i class="ui question circle outline teal icon"></i>
        {{ __('Import LinkedIn Data') }}
    </div>
    <div class="content" role="document">
        <form action="{{ route('in.parse') }}" class="ui form" id="uploadInForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="required field">
                <label for="file"><i class="ui file outline teal icon"></i>{{ __('LinkedIn Data (.csv)') }}</label>
                <input type="file" accept=".csv" name="file" id="file" required>
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="uploadInForm">
            <i class="check icon"></i> {{ __('Submit') }}
        </button>
    </div>
</div>
