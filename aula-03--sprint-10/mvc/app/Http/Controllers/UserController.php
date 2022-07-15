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
    public function index(Request $request)
    {
        $users = $this->model->gerUsers(
            $request->search ?? ''
        );
        return view('users.index', compact('users'));
    }
    public function show($id)
    {
        $team = \App\Models\Team::find(1);
        $team->load('users');

        return $team;
    }

    public function create( )
    {
        return view('users.create');
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if(!$request->image)
            $data['image'] = 'profile/avatar.png';

        $file = $request['image'];
        $path = $file->store('profile','public');
        $data['image'] = $path;


        $this->model->create($data);
        return redirect()->route('users.index');

        // return session()->flash('create', 'Usuario cadastrado com sucesso');
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

    public function admin()
    {
        return view('admin.index');
    }


}
