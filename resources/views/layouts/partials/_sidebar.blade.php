<style>
    .nav-item .sub-menu {
        display: none;
    }

    .nav-item:hover .sub-menu {
        display: block;
    }
</style>
<?php 
    $id = Auth::user()->userid;
    $joinedData = DB::connection('dohdtr')
                    ->table('users')
                    ->leftJoin('dts.users', 'users.userid', '=', 'dts.users.username')
                    ->where('users.userid', '=', $id)
                    ->select('users.section', 'users.division')
                    ->first();
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <div class="d-flex sidebar-profile">
        <div class="sidebar-profile-image">
          <img src="{{ asset('images/doh-logo.png') }}" alt="image">
          <span class="sidebar-status-indicator"></span>
        </div>
        <div class="sidebar-profile-name">
          <p class="sidebar-name">
            {{ Auth::user()->name }}
          </p>
          <p class="sidebar-designation">
            Welcome
          </p>
        </div>
      </div>
      <p class="sidebar-menu-title">Dash menu</p>
    </li>
    @if($joinedData->section == 105 || $id == 2760 || $id == 201400208 || $joinedData->section == 36 || $joinedData->section == 31)
        <ul class="nav flex-column" style=" margin-bottom: 0;">
            <li class="nav-item">
                <a class="nav-link" href="#">
                <i class="typcn typcn-group menu-icon"></i>
                    <span class="menu-title">Patients</span>
                    &nbsp;&nbsp;<i class="typcn typcn-arrow-sorted-down menu-icon"></i>
                </a>
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('home') }}">
                        <i class="typcn typcn-user-add-outline menu-icon"></i>
                        <span class="menu-title">Guarantee Letter</span>
                      </a>
                    </li>
                </ul>
            </li>
        </ul>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('facility') }}">
                <i class="typcn typcn-flow-switch menu-icon"></i>
                <span class="menu-title">Facility</span>
            </a>
        </li>
    @endif
  </ul>
  <ul class="sidebar-legend">
    <li>
      <p class="sidebar-menu-title">Category</p>
    </li>
    <li class="nav-item"><a href="#" class="nav-link">#Patients</a></li>
  </ul>
</nav>