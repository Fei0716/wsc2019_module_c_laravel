@extends('layout.main')

<div class="container-fluid">
    <div class="row">
        <main class="col-md-6 mx-sm-auto px-4">
            <div class="pt-3 pb-2 mb-3 border-bottom text-center">
                <h1 class="h2">WorldSkills Event Platform</h1>
            </div>

            <form class="form-signin" action="{{route('login')}}" enctype="multipart/form-data" method="post">
                @csrf
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                @if(Session::has('error'))
                    <div class="alert alert-danger py-2 text-center">
                        {{Session::get('error')}}
                    </div>
                @elseif(Session::has('success'))
                    <div class="alert alert-success py-2 text-center">
                        {{Session::get('success')}}
                    </div>
                @endif
                <label for="inputEmail" class="sr-only">Email</label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
                <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Sign in</button>
            </form>

        </main>
    </div>
</div>
</body>
</html>


