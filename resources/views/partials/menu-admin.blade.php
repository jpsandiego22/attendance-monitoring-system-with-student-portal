
<div class="az-header-menu">
    <div class="az-header-menu-header">
        <a href="{{route('admin.home')}}" class="az-logo"><span></span> portal</a>
        <a href="" class="close">&times;</a>
    </div><!-- az-header-menu-header -->
    <ul class="nav">
        <li class="nav-item {{ Route::is('admin.home') ? 'active show' : '' }}">
            <a href="{{route('admin.home')}}" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
        </li>
        <li class="nav-item {{ Route::is('user.*') ? 'active show' : '' }}">
            <a href="#" class="nav-link with-sub"><i class="typcn typcn-group"></i>Users </a>
            <nav class="az-menu-sub">
            <a href="{{route('user.register')}}" class="nav-link">Create</a>
            <a href="{{route('user.listview')}}" class="nav-link">List</a>
            <a href="{{route('user.listview')}}" class="nav-link text-primary">Import *.CSV Template</a>
            </nav>
        </li>
        <li class="nav-item {{ Route::is('admin.qr') ? 'active show' : '' }}">
            <a href="#" class="nav-link with-sub"><i class="typcn typcn-group"></i>QR </a>
            <nav class="az-menu-sub">
            <a href="{{route('qr.scanner')}}" class="nav-link">Qr Scanner</a>
            <a href="{{route('admin.qr')}}" class="nav-link">List</a>
            </nav>
        </li>
        <li class="nav-item">
            <a href="form-elements.html" class="nav-link"><i class="typcn typcn-download-outline"></i> Logs</a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i> Report</a>
            <div class="az-menu-sub">
            <div class="container">
                <div>
                <nav class="nav">
                    <a href="elem-buttons.html" class="nav-link">Student Logs</a>
                    <a href="elem-dropdown.html" class="nav-link">Faculty Logs</a>
                    <a href="elem-icons.html" class="nav-link">QR</a>
                </nav>
                </div>
            </div><!-- container -->
            </div>
        </li>
    </ul>
</div><!-- az-header-menu -->