# aula 01

## requerimentos
- composer
- php
- apache/ngix
- ide


## instalando o laravel
```bash
# create project
composer create-project laravel/laravel meu-app-laravel

# rodar o servidor
php artisan serve

# pra visualisar e so acessar
# http://127.0.0.1:8000
```

## comando `php artisan list`
exibe toda lista de comandos possiveis com o php artisan

-`php artisan -h` -  helper
-`php artisan optimize` -  limpa cache

## projeto e explicações
- controlers
- views
- routes
- .gitignore
- .env

## Criando rotas e controller
- criando rota de teste dentro de routes/web.php

```php
# rota sem parametro
Route::get('/home', function () {
    echo 'esta e a home';
});

## rota com paramentro
Route::get('/users/{nome}', function ($nome) {
    echo "oi meu nome é {$nome}";
});
```
criando o controle pelo terminal usando o comando php artisan
```bash
php artisan make:controller UserController
```
agora na routes/web.php inserimos o namespace do nosso UserController

```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // este aqui

// usando o UserController e usando o metodo index  -> nomeando nossa rota
                                                    // caso seja nessesario mudar o caminho da rota 
                                                    // com a rota nomeado so precisamos mudar o caminho na rota e pronto
                                                    // caso nao esteja nomeada teremos de ir mudando de arquivo em arquivo
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
```

- no UserController
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // nosso metodo
    public function index()
    {
        // nosso array 
        $users = [
            'nome' => ['José Lira','João Lira'];
        ];

        // nosso dd
        dd($users);
    }

    public function show($id)
    {
        // exibindo o id passado como parametro
        dd("Id do usuário é {$id}");
    }
}
```

- `dd()` - e a abreviação do var_dum e do die() -> ou seja quando nos damos um dd() ele executa o dump e depois ele encera a aplicação com o die() , e aconcelhado usar este metodo sempre no final da execução pois tudo que estiver abaixo dele nao sera executado