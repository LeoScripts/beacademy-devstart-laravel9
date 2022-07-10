# sprint-10

## image => recebendo , salvaldo, criando o caminho e exebindo 

- criamos um migrate pra inserir a foto do usuario (migrate => add_field_image_to_users_tabl) 
> neste exemplo fizemos desta forma simulando um edição em um banco ja em produção
```bash
php artisan make:migration add_field_image_to_users_table
```

```php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // a aqui criamos o campo image dentro da tabela users
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // se tivermos problemas destruimos o campo image da tabela users
            $table->dropColumn('image');
        });
    }
};

```
- `php artisan migrate` - execumos nossa migrate no banco de dados
> se der tudo certo teremos nosso campo image na tabela users do nosso banco

- `php artisan migrate:rollback` - pra reverter e remover o campo colocado (caso seja necessario)

- insertimos o campo nas views create e edit(update) desta forma
```html
        <div class="mb-3">
            <label for="image" class="form-label">Selecione uma imagem</label>
            <input type="file" name="image" id="image" class="form-control form control-md">
        </div>
```

colocamos a validação pra recerber imagens

> mais deu erro por que devemos comolocar o `enctype="multipart/form-data"` na tag form pra enviar aquivos ele e obrigatorio

>> depois coloque o campo image dentro da model users

- adicionamos as linhas abaixo dentro do metondo store de usersController antes da instrução create
```php
        // pegando a imagem do request
        $data['image'] = $request['image'];
        // salvando  a imagem detro de storage/app/public/profile
        $data['image']->store('profile','public');
```

- criamos um link simbolico pra com o caminho da imagem pra usar no nosso projeto com o comando `php artisan storage:link`

> e com isso fazendo com que a imgagem seja publica, no exemplo abaixo podemos ver como ficara o caminho de nossas images , neste caso usei o nome da imagem `nFMDjzqrHS6ydbU0cD9hKSmliOHKEL06KATEmxen.jpg`

>> localhost:8000/storage/profile/nFMDjzqrHS6ydbU0cD9hKSmliOHKEL06KATEmxen.jpg

- agora vamos salvar o caminho no banco tambem, dentro da controller no metodo em questao fizemos a seguite configuração, modificamos os nomes ateriores

```php
        // validando se a imagem vier ele salva o caminho no banco
        // se nao vier e nao salvara e vai tudo dar certo
        if($request->image){
        // pegando a imagem do request
        $file = $request['image'];
        // salvando  a imagem detro de storage/app/public/profile
        // e ja cria automaticamente o caminho da pasta que precisaremos pra usar na hora de exibir as imagens
        $path = $file->store('profile','public');
        // data na posição imagem  e voamos salvar no banco o path que e o caminho 
        $data['image'] = $path;

        $this->model->route('users.index');

         
        
        }
```
OBSERVAÇÃO EU NAO UTILIZEI O IF DO CODIGO ACIMA SOMENTE O QUE ESTA DENTRO FOI USANDO POIS PRA MIN ESTAVA DANDO ERRO

VALIDEI COLOCANDO UMA CONDIÇÃO NAS VALIDAÇÕES DA PASTA APP/HTTP/REQUESTES ONDE A IMAGEM E REQUERIDA OU SEJA OBRIGATORIA

## paginação

- criamos alguns usarios de teste com o comando `php artisan db:seed` - se nao der certo crie na mao mesmo

dentro do metodo index na controller de user fizemos a seguinte configuração

```php
    public function index()
    {
        // pegando todos os dados do banco e exibindo apenas 5
        $users = User::paginate(5);

        // mostra todas as informações
        // dd($users);

        // exibindo so os users em json
        // return $users;

        return view('users.index', compact('users'));
    }
```
e no depois de table la na pagina de exibição inserimos nossa paginação

```php
// </table>

// exibindo os links de paginação so que aqui ficou um pouco quebrado
//{{ $users->links() }}

// neste outro exemplo usamos os atributos do frameword de css que estamos usando que é o Bootstrap
// so que na versao 4 pois e a que esta disponivel no momento
// os links so vao aptarecer se extirem mais de uma paginas
{{ $users->links('pagination::bootstrap-4') }} 
```