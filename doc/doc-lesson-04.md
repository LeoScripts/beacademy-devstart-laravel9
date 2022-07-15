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
     
        // // 1 exemplo de inserssao de flash messas   
        // $request->session()->flash('create', 'Usuario cadastrado com sucesso');
        // return redirect()->route('users.index');

        // este modelo usamos em update e destroy
        return redirect()->route('users.index')->with('create', 'Usuario criado com sucesso');
    }
```

modifiquei o template e na link da rota de regitro coloquei o link da rota de criação que eu criei
```php
    <li class="nav-item">
        <!-- <a class="nav-link" href="{{ route('register') }}">Cadastrar</a> -->
        <a class="nav-link" href="{{ route('users.create') }}">Cadastrar</a>
    </li>
```
e na view de index de users inseri nossas flash message
```php
        @if(session()->has('create'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Atenção</strong> {{ session()->get('create') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Atenção</strong> {{ session()->get('edit') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('destroy'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Atenção</strong> {{ session()->get('destroy') }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
```

