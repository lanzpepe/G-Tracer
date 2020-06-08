@extends('home')

@section('title', 'Points & Rewards')

@section('header')
<i class="ui gifts teal icon"></i> @yield('title')
@endsection

@section('button')
<button class="ui right floated teal button add-item">
    <i class="plus icon"></i> {{ __('Add Reward Item') }}
</button>
<button class="ui right floated teal button">
    <i class="star outline icon"></i> {{ __('Point Settings') }}
</button>
@endsection

@section('main')
@if ($rewards->count() > 0)
<div class="ui equal width centered grid container">
    <div class="row">
        <div class="column">
            <div class="ui four doubling cards">
                @foreach ($rewards as $reward)
                <div class="card">
                    <div class="image">
                        <img src="{{ urldecode($reward->image_uri) }}">
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
@else
<div class="ui placeholder basic segment">
    <div class="ui icon header">
        <i class="grin beam sweat outline teal icon"></i>
        {{ __('Reward item list is empty.') }}
    </div>
</div>
@endif
@endsection

@section('modal')
@include('layout.modal.reward.points')
@include('layout.modal.reward.add')
@include('layout.modal.reward.delete')
@endsection
