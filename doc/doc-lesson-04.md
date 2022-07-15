# aula 04
sprint 11

- na UserController no methodo store fizemos o seguinte
```php
    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if($request->image){
            $file = $request['image'];
            $path = $file->store('profile','public');
            $data['image'] = $path;
        }

        $this->model->create($data);
     
        // // 1 exemplo de inserssao de flash messas   
        // $request->session()->flash('create', 'Usuario cadastrado com sucesso');
        // return redirect()->route('users.index');

        // este modelo usamos em update e destroy
        return redirect()->route('users.index')->with('create', 'Usuario criado com sucesso');
    }
```

modifiquei o template e na link da rota de regitro coloquei o link da rota de criação que eu criei
```php
    <li class="nav-item">
        <!-- <a class="nav-link" href="{{ route('register') }}">Cadastrar</a> -->
        <a class="nav-link" href="{{ route('users.create') }}">Cadastrar</a>
    </li>
```
e na view de index de users inseri nossas flash message
```php
        @if(session()->has('create'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Atenção</strong> {{ session()->get('create') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Atenção</strong> {{ session()->get('edit') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('destroy'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Atenção</strong> {{ session()->get('destroy') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
```

## execeptions

sao o retorno dado ao usuario 

- dentro de app/Execeptions/Handle.php dentro do methodo 
```php
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
        // coloquei pra teste
        // quando coloco uma rota que nao existe cai aqui
        dd('deu ruim'); 

        //  ATENÇÃO 
        // quando fiz isso e tentei dar o comando php artisan optimize
        // eu recebia a mesagem dentro do dd acima
    }
```
no metodo show da UserController fizemos algumas modificações pra testes
```php
    public function show($id)
    {
        // if(!$user = User::findOrFail($id))
        //     return redirect()->route('users.index');

        $user = User::findOrFail($id)
        $title = 'Usurio '.$user->name;

        return view('users.show', compact('user','title'));
    }
```
criei uma pasta `erros` dentro de resorces/views e dentro dela um arquibo 404.blade.php
```php
<h1>Exeception do Usuario</h1>

```
> a intenção e que quando desse erro o laravel procure este aquivo dentro desta pasta e exiba ele
>> pra min nao deu certo pro prof deu sim 

#### execeptions customizadas

- `php artisan make:exception UserControllerException` - cria um exception com o nome de UserControllerException

- na UserController fizemos o seguinte no metodo show
```php

public function show($id)
    {
        $user = User::find($id);
        // $title = 'Usuario '.$user->name;

        if($user){
            return view('users.show', compact('user'));
        }else{
            throw new UserControllerException('Usuario não encontrado');
        }

        // return view('users.show', compact('user','title'));
    }

```

nosso handle.php ficou assim no metodo register
```php
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $exception) {
            return response()->view('erros.404');
        });


        $this->renderable(function (UserControllerException $exception) {
            $message = $exception->getMessage();
            return response()->view('erros.not_found', compact('message'));
        });
    }
```
- criamos um view pra exibirmos na hora do retorno dentro da pasta erros com o nome de not_found.blade.php
```php
// personalizei e ficou assim
@extends('template.users')
@section('title', 'Listagem de Usuarios')
@section('body')

<div class="container d-flex flex-column " style="align-items: center;">
    <h1>UserControllerException | {{ $message }}</h1>
    <img src="https://cdn.dribbble.com/users/1208688/screenshots/4563859/no-found.gif" alt="">
</div>

@endSection

```
- ja nossa 404 ficou assim
```php
// <h1>not Foud  a nossa</h1>

//  eu personalizei e ficou assim
@extends('template.users')
@section('title', 'Listagem de Usuarios')
@section('body')

<div class="container d-flex flex-column " style="align-items: center;">
    <img width="500"  src="http://pid.famevaco.br/public/img/404_icon.gif" alt="">
    <h1 >Pagina nao encontrada</h1>
</div>

@endSection

```

