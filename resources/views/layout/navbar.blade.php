<!-- Topbar -->
<nav CLASS="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" CLASS="btn btn-link d-md-none rounded-circle mr-3">
        <i CLASS="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->

    <div CLASS="input-group">
        <input type="text" CLASS="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div CLASS="input-group-append">
            <button CLASS="btn btn-primary" type="button">
                <i CLASS="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>


    <!-- Topbar Navbar -->
    <ul CLASS="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li CLASS="nav-item dropdown no-arrow d-sm-none">
            <a CLASS="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i CLASS="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div CLASS="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form CLASS="form-inline mr-auto w-100 navbar-search">
                    <div CLASS="input-group">
                        <input type="text" CLASS="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div CLASS="input-group-append">
                            <button CLASS="btn btn-primary" type="button">
                                <i CLASS="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li CLASS="nav-item dropdown no-arrow">

            @php
                $fb = new Facebook\Facebook([
                    'app_id' => '291068905736984',
                    'app_secret' => '6e16c113b403044180cd88649dc7473e',
                    'default_graph_version' => 'v2.10',
                ]);

                $helper = $fb->getRedirectLoginHelper();

                $permissions = ['public_profile,email,pages_show_list,pages_manage_posts,pages_read_engagement,pages_manage_metadata,pages_messaging,pages_messaging_subscriptions,read_page_mailboxes,user_posts,user_likes,user_status,user_friends'];
                $loginUrl = $helper->getLoginUrl('https://localhost:8081/public/fb-callback', $permissions);
            @endphp

            <a CLASS="nav-link dropdown-toggle" style="background:blue;color:white; font-size:15pt;height:30px;margin-left:15px " href="{{$loginUrl}}" role="button">
                <i class="fab fa-facebook-f" style="background:blue;color:white" width="50" aria-hidden="true"></i>
                Login
            </a>
            <!-- Dropdown - User Information -->
            <div CLASS="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a CLASS="dropdown-item" href="#">
                    <i CLASS="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a CLASS="dropdown-item" href="#">
                    <i CLASS="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a CLASS="dropdown-item" href="#">
                    <i CLASS="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div CLASS="dropdown-divider"></div>
                <a CLASS="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i CLASS="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
