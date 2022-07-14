<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <title>@yield('title')</title>
</head>
<body>

    <div class="container">
        <nav class="d-flex gap-3">
            <a class="btn nav-link" href="/users">Usuarios</a>
            <a class="btn nav-link" href="/posts">Postagens</a>
        </nav>
        <div class="col-2">
            <ul class="navbar-nav mr-auto">
                @if(Auth::user())
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{Auth::user()->name}}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit">sair</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                    </li>
                @endif
            </ul>
        </div>

            @yield('body')

    </div>
</body>
</html>
