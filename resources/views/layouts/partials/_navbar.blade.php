{{-- <style>
  .navbar {
    background-image: url("{{ asset('images/maip_banner_2023_updated.png') }}") !important; /* Replace with the actual path or URL of your image */
    background-size: cover; /* Adjust the size as needed */
    background-repeat: no-repeat; /* Prevent repeating the image */
    /* You can also add other background properties like background-position if needed */
    background-color: #067536 !important;
  }
</style> --}}
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      {{-- <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('images/doh-logo.png') }}" style="width: 50px; height: 50px;" alt="logo"/>MAIF-IPP</a> --}}
      <a class="navbar-brand brand-logo" href="index.html">MAIF-IPP</a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo"/></a>
      <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
            <h5 class="mr-0">
                <i class="typcn typcn-user-outline" style="font-size: 1.5em;"></i>
                {{ Auth::user()->lname }}, {{ Auth::user()->fname }}
            </h5>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item">
            <i class="typcn typcn-cog text-primary"></i>
            Settings
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="typcn typcn-power text-primary"></i>
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="typcn typcn-th-menu"></span>
      </button>
    </div>
  </nav>