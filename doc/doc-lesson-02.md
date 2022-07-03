# aula 02

## requerimentos
- composer
- php
- apache/ngix
- ide

## criando rota viacep

- `Route::get('viacep',[ViaCepController::class, 'index'])->name('viacep.index');`
- `php artisan make:controller ViaCepController` - comando para criação do controller 

```php
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\ViaCepController;

// melhorando a sitaxe 
use App\Http\Controllers\{
  UserController,
  ViaCepController
};
```

- criamos o metodo index dentro do controller
- api pega endereço [viacep](viacep.com.br/ws/65430000/json) neste caso estou usando o meu cep 65430-000


- apos criar as rotas novas limpar o cache com `php artisan optimize`

- `@csrf` - coloca como se fosse um token pra cada imput