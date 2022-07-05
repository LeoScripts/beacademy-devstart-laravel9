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


## validação de formulario

cria um classe que faz a validação de dados
> colocamos o nome Store = salvar
                    Update = atualiza
                    Form = formulario
                    Request = esta no so request
- `php artisan make:request StoreUpdateUserFormRequest`
> sera criado o nosso arquivo dentro de Http/Requests

>> desta formar criamos as nossoas regras as explicações estao nos comentarios

```diff
-  ATENÇÃO 
+ REGRA DE NEGOCIO TRATAMOS NA CONTROLLER
```

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // autorizando o requeste dos usuarios
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

     //regras --------------------------
    public function rules()
    {

        // este e o ide que esta vindo do request
        // e se nao encontrar ele e vazio
        $id = $this->id ?? '';
        return [
            // nome = requerido, string, e etc
            'name' => 'required|string|max:50|min:3',

            'email' => [
                'require',
                'email',
                // unico , la no model users pega o email
                // pega o parametro id da coluna id
                'unique:users,email,{$id},id'
            ],

            // outro exemplo
            'password' => [
                'required',
                'min:4',
                'max:12'
            ]
        ];
    }
}
```

depois de criarmos as regras de validação criamos importamos ela pro nosso controller colocamos no metodos store 

> o laravel ja da pro template a variavel `$errors`
>> aproveitamos pra ultilizala muito chow

```php
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}
                <br>
            @endForeach
        </div>
    @endIf
```
