@extends('template.users')
@section('title', 'Usuario')
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
                        <a href="#" class="btn btn-warning text-black">Editar</a>
                        <a href="#" class="btn btn-danger text-white">Excluir</a>
                    </td>
                </tr>
            </tbody>
        </table>
@endSection
