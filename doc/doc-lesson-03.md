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
        // pegando todos os dados do banco e exibindo apenas 5 itens
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

## relacionamento 1 para muitos (1 para N)

- `php artisan make:model post -m` - cria um model e uma migration com nome de post

dentro da nossa migration fizemos a seguinte configuração

```php 

    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // pegando o id do usuario e tranformando  uma foreign key dentro da tabela de posts
            $table->foreignId('user_id')
            // dizendo que o campo e contraint
            ->constrained('users')
            // tirando os vinculos de tabelas
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            // criando os campos
            $table->string('title');
            $table->text('post');
            // campo que diz se o post esta ativo ou nao
            $table->boolean('active')->default(true);
            // nosso querido created_at e updatade_at
            $table->timestamps();
        });
    }
```

apos termos criado nossi migrate demos o comando `php artisan migrate` que cria nossa tabela no banco

na ´model de user´  criamos um metodo chamado posts como abaixo

```php
    public function posts()
    {
        //hasMany  de um para muitos
        return $this->hasMany(Post::class);
    }
```

ja na nossa model post fizemos o seguinte
```php
    public function user()
    {
        // belongsTo de muitos para um
        return $this->belongsTo(User::class);
    }
```

agora criamos a nossa controller `php artisan make:controller PostController` e fizemos a configuração abaixo


```php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    User,
    Post
};

class PostController extends Controller
{
    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function index($userIS)
    {
        // pra testar
        // dd($this->user->find($userId))

        if(!$user = $this->user->find($userId)) {
            // back volta pra telas que estavamos antes
            return redirect()->back();
        }

        $posts = user->posts()->fet();

        return view('posts.index', compact('user','posts'));
    }
}

```

depois criamos nossa rota web.php

`Route::get('/posts',[PostController::class, 'index'])-name('posts.index');`

-  criamos a pasta de post dentro das views e o arquivo index.blade.php e compiamos o conteudo da index dos users

- criamos um seeder pra criar alguns os posts de testes `php artisan make:seeder PostSeeder` e fazemos a seguinte configuração

```php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pegando models e criando 30 posts fake
        \App\Models\Post::factory(30)->create();
    }
}

```

- `php artisan make:factory PostFactory` - depois criamos a PostFactory.php dentrode database/factories

```php
amespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'title' => $this->faker->title(),
            'post' => $this->faker->text(),
            'active' => true
        ];
    }
}

```
depois executamos `php artisan db:seed PostSeeder` pra criar 