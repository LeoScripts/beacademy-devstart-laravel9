@extends('template.users')
@section('title', "Listagem de postagens do {$user->name}")
@section('body')
    <h1>Postagens do {{$user->name}}</h1>

    @foreach($posts as $post)
        <div class="border border-5 m-3 p-3 rounded">
            <label class="form-label"> <b>Identificação Nº</b> <br> {{ $post->id }} </label>
            <br>
            <label class="form-label"><b>Status </b> <br> {{ $post->active?'Ativo':'Inativo' }} </label>
            <br>
            <label class="form-label"> <b>Titulo:</b> <br> {{ $post->title }} </label>
            <br>
            <label class="form-label"><b>Postagens:</b> <be> </label>
            <textarea class="form-control" rows="3">{{ $post->post }} </textarea>
        </div>
    @endForeach

@endSection
