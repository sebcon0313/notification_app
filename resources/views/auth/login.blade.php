@extends('layouts.app')

@section('title', 'Login')

@section('style')
    <link rel="stylesheet" href="/css/globales.css">
@endsection

@section('content')

      <div class="row justify-content-center align-items-center" style="height: 80vh">
        <div class="card col-10 col-sm-8 col-md-6 col-lg-4" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
            <div class="row card-body justify-content-center">
                <div class="col-10 my-4">
                    <h2 class="text-center mb-5">LOGIN</h2>
                    <form id="formulario" method="POST" class="needs-validation" action="{{ route('login.store') }}" novalidate>
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email">Correo:</label>
                            <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">El email es obligatorio</div>
                        </div>
                        <div class="form-group mb-5">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña" name="password" required>
                            <div class="invalid-feedback">La contraseña es obligatoria</div>
                            @error('message')
                                <p class="alerta-validacion">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" style="width: 100%;" class="btn-color">Iniciar Sesión</button>
                    </form>
                </div>
              </div>
        </div>
      </div>
    
@endsection

@section('script')
    <script src="/js/auth/login.js"></script>
@endsection
