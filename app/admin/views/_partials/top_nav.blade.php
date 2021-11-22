@if(AdminAuth::isLogged())
    <header class="sticky top-0 bg-white border-b border-gray-200 z-30" role="navigation">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex">
                    <span>{!! Template::getHeading() !!}</span>
                </div>
                <div class="flex items-center">
                    <button
                        type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navSidebar"
                        aria-controls="navSidebar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                    </button>

                    {!! $this->widgets['mainmenu']->render() !!}
                </div>
            </div>
        </div>
    </header>
@endif
