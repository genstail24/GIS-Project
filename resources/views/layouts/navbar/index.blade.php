<nav class="navbar navbar-expand-lg navbar-white bg-white">
    <button type="button" id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i><span></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <!-- <li class="nav-item dropdown">
                <div class="nav-dropdown">
                    <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-link"></i> <span>Quick Access</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                        <ul class="nav-list">
                            <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                        </ul>
                    </div>
                </div>
            </li>
 -->            
            <li class="nav-item dropdown">
                <div class="nav-dropdown">
                    <a href="" class="nav-item nav-link dropdown-toggle text-secondary" data-toggle="dropdown"><i class="fas fa-user"></i> <span>{{ Auth::user()->name }}</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i></a>
                    <div class="dropdown-menu dropdown-menu-right nav-link-menu">
                        <ul class="nav-list">
                            <!-- <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                            <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                            <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li> -->
                            <!-- <div class="dropdown-divider"></div> -->
                            <li>
                                <form action="{{ route('logout')}}" method="POST" class="dropdown-item mt-3">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> 
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>