@extends('template.users')
@section('title', $title)
@section('body')
        <h1 class="bg-dark text-white p-3 mt-5 text-center">{{ $user->name }}</h1>

        <table class="table">
            <thead class="text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Data de Cadastro</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ date('d/m/Y - H:i:s', strtotime($user->created_at)) }}</td>
                    <td>

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning text-black">Editar</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger text-white">Excluir</button>
                        </form>

                    </td>
                </tr>
            </tbody>
        </table>
@endSection
