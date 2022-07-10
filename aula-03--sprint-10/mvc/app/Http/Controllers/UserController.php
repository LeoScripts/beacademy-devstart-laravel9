<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateUserFormRequest;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function index()
    {

        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }
    public function show($id)
    {
        // dd("Id do usuário é {$id}");

        // uma forma tambem
        // $user = User::where('id', $id)->first();

        // busca de banco de dados apartir da versao 8 ou 9
        // $user = User::findOrFail($id);

        // exemplo de testes
        if(!$user = User::find($id))
            return redirect()->route('users.index');

        $title = 'Usuario '. $user->name;
        return view('users.show', compact('user','title'));

    }

    public function create( )
    {
        // dd('create');
        return view('users.create');
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        // dd($request->all());

        //iserindo dados no banco
        // $user = new User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        // validando se a imagem vier ele salva o caminho no banco
        // se nao vier e nao salvara e vai tudo dar certo
        if($request->image){
            $file = $request['image'];
            $path = $file->store('profile','public');
            $data['image'] = $path;
        }


        $this->model->create($data);

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        if(!$user = $this->model->find($id))
            return redirect()->route('users.index');

        return view('users.edit', compact('user'));
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {
        if(!$user = $this->model->find($id))
            return redirect()->route('users.index');

        $data = $request->only('name','email');
        if($request->password)
            $data['password'] = bcrypt($request->password);

        $user->update($data);

        return redirect("/users/{$id}");
    }

    public function destroy($id)
    {
        if(!$user = $this->model->find($id))
            return redirect()->route('users.index');
        $user->delete();

        return redirect()->route('users.index');
    }


}
