@extends('template.users')
@section('title', 'Listagem de Postagens')
@section('body')
        <h1 class="bg-dark text-white p-3 mt-5 text-center">Listagem de Usuarios</h1>

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Postagem</th>
                    <th scope="col" >data de criação</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- foreach da engine -->
                @foreach($posts as $post)
                    <tr>
                      <th scope="row">{{ $post->id }}</th>
                      <td>{{ $post->title }}</td>
                      <td>{{ $post->post }}</td>
                      <td>{{ date('d/m/Y - H:i:s') }}</td>
                    </tr>
                @endForeach
            </tbody>
        </table>
        <div class="justify-content-center pagination">
        </div>
@endSection
