@extends('layouts.app')

@section('title', 'Register')

@section('style')
    <link rel="stylesheet" href="/css/globales.css">
@endsection

@section('content')

    <div class="row justify-content-center align-items-center" style="height: 90vh;">
        <div class="card col-10 col-sm-8 col-md-6 col-lg-4" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
            <div class="row card-body justify-content-center">
                <div class="col-10 my-4">
                    <h2 class="text-center mb-5">REGISTRAR</h2>
                    <form id="formulario" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre Completo:</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingresa tu nombre"
                                name="name" value="{{ old('name') }}" required>
                            <div class="invalid-feedback">El nombre es obligatorio</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Correo:</label>
                            <input type="email" class="form-control" id="email" placeholder="Ingresa tu email"
                                name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">El email es obligatorio</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña"
                                name="password" value="{{ old('password') }}" required>
                            <div class="invalid-feedback">La contraseña es obligatoria</div>
                        </div>
                        <div class="form-group mb-5">
                            <label for="password_confirmation">Confirmar Contraseña:</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                placeholder="Confirma tu contraseña" name="password_confirmation"
                                value="{{ old('password_confirmation') }}" required>
                            @error('password')
                                <p class="alerta-validacion">{{ $message }}</p>
                            @enderror
                            <div class="invalid-feedback pass-reg-2">La contraseña es obligatoria</div>
                        </div>
                        <button type="submit" style="width: 100%;" class="btn-color">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="/js/auth/register.js"></script>
@endsection
