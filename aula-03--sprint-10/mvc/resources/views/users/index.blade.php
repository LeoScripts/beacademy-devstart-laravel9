@extends('template.users')
@section('title', 'Listagem de Usuarios')
@section('body')
        <h1 class="bg-dark text-white p-3 mt-5 text-center">Listagem de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuario</a>



                    <form action="" method="GET" class="my-3">
                        <div class="input-group">
                            <input type="search" class="form-control rounded" name="search">
                            <button type="submit" class="btn btn-outline-primary">pesquisar</button>
                        </div>
                    </form>



        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">Image</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Postagens</th>
                    <th scope="col">Data de Cadastro</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- foreach da engine -->
                @foreach($users as $user)
                    <tr>
                        @if($user->image)
                            <th>
                                <img src="{{ asset('storage/'.$user->image) }}" width="50px" height="50px" class="rounded-circle" alt="">
                            </th>
                        @else
                            <th>
                                <img src="{{ asset('storage/profile/avatar-pessoa.svg') }}" width="50px" height="50px" class="rounded-circle" alt="">
                            </th>
                        @endif
                      <th scope="row">{{ $user->id }}</th>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>
                      <a style="text-decoration: none;" href="{{ route('posts.show', $user->id) }}" class="btn btn-outline-primary">Postagens - {{ $user->posts->count() }}</a>
                      </td>
                      <td>{{ date('d/m/Y - H:i:s', strtotime($user->created_at)) }}</td>
                      <td><a style="text-decoration: none;" href="{{ route('users.show', $user->id) }}" class="btn btn-primary">Visualizar</a></td>
                    </tr>
                @endForeach
            </tbody>
        </table>
        <div class="justify-content-center pagination">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
@endSection
