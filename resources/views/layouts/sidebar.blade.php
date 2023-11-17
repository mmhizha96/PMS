        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #8bbd3a">


            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="img/logo.jpeg" style="width: 80%" class="img-circle  elevation-2" alt="User Image">
                    </div>
                    {{-- <div class="info">
                        <a href="#" class="d-block">ADMIN</a>
                    </div> --}}
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link" style="color: #fff">

                                <svg width="24px" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg"
                                    fill="none">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path stroke="#fff" stroke-width="1.464"
                                            d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5ZM14 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V5ZM4 16a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3ZM14 13a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-6Z">
                                        </path>
                                    </g>
                                </svg>
                                <p>
                                    Dashboard

                                </p>
                            </a>
                        </li>
                        @if (Auth::user()->role_id == 1)
                            <li class="nav-item">
                                <a href="departments" class="nav-link" style="color: #fff">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Departments

                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="users" class="nav-link" style="color: #fff">
                                    <svg width="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M3 19H1V18C1 16.1362 2.27477 14.57 4 14.126M6 10.8293C4.83481 10.4175 4 9.30623 4 8.00001C4 6.69379 4.83481 5.58255 6 5.17072M21 19H23V18C23 16.1362 21.7252 14.57 20 14.126M18 5.17072C19.1652 5.58255 20 6.69379 20 8.00001C20 9.30623 19.1652 10.4175 18 10.8293M10 14H14C16.2091 14 18 15.7909 18 18V19H6V18C6 15.7909 7.79086 14 10 14ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z"
                                                stroke="#fff" stroke-width="1.9440000000000002" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    <p>
                                        Users

                                    </p>
                                </a>

                            </li>
                            <li class="nav-item has-treeview">
                                <a href="years" class="nav-link" style="color: #fff">
                                    <svg width="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M3 10C3 8.11438 3 7.17157 3.58579 6.58579C4.17157 6 5.11438 6 7 6H17C18.8856 6 19.8284 6 20.4142 6.58579C21 7.17157 21 8.11438 21 10H3Z"
                                                fill="#ffffff2A4157" fill-opacity="0.24"></path>
                                            <rect x="3" y="6" width="18" height="15" rx="2"
                                                stroke="#ffffff" stroke-width="1.2"></rect>
                                            <path d="M7 3L7 6" stroke="#ffffff" stroke-width="1.2"
                                                stroke-linecap="round">
                                            </path>
                                            <path d="M17 3L17 6" stroke="#ffffff" stroke-width="1.2"
                                                stroke-linecap="round">
                                            </path>
                                            <rect x="7" y="12" width="4" height="2" rx="0.5"
                                                fill="#ffffff"></rect>
                                            <rect x="7" y="16" width="4" height="2" rx="0.5"
                                                fill="#ffffff"></rect>
                                            <rect x="13" y="12" width="4" height="2" rx="0.5"
                                                fill="#ffffff"></rect>
                                            <rect x="13" y="16" width="4" height="2" rx="0.5"
                                                fill="#ffffff"></rect>
                                        </g>
                                    </svg>
                                    <p>
                                        Years

                                    </p>
                                </a>

                            </li>
                        @endif
                        @if (Auth::user()->role_id == 3)
                            <li class="nav-item has-treeview">
                                <a href="actualsToApprove" class="nav-link" style="color: #fff">
                                    <svg width="24px" h viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M13 3H8.2C7.0799 3 6.51984 3 6.09202 3.21799C5.71569 3.40973 5.40973 3.71569 5.21799 4.09202C5 4.51984 5 5.0799 5 6.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.0799 21 8.2 21H15.8C16.9201 21 17.4802 21 17.908 20.782C18.2843 20.5903 18.5903 20.2843 18.782 19.908C19 19.4802 19 18.9201 19 17.8V9M13 3L19 9M13 3V7.4C13 7.96005 13 8.24008 13.109 8.45399C13.2049 8.64215 13.3578 8.79513 13.546 8.89101C13.7599 9 14.0399 9 14.6 9H19M10 11.5H14V17.5L12 16.3094L10 17.5V11.5Z"
                                                stroke="#fff" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                    <p>
                                        Department Work

                                    </p>
                                </a>

                            </li>
                        @endif

                        @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                            <li class="nav-item has-treeview">
                                <a href="indicators" class="nav-link" style="color: #fff">
                                    <svg width="24px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"
                                        stroke-width="3.136" stroke="#fff" fill="none">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <circle cx="31.99" cy="19.36" r="5.41" stroke-linecap="round">
                                            </circle>
                                            <line x1="31.99" y1="24.77" x2="16.98" y2="56.89"
                                                stroke-linecap="round"></line>
                                            <line x1="31.99" y1="24.77" x2="47" y2="56.73"
                                                stroke-linecap="round"></line>
                                            <line x1="31.99" y1="7.11" x2="31.99" y2="13.95"
                                                stroke-linecap="round"></line>
                                            <line x1="17.2" y1="40.07" x2="47.02" y2="40.07"
                                                stroke-linecap="round"></line>
                                        </g>
                                    </svg>
                                    <p>
                                        Indicators

                                    </p>
                                </a>

                            </li>
                        @endif




                        <li class="nav-item">
                            <a href="#" class="nav-link" style="color: #fff">
                                <svg width="24px" viewBox="0 -0.5 25 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                    </g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M5.11413 8.35688C4.75894 8.56999 4.64377 9.03069 4.85688 9.38587C5.06999 9.74106 5.53069 9.85623 5.88587 9.64312L5.11413 8.35688ZM10.5 6L10.95 5.4C10.7061 5.21704 10.3756 5.19999 10.1141 5.35688L10.5 6ZM14.5 9L14.05 9.6C14.3236 9.80522 14.7014 9.79932 14.9685 9.58565L14.5 9ZM19.9685 5.58565C20.292 5.32689 20.3444 4.85493 20.0857 4.53148C19.8269 4.20803 19.3549 4.15559 19.0315 4.41435L19.9685 5.58565ZM17.75 19C17.75 19.4142 18.0858 19.75 18.5 19.75C18.9142 19.75 19.25 19.4142 19.25 19H17.75ZM19.25 11C19.25 10.5858 18.9142 10.25 18.5 10.25C18.0858 10.25 17.75 10.5858 17.75 11H19.25ZM9.75 19C9.75 19.4142 10.0858 19.75 10.5 19.75C10.9142 19.75 11.25 19.4142 11.25 19H9.75ZM11.25 11C11.25 10.5858 10.9142 10.25 10.5 10.25C10.0858 10.25 9.75 10.5858 9.75 11H11.25ZM13.75 19C13.75 19.4142 14.0858 19.75 14.5 19.75C14.9142 19.75 15.25 19.4142 15.25 19H13.75ZM15.25 14C15.25 13.5858 14.9142 13.25 14.5 13.25C14.0858 13.25 13.75 13.5858 13.75 14H15.25ZM5.75 19C5.75 19.4142 6.08579 19.75 6.5 19.75C6.91421 19.75 7.25 19.4142 7.25 19H5.75ZM7.25 14C7.25 13.5858 6.91421 13.25 6.5 13.25C6.08579 13.25 5.75 13.5858 5.75 14H7.25ZM5.88587 9.64312L10.8859 6.64312L10.1141 5.35688L5.11413 8.35688L5.88587 9.64312ZM10.05 6.6L14.05 9.6L14.95 8.4L10.95 5.4L10.05 6.6ZM14.9685 9.58565L19.9685 5.58565L19.0315 4.41435L14.0315 8.41435L14.9685 9.58565ZM19.25 19V11H17.75V19H19.25ZM11.25 19V11H9.75V19H11.25ZM15.25 19V14H13.75V19H15.25ZM7.25 19V14H5.75V19H7.25Z"
                                            fill="#fff"></path>
                                    </g>
                                </svg>
                                <p>
                                    Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('quarter_report') }}" class="nav-link" style="color: #fff">

                                        <p>
                                            Quarterly Reports

                                        </p>
                                    </a>

                                </li>
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('year_report') }}" class="nav-link" style="color: #fff">

                                        <p>
                                            Yearly Reports

                                        </p>
                                    </a>

                                </li>


                            </ul>
                        </li>




                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
