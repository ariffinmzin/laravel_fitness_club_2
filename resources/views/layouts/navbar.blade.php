<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <li
                        class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <span
                                class="nav-link-icon d-md-none d-lg-inline-block"
                            >
                                <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <polyline
                                        points="5 12 3 12 12 3 21 12 19 12"
                                    />
                                    <path
                                        d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"
                                    />
                                    <path
                                        d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"
                                    />
                                </svg>
                            </span>
                            <span class="nav-link-title">Home</span>
                        </a>
                    </li>

                    @can('is-admin')
                        <li
                            class="nav-item {{ request()->is('pengguna*') ? 'active' : '' }}"
                        >
                            <a
                                class="nav-link"
                                href="{{ route('pengguna.index') }}"
                            >
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-users"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"
                                        />
                                        <path
                                            d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"
                                        />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path
                                            d="M21 21v-2a4 4 0 0 0 -3 -3.85"
                                        />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Pengguna</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ request()->is('plan*') ? 'active' : '' }}"
                        >
                            <a
                                class="nav-link"
                                href="{{ route('plan.index') }}"
                            >
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"
                                >
                                    <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        />
                                        <path
                                            d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"
                                        />
                                        <path
                                            d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"
                                        />
                                        <path d="M9 12l.01 0" />
                                        <path d="M13 12l2 0" />
                                        <path d="M9 16l.01 0" />
                                        <path d="M13 16l2 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Pelan</span>
                            </a>
                        </li>
                    @endcan
                </ul>
                <div
                    class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last"
                >
                    <form action="." method="get">
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="icon"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search…"
                                aria-label="Search in website"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
