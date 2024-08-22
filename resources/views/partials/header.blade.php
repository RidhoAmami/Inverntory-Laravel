<header class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow" style="position: sticky; top: 0; z-index: 1000; width: 100%;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Inventory Barang</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="navbar-nav ms-auto px-3">
        <ul class="navbar-nav">
            @guest
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ ('Guest') }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="position: absolute; top: 100%; left: auto; right: 0;">
                        <a href="{{ route('login') }}" class="dropdown-item">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="dropdown-item">
                            {{ __('Register') }}
                        </a>
                    </div>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="position: absolute; top: 100%; left: auto; right: 0;">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</header>
