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
```diff
- ATENÇÃO
- este erro acontece pois esta havendo um erro no laravel nos testes
! apos modificar o .env nossa variavel APP_LOCAL  de local para testing perdi os dados do banco
! como seu eu tivesse feito um migrate:rollback e depois desse um migrate novamente
+ a boa noticia e que nao perdi o banco e nem as tabelas
```
```
APP_NAME=Laravel
APP_ENV=testing
APP_KEY=base64:eEk3Uw/ZtWrths4AgqTYgj0mZ2mX0NFtL4FTZGp8yIY=
APP_DEBUG=true
APP_URL=http://localhost
```
- a serguir criamos no primeiro teste `php artisan make:test UserTest`
- acessao a pasta de tests/Feature e abrimos o noss UserTest.php

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // colocamos aqui o nosso teste de exemplo de / para /users
        $response = $this->get('/users');

        $response->assertStatus(200);
    }
}
```
- e logo executamos os testes com `php artisan test` e ja recebemos alguns passando e outros não
- depois apagamos o arquivo example.php da pasta test ja pasta Unit remoneiamos para UserTest.php
- depois de renomeiamos o aquivo e classe dentro dele executamos `composer dump-autoload` ATENÇÃO SEMPRE FAZER ISSO QUANDO PROCEDER DESTA FORMA

> Unit/UserTest.php
```php
<?php

namespace Tests\Unit;

use PHP\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_example()
    {
        $this->assertTrue(true);
    }
}

```

> tests/Feature/UserTest.php
```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }
}

```
- depois removemos a pasta Auth de dentro da pasta Feature

- agora criando nosso codigo de teste
> em Feature/UserTest.php
>> eu estava recebendo um erro devido o Userfactory nao estar passando uma imagem ei so cololoquei la o campo image e ja foi
```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user()
    {

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '123456',
            'image' => 'imagem_defalt'
        ]);

        // verificando se o  usuario esta logado
        $this->actingAs($user);

        $response = $this->get('/users');

        $response->assertStatus(200);
    }
}

```

logo apos fizemos mais alguns testes

> acrentamos dentro do UserTest da pasta Feature mais este teste
```php
    public function test_create_user()
    {
        $response = $this->post('/login/crate', [
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => '123456789',
            'is_admin' => '1',
        ]);

        $response->assertStatus(200);
    }
```
> e este dentro da pasta Unit no nosso UserTest

```php
    public function test_create_user()
    {
        $this->assertTrue(true);
    }
```

```diff
- ATENÇÃO
! é importante frisar que nos meus testes os itens estavam sim sendo criados no banco de dados

+ testes: 4 passed
time: 0.30s
```

## Reaproveitamento de codigo
- dentro da pasta app criamos uma outa pasta chamada de helpers geralmente, so que pra ser mais rapido usamos somente um arquivo com este nome dentra da pasta app.

e nosso helpers.php ficou assim
```php

function formatDateTime($dateTime)
{
    // carbon - trata as datas
    // createFromFormat - formato que vem do banco de dados
    // format transforma - pra nossa data
    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->format('d/m/Y - H:i:s');
}

function formatMoney($money)
{
    // str_replace - vai remover os pontos e deixar limpo o nosso valor($money)
    $clean_money = str_replace('.','', $money);

    // number_format = a cada 2 posições adicina uma virgula(,)
                    // se for casa milenar(mil) coloca um ponto(.)
    return 'R$ '.number_format($clean_money,2,',','.');
}

```
- tambem acrecentamos uma configuração no composer.json dentro de autoload
```json
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "files": [
            //normalmente seria assim mas como so criamos o arquivo so pra testes
            //"app/Helpers/helpers.php"
            // ficou assim 
            "app/helpers.php"
        ]
    },
```
- apos as modificações rodamos o `composer dump-autoload ` pra ele reiniciar nosso composer
> e muito importante rodar este comando

- dentro de pasta de view users abrimos o index e modificamos para
> no nosso td que retorna a hora passamos a usar uma função do nosso helper
```php
// antes
// <td>{{ date('d/m/Y - H:i:s', strtotime($user->created_at)) }}</td>
// o agora
<td>{{ formatDateTime($user->created_at) }}</td>  

// tambem inserimos um td so pra testar nossa função helper de preço
<td>{{ formatMoney(5000.00) }} </td>

```