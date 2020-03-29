<div class="header">{{ __('Notifications') }}</div>
<div class="ui divider"></div>
@if ($notifications->count() > 0)
@foreach ($notifications as $key => $value)
    @foreach ($graduates as $graduate)
        @if ($graduate->graduate_id == $value->graduate_id)
        <a href="{{ $value->click_action }}" class="item">
            <div class="ui grid">
                <div class="three wide middle aligned column">
                    <div class="ui tiny image">
                        <img src="{{ asset('storage/defaults/default_avatar_m.png') }}">
                    </div>
                </div>
                <div class="column">
                    <div class="content">
                        <div class="header">{{ $value->title }}</div>
                        <div class="description">
                            <p>{{ $value->body }}</p>
                        </div>
                        <div class="extra">
                            <i class="ui clock teal icon"></i>{{ $value->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endif
    @endforeach
@endforeach
@else
<div class="item">
    <div class="text">{{ __('No incoming notifications.') }}</div>
</div>
@endif
<div class="ui divider"></div>
