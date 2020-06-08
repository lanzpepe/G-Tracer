<div class="ui tiny basic modal" id="markRewardModal" tabindex="-1" role="dialog" aria-labelledby="markRewardModalLabel" aria-hidden="true">
    <div class="ui icon header" id="markRewardModalLabel">
        <i class="exclamation triangle red icon"></i>{{ __('Remove Item') }}
    </div>
    <div class="content" role="document">
        <form action="#" class="ui form" id="deleteForm" method="POST" role="form">
            @csrf
            @method('DELETE')
            <h3>{{ __('An item will be removed:') }}</h3>
            <p class="name holder"></p>
            <h3>{{ __('Proceed anyway?') }}</h3>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui green cancel basic inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui red submit inverted button delete-item" form="deleteForm">
            <i class="trash icon"></i> {{ __('Delete') }}
        </button>
    </div>
</div>
