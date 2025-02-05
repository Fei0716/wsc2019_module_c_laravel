@auth
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{route('event.index')}}">Event Platform</a>
        <span class="navbar-organizer w-100">{{Auth::user()->name}}</span>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <form action="{{route('logout')}}" method="post" enctype="multipart/form-data" id="form-logout" hidden>
                    @csrf
                </form>
                <a class="nav-link" id="logout"  onclick="document.getElementById('form-logout').submit()">Sign out</a>
            </li>
        </ul>
    </nav>
@endauth
