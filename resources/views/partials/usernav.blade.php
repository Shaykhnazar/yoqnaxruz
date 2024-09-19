{{-- resources/views/partials/usernav.blade.php --}}

<style>
    .notifications {
        margin-top: -12px !important;
        position: absolute !important;
        border-radius: 50%;
        padding: 1px 6px;
        font-size: 10px;
    }
    .notifications .fa-bell {
        font-size: 8px;
    }
</style>

@php
    $user = Auth::user();
@endphp

@if ($user)
    {{-- User Role --}}
    @role('User')
        <li class="{{ Request::is('vehicle') ? 'active' : '' }}">
            <a href="{{ route('vehicle.index') }}">Vehicle</a>
        </li>
        <li class="{{ Request::is('feedback') ? 'active' : '' }}">
            <a href="{{ route('feedback.create') }}">Feedback</a>
        </li>
        <li class="{{ Request::is('tickets*') ? 'active' : '' }}">
            <a href="{{ route('complaints.create') }}">Help Desk</a>
            <ul>
                <li class="{{ Request::is('complaints') ? 'active' : '' }}">
                    <a href="{{ route('complaints.index') }}">
                        Help Desk Tickets
                        @if(!empty($totalNotifications))
                            <span class="btn btn-primary position-relative notifications">
                                {{ $totalNotifications }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>

        </li>
        <li class="{{ Request::is('userprofile') ? 'active' : '' }}">
            <a href="{{ route('user.profile') }}">Profile</a>
        </li>
    @endrole

    {{-- Station Manager Role --}}
    @role('Station Manager')
        <li class="{{ Request::is('fuel_station') ? 'active' : '' }}">
            <a href="{{ route('stations.create') }}">Fuel Station</a>
        </li>
        <li class="{{ Request::is('complaints*') ? 'active' : '' }}">
            <a href="{{ route('complaints.create') }}">Help Desk</a>
            <ul>
                <li class="{{ Request::is('complaints') ? 'active' : '' }}">
                    <a href="{{ route('complaints.index') }}">
                        Help Desk Tickets
                        @if(!empty($totalNotifications))
                            <span class="btn btn-primary position-relative notifications">
                                {{ $totalNotifications }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
        <li class="{{ Request::is('userprofile') ? 'active' : '' }}">
            <a href="{{ route('user.profile') }}">Profile</a>
        </li>
    @endrole
@endif
