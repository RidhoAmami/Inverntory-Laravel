@auth
    @if (!Request::is('login') && !Request::is('register'))
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                            <span data-feather="home" class="align-text-bottom"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('products') ? 'active' : '' }}" href="/products">
                            <span data-feather="package" class="align-text-bottom"></span>
                            Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('categories') ? 'active' : '' }}" href="/categories">
                            <span data-feather="tag" class="align-text-bottom"></span>
                            Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('imports') || Request::is('imports/create') || Request::is('imports/*') ? 'active' : '' }}" href="/imports">
                            <span data-feather="download" class="align-text-bottom"></span>
                            Barang Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('exports') || Request::is('exports/create') || Request::is('exports/*') ? 'active' : '' }}" href="/exports">
                            <span data-feather="upload" class="align-text-bottom"></span>
                            Barang Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('suppliers') ? 'active' : '' }}" href="/suppliers">
                            <span data-feather="users" class="align-text-bottom"></span>
                            Supplier
                        </a>
                    </li>
                </ul>    
            </div>
        </nav>
    @endif
@endauth
