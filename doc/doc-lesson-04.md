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

## testes

o laravel ja possui instalado o php unit test
> `phpunit.xml` - aquivo de configuração dos testes

- `php artisan test` - executa os testes
- `php artisan make:test UserTest` -  cria um novo teste com o nome de UserTest

- no arquivo de configuração dos testes decomentamos duas linhas
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    <coverage processUncoveredFiles="true">
        <include>
            <directory suffix=".php">./app</directory>
        </include>
    </coverage>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/> <!-- linha descomentada -->
        <env name="DB_DATABASE" value=":memory:"/> <!-- linha descomentada -->
        <env name="MAIL_MAILER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>

```
no .env em APP_ENV trocamos de `local` para `testing`
```
APP_NAME=Laravel
APP_ENV=testing
APP_KEY=base64:eEk3Uw/ZtWrths4AgqTYgj0mZ2mX0NFtL4FTZGp8yIY=
APP_DEBUG=true
APP_URL=http://localhost
```
