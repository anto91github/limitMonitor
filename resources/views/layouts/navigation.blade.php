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
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                </svg>
                Admin Setting
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                        </svg>
                        {{ __('Users') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                        </svg>
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
    
    
        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                </svg>
                Form
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="/form-client-limit">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            Form Client Limit
                        </a>
                    </li>
                @endif
                
                @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="/form-client-order">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                            </svg>
                            Form Order
                        </a>
                    </li>
                @endif          
            </ul>
        </li>
    

    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
            </svg>
            Data Window
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href={{ route('window.index') }}>
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                    </svg>
                    Window Order
                </a>
            </li>

            @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('window-approve.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                        </svg>
                        Window Approval
                    </a>
                </li> 
            @endif
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('client-position.index') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                    </svg>
                    Client Position
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('trade.transactions') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                    </svg>
                    Trade History
                </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ route('client.transactions') }}">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
                    </svg>
                    Order History
                </a>
            </li> 
        </ul>
    </li>

</ul>
