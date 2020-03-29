@extends('home')

@section('title', 'Points & Rewards')

@section('header')
<i class="ui gifts teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-item">
    <i class="plus icon"></i> {{ __('Add Reward Item') }}
</button>
@endsection

@section('main')
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            <div class="ui four doubling cards">
                @foreach ($rewards as $reward)
                <div class="card">
                    <div class="image">
                        <img src="{{ $reward->image() }}">
                    </div>
                    <div class="center aligned content">
                        <div class="header">{{ $reward->name }}</div>
                        <div class="meta">{{ "Points: {$reward->points} [{$reward->quantity} pcs. left]" }}</div>
                        <div class="description">{{ $reward->description }}</div>
                    </div>
                    <div class="ui attached two buttons">
                        <div class="ui inverted green button edit-item" data-value="{{ $reward->id }}">{{ __('Edit') }}</div>
                        <div class="ui inverted red button mark-item" data-value="{{ $reward->id }}">{{ __('Remove') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    {{ $rewards->links('vendor.pagination.semantic-ui') }}
</div>
@endsection

@section('modal')
<div class="ui small modal" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="rewardModalLabel" aria-hidden="true">
    <div class="header" id="rewardModalLabel">
        <i class="ui question circle outline teal icon"></i><span class="title">{{ __('Add Reward Item') }}</span>
    </div>
    <div class="content" role="document">
        <form action="{{ route('rewards.store') }}" class="ui form" id="rewardForm" method="POST" role="form" enctype="multipart/form-data">
            @csrf
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
            <input type="hidden" id="itemId" name="itemId" value="">
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
@endsection
