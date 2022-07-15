@extends('template.users')
@section('title', "Usuario {$user->name}")
@section('body')
<h1 class="bg-dark text-white p-3 mt-5 text-center">{{ $user->name }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}
                <br>
            @endForeach
        </div>
    @endIf

    <form action="{{ route('users.update', $user->id) }}" method="post">
        @method('PUT')
        <!-- o csrf é o nosso token e é obrigatorios -->
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{ $user->name }}">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Selecione uma imagem</label>
            <input type="file" name="image" id="image" class="form-control form control-md">
        </div>




        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endSection
