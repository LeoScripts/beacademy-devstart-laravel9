# aula 04
sprint 11

- na UserController no methodo store fizemos o seguinte
```php
    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if($request->image){
            $file = $request['image'];
            $path = $file->store('profile','public');
            $data['image'] = $path;
        }

        $this->model->create($data);
        // return redirect()->route('users.index');

        // linha inserida
        return session()->flash('create', 'Usuario cadastrado com sucesso');
    }
```

e na view de create inseri nossa flash message
```php
    @if(session()->has('create'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    //<h1 .................
```
modifiquei o template e na link da rota de regitro coloquei o link da rota de criação que eu criei
```php
    <li class="nav-item">
        <!-- <a class="nav-link" href="{{ route('register') }}">Cadastrar</a> -->
        <a class="nav-link" href="{{ route('user.create') }}">Cadastrar</a>
    </li>
```
