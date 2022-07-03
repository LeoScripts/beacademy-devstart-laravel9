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

## migration

- `php artisan make:controller NOME_DO_CONTROLLER` - cria um controller
- `php artisan make:migration NOME_DA_MIGRATION` - cria uma migration
- `php artisan migrate` - cria noss tabela no banco

## seeders
com eles podemos popular nossa tabela com dados fake
ou seja moca dados.

- `php artisan db:seed` - executa o seeders e cria dados fake
> por e esses dados vem de dentro de factory/UserFactory.php
- `php artisan make:seeder AddressesSeeder` - criando nosso seed
- `php artisan make:factory AddressesSeeder` - criando nosso factory
- `php artisan make:model Address` - criando nosso model
- `php artisan db:seed` - excuta o seed no banco de dados

