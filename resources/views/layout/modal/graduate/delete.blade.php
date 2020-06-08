<div class="ui tiny basic modal" id="markGraduateModal" tabindex="-1" role="dialog" aria-labelledby="markGraduateModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markGraduateModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Graduate') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('The following entries will be removed:') }}</h3>
            <p class="graduate name"></p>
            <p class="graduate course"></p>
            <p class="graduate school"></p>
            <p class="graduate sy"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-graduate" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
