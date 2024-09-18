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
        <li class="{{ Request::is('vehicles') ? 'active' : '' }}">
            <a href="{{ route('user.vehicles') }}">My Vehicles</a>
        </li>
        <li class="{{ Request::is('feedback') ? 'active' : '' }}">
            <a href="{{ route('user.feedback') }}">Feedback</a>
        </li>
        <li class="{{ Request::is('prices') ? 'active' : '' }}">
            <a href="{{ route('user.prices') }}">Add Prices</a>
        </li>
        <li class="{{ Request::is('tickets*') ? 'active' : '' }}">
            <a href="{{ route('user.tickets') }}">Help Desk</a>
            <ul>
                <li class="{{ Request::is('tickets') ? 'active' : '' }}">
                    <a href="{{ route('user.tickets') }}">
                        Help Desk Tickets
                        <span class="btn btn-primary position-relative notifications">
                                {{ $totalNotifications ?? 0 }}
                            </span>
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
        <li class="{{ Request::is('stations') ? 'active' : '' }}">
            <a href="{{ route('station-manager.stations') }}">My Stations</a>
        </li>
        <li class="{{ Request::is('tickets*') ? 'active' : '' }}">
            <a href="{{ route('station-manager.tickets') }}">Help Desk</a>
            <ul>
                <li class="{{ Request::is('tickets') ? 'active' : '' }}">
                    <a href="{{ route('station-manager.tickets') }}">Help Desk Tickets</a>
                </li>
            </ul>
        </li>
        <li class="{{ Request::is('userprofile') ? 'active' : '' }}">
            <a href="{{ route('user.profile') }}">Profile</a>
        </li>
    @endrole
@endif
