@extends('template.users')
@section('title', 'Listagem de Postagens')
@section('body')
        <h1 class="bg-dark text-white p-3 mt-5 text-center">Listagem de Usuarios</h1>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">ID</th>
                    <th scope=>Usuario</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Postagem</th>
                    <th scope="col">Data de Cadastro</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- foreach da engine -->
                @foreach($posts as $post)
                    <tr>
                      <th scope="row">{{ $post->id }}</th>
                      <td>{{ $post->user->name }}</td>
                      <td>{{ $post->title }}</td>
                      <td>{{ $post->post }}</td>
                      <td>{{ date('d/m/Y - H:i:s', strtotime($post->created_at)) }}</td>
                    </tr>
                @endForeach
            </tbody>
        </table>
        <div class="justify-content-center pagination">
        </div>
@endSection
