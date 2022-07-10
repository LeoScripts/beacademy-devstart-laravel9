# sprint-10
aula 15

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
        // pegando a imagem do request
        $file = $request['image'];
        // salvando  a imagem detro de storage/app/public/profile
        // e ja cria automaticamente o caminho da pasta que precisaremos pra usar na hora de exibir as imagens
        $path = $file->store('profile','public');
        // data na posição imagem  e voamos salvar no banco o path que e o caminho 
        $data['image'] = $path;

        $this->model->route('users.index');
```



