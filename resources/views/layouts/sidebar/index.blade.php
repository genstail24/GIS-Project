<nav id="sidebar" class="active">
    <div class="sidebar-header text-dark">
        <h1>GIS Project</h1>
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="{{ route('home') }}"><i class="fas fa-map"></i>Map</a>
        </li>
        @if(Auth::user()->is_admin)
        <li>
            <a href="{{ route('disaster-categories.index') }}"><i class="fas fa-list"></i>Disaster Categories</a>
        </li>
        @endif
<!--         <li>
            <a href="#uielementsmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i> UI Elements</a>
            <ul class="collapse list-unstyled" id="uielementsmenu">
                <li>
                    <a href="ui-buttons.html"><i class="fas fa-angle-right"></i> Buttons</a>
                </li>
                <li>
                    <a href="ui-badges.html"><i class="fas fa-angle-right"></i> Badges</a>
                </li>
                <li>
                    <a href="ui-cards.html"><i class="fas fa-angle-right"></i> Cards</a>
                </li>
                <li>
                    <a href="ui-alerts.html"><i class="fas fa-angle-right"></i> Alerts</a>
                </li>
                <li>
                    <a href="ui-tabs.html"><i class="fas fa-angle-right"></i> Tabs</a>
                </li>
                <li>
                    <a href="ui-date-time-picker.html"><i class="fas fa-angle-right"></i> Date & Time Picker</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#authmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i> Authentication</a>
            <ul class="collapse list-unstyled" id="authmenu">
                <li>
                    <a href="login.html"><i class="fas fa-lock"></i> Login</a>
                </li>
                <li>
                    <a href="signup.html"><i class="fas fa-user-plus"></i> Signup</a>
                </li>
                <li>
                    <a href="forgot-password.html"><i class="fas fa-user-lock"></i> Forgot password</a>
                </li>
            </ul>
        </li> -->
    </ul>
</nav>