<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        // pegando todos os dados do banco
        $users = User::all();

        // mostra todas as informações
        // dd($users);

        // exibindo so os users em json
        // return $users;

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

    public function create()
    {

        // dd('create');
        return view('users.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // iserindo dados no banco
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('users.index');
    }

}