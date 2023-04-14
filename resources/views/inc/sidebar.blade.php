@if (
    $page_name != 'coming_soon' &&
        $page_name != 'contact_us' &&
        $page_name != 'error404' &&
        $page_name != 'error500' &&
        $page_name != 'error503' &&
        $page_name != 'faq' &&
        $page_name != 'helpdesk' &&
        $page_name != 'maintenence' &&
        $page_name != 'privacy' &&
        $page_name != 'auth_boxed' &&
        $page_name != 'auth_default')

    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">

        <nav id="sidebar">
            <div class="shadow-bottom"></div>

            <ul class="list-unstyled menu-categories" id="accordionExample">

                @if ($page_name != 'alt_menu' && $page_name != 'blank_page' && $page_name != 'boxed' && $page_name != 'breadcrumb')
                    @hasanyrole('editor|admin|viewer')
                        <li class="menu {{ $category_name === 'dashboard' ? 'active' : '' }}">
                            <a href="/dashboard" data-active="{{ $category_name === 'dashboard' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'locations' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Dashboard</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu {{ $category_name === 'domain' ? 'active' : '' }}">
                            <a href="#app" data-active="{{ $category_name === 'domain' ? 'true' : 'false' }}"
                                data-toggle="collapse" aria-expanded="{{ $category_name === 'apps' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Domain</span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </a>
                            <ul class="collapse submenu list-unstyled {{ $category_name === 'domain' ? 'show' : '' }}"
                                id="app" data-parent="#accordionExample">
                                <li class="{{ $page_name === 'domain' ? 'active' : '' }}">
                                    <a href="/domain/index"> Domain List </a>
                                </li>
                                <li class="{{ $page_name === 'news' ? 'active' : '' }}">
                                    <a href="/news/index"> News Link </a>
                                </li>
                            </ul>
                        </li>


                        <li class="menu {{ $category_name === 'locations' ? 'active' : '' }}">
                            <a href="/locations/index"
                                data-active="{{ $category_name === 'locations' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'locations' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Locations</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu {{ $category_name === 'polling' ? 'active' : '' }}">
                            <a href="/polling/index" data-active="{{ $category_name === 'polling' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'polling' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Polling</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu {{ $category_name === 'topics' ? 'active' : '' }}">
                            <a href="/topics/index" data-active="{{ $category_name === 'topics' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'topics' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Topics</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu {{ $category_name === 'viewUsers' ? 'active' : '' }}">
                            <a href="/view-users" data-active="{{ $category_name === 'viewUsers' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'viewUsers' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>View Users</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu {{ $category_name === 'post-block' ? 'active' : '' }}">
                            <a href="/post-blocks" data-active="{{ $category_name === 'post-block' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'post-block' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Post by blocks</span>
                                </div>
                            </a>
                        </li>
                        <li class="menu {{ $category_name === 'post' ? 'active' : '' }}">
                            <a href="{{ route('post') }}" data-active="{{ $category_name === 'post' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'post-block' ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <div class="">
                                    <span>Post</span>
                                </div>
                            </a>
                        </li>
                        <li class="menu {{ $category_name === 'logs' ? 'active' : '' }}">
                            <a href="{{ route('logs') }}" data-active="{{ $category_name === 'logs' ? 'true' : 'false' }}"
                                aria-expanded="{{ $category_name === 'logs' ? 'true' : 'false' }}" class="dropdown-toggle">
                                <div class="">
                                    <span>Logs</span>
                                </div>
                            </a>
                        </li>
                    @endhasanyrole
                @else
                    <li class="menu {{ $category_name === 'starter_kits' ? 'active' : '' }}">
                        <a href="#starter-kit" data-toggle="collapse"
                            aria-expanded="{{ $category_name === 'starter_kits' ? 'true' : 'false' }}"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal">
                                    <polyline points="4 17 10 11 4 5"></polyline>
                                    <line x1="12" y1="19" x2="20" y2="19"></line>
                                </svg>
                                <span>Starter Kit</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ $category_name === 'starter_kits' ? 'show' : '' }}"
                            id="starter-kit" data-parent="#accordionExample">
                            <li class="{{ $page_name === 'blank_page' ? 'active' : '' }}">
                                <a href="/starter-kit/blank_page"> Blank Page </a>
                            </li>
                            <li class="{{ $page_name === 'breadcrumb' ? 'active' : '' }}">
                                <a href="/starter-kit/breadcrumbs"> Breadcrumb </a>
                            </li>
                            <li class="{{ $page_name === 'boxed' ? 'active' : '' }}">
                                <a href="/starter-kit/boxed"> Boxed </a>
                            </li>
                            <li class="{{ $page_name === 'alt_menu' ? 'active' : '' }}">
                                <a href="/starter-kit/alternative_menu"> Alternate Menu </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="javascript:void(0);" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span> Menu 1</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay">
                                    <path
                                        d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                    </path>
                                    <polygon points="12 15 17 21 7 21 12 15"></polygon>
                                </svg>
                                <span> Menu 2</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="submenu" data-parent="#accordionExample">
                            <li>
                                <a href="javascript:void(0);"> Submenu 1 </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"> Submenu 2 </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu">
                        <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                    <polyline points="13 2 13 9 20 9"></polyline>
                                </svg>
                                <span> Menu 3</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="submenu2" data-parent="#accordionExample">
                            <li>
                                <a href="javascript:void(0);"> Submenu 1 </a>
                            </li>
                            <li>
                                <a href="#sm2" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle"> Submenu 2 <svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="sm2"
                                    data-parent="#submenu2">
                                    <li>
                                        <a href="javascript:void(0);"> Sub-Submenu 1 </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"> Sub-Submenu 2 </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"> Sub-Submenu 3 </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>

        </nav>

    </div>
    <!--  END SIDEBAR  -->

@endif
