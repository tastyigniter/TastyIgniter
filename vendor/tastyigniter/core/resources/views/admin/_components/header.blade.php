@if(AdminAuth::isLogged())
    <header {{ $attributes->merge(['class' => 'navbar navbar-top navbar-expand border-bottom'])}}>
        <div class="container-fluid">
            <div class="navbar-brand d-flex">
                <button
                    class="nav-link px-3 ms-n2 d-lg-none"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <i class="fa fa-bars"></i>
                </button>
                <a class="logo" href="{{ admin_url('dashboard') }}">
                    <img
                        class="logo-svg"
                        src="{{$site_logo !== 'no_photo.png' ? media_url($site_logo) : asset('vendor/igniter/images/favicon.svg')}}"
                        alt="{{$site_name}}"
                    />
                </a>
            </div>

            <div class="navbar navbar-right py-2 pe-lg-0">
                {{ $slot }}
            </div>
        </div>
    </header>
@endif
