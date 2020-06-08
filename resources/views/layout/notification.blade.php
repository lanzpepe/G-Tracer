<div class="header">{{ __('Notifications') }}</div>
<div class="ui divider"></div>
@if ($notifications->count() > 0)
@foreach ($notifications as $notification)
    <a href="{{ $notification->data['click_action'] }}" class="item" data-value="{{ $notification->data['graduate_id'] }}">
        <div class="ui grid">
            <div class="three wide middle aligned column">
                <div class="ui tiny circular image">
                    <img src="{{ asset('storage/defaults/default_avatar_m.png') }}">
                </div>
            </div>
            <div class="column">
                <div class="content">
                    <div class="header">
                        {{ $notification->data['title'] }}
                        @if ($notification->read_at == null)
                        <div class="ui green empty circular label"></div>
                        @endif
                    </div>
                    <div class="description">
                        <p>{{ $notification->data['body']}}</p>
                    </div>
                    <div class="extra">
                        <i class="ui clock teal icon"></i>{{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </a>
@endforeach
@else
<div class="item">
    <div class="text">{{ __('No incoming notifications.') }}</div>
</div>
@endif
<div class="ui divider"></div>
