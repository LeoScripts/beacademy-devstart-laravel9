@extends('template.users')
@section('title', 'Novo Usuario')
@section('body')
    <h1 class="bg-dark text-white p-3 mt-5 text-center">Novo Usuario</h1>



    <form action="{{ route('users.store') }}" method="POST">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                    <br>
                @endForeach
            </div>
        @endIf
        <!-- o csrf é o nosso token e é obrigatorios -->
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="email">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
@endSection
