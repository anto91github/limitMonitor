<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>


    @if (Auth::user()->role_id == 3)
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <img src="{{ asset('icons/admin.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                Admin Setting
            </a>
            <ul class="nav-group-items" style="height: {{ request()->is('users*') || request()->is('roles*') ? 'auto' : '0px' }}; overflow: hidden;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <img src="{{ asset('icons/user.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                        {{ __('Users') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <img src="{{ asset('icons/role.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                        {{ __('Roles') }}
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}"
                        href="{{ route('permissions.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-room') }}"></use>
                        </svg>
                        {{ __('Permissions') }}
                    </a>
                </li>            --}}
            </ul>
        </li>
    @endif
    
    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <img src="{{ asset('icons/form.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                Form
            </a>
            <ul class="nav-group-items" style="height: {{ request()->is('form-client-limit*') || request()->is('form-client-order*') ? 'auto' : '0px' }}; overflow: hidden;">
                @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('form-client-limit*') ? 'active' : '' }}" href="/form-client-limit">
                            <img src="{{ asset('icons/formclient.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                            Form Client Limit
                        </a>
                    </li>
                @endif
                
                @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('form-client-order*') ? 'active' : '' }}" href="/form-client-order">
                            <img src="{{ asset('icons/formorder.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                            Form Order
                        </a>
                    </li>
                @endif          
            </ul>
        </li>
    @endif

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <img src="{{ asset('icons/order.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
            Data Window
        </a>
        <ul class="nav-group-items" style="height: {{ request()->is('window*') || request()->is('window-approve*') || 
                                                    request()->is('client-position*') || request()->is('trade-transactions*') ||
                                                    request()->is('client-transactions*') ? 'auto' : '0px' }}; overflow: hidden;">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href={{ route('window.index') }}>
                    <img src="{{ asset('icons/windoworder.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                    Window Order
                </a>
            </li>

            @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('window-approve.index') }}">
                        <img src="{{ asset('icons/windowapproval.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                        Window Approval
                    </a>
                </li> 
            @endif
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('client-position.index') }}">
                    <img src="{{ asset('icons/clienposition.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                    Client Position
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('trade.transactions') }}">
                    <img src="{{ asset('icons/tradehistory.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                    Trade History
                </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('client.transactions') }}">
                    <img src="{{ asset('icons/orderhistory.png') }}" class="nav-icon" style="width: 20px; height: 20px;">
                    Order History
                </a>
            </li> 
        </ul>
    </li>

</ul>

<style>
    .nav-group-items {
        transition: height 0.3s ease; /* Transisi untuk efek halus */
    }
    .nav-icon {
    width: 16px;
    height: 16px;
    margin-right: 4px;
    object-fit: contain;
}
</style>
