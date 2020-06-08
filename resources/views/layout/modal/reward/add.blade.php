<div class="ui tiny modal" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="header" id="rewardModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add Reward Item') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('rewards.store') }}" class="ui form" id="rewardForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_value" id="_value" value="">
            <div class="required field">
                <label for="name"><i class="ui font teal icon"></i>{{ __('Item Name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="required field">
                <label for="description"><i class="ui font teal icon"></i>{{ __('Item Description') }}</label>
                <input type="text" name="description" id="description" value="{{ old('description') }}" required>
            </div>
            <div class="equal width fields">
                <div class="required field">
                    <label for="description"><i class="ui star outline teal icon"></i>{{ __('Points Required') }}</label>
                    <input type="text" name="points" id="points" value="{{ old('points') }}" required>
                </div>
                <div class="required field">
                    <label for="description"><i class="ui cart down arrow teal icon"></i>{{ __('Quantity') }}</label>
                    <input type="text" name="quantity" id="quantity" value="{{ old('quantity') }}" required>
                </div>
            </div>
            <div class="field">
                <label for="image"><i class="file image teal icon"></i>{{ __('Item Image (if applicable)') }}</label>
                <input type="file" accept="image/*" name="image" id="image">
            </div>
        </form>
    </div>
    <div class="actions">
        <button type="button" class="ui red cancel inverted button">
            <i class="close icon"></i>{{ __('Cancel') }}
        </button>
        <button type="submit" class="ui green submit inverted button" form="rewardForm" id="btnReward" name="btnReward" value="added">
            <i class="check icon"></i><span class="label">{{ __('Submit') }}</span>
        </button>
    </div>
</div>
