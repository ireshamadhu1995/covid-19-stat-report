<div class="nav-wrap">
    <div class="nav-wrap-inner d-flex d-lg-none">
        <span class="nav-menu">
            <i class="fas fa-bars"></i>
        </span>
        <div class="logo-wrap">
            <img src="{{asset('images/dashboard_image.png')}}" alt="logo" />
        </div>
    </div>
    
    <div class="dropdown ml-5">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="profile-name">{{ Auth::user()->name }}</span>
          
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>
</div>
