<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <!--
        !!!!!! ATENÇÃO !!!!!!

        se colocalocarmos o conteudo vindo do back com este documento em branco
        desta forma
        {{ $users }}

        ele exibira os nossos dados em jason
    -->


    <div class="container">
        <h1 class="bg-dark text-white p-3 mt-5 text-center">Listagem de Usuarios</h1>

        <table class="table">
            <thead>
                <tr class="text-center">
                  <th scope="col">ID</th>
                  <th scope="col">Nome</th>
                  <th scope="col">E-mail</th>
                  <th scope="col">Data de Cadastro</th>
                  <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- foreach da engine -->
                @foreach($users as $user)
                    <tr>
                      <th scope="row">{{ $user->id }}</th>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ date('d/m/Y - H:i:s', strtotime($user->created_at)) }}</td>
                      <td><a style="text-decoration: none;" href="{{ route('users.show', $user->id) }}" class="btn btn-primary">Visualizar</a></td>
                    </tr>
                @endForeach
            </tbody>
        </table>
    </div>
</body>
</html>
