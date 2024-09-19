@extends('layouts.app')

@section('title', 'Home')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/globales.css">
    <link rel="stylesheet" href="/css/editar.css">
@endsection

@section('content')

    <div class="row contenedor">
        <div class="d-flex justify-content-star align-items-center mt-2">
            <a class="div-add w-100px d-flex flex-column justify-content-center align-items-center" href="/home">
                <img src="/images/atras.png" alt="" class="img-atras">
                <p class="fs-18px text-white">Atras</p>
            </a>
        </div>
    </div>
    <div class="row justify-content-center align-items-center mb-4">
        <div class="card col-10 col-sm-8 col-md-8 col-lg-8 col-xl-6" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
            <div class="row d-flex  justify-content-center align-items-center">
                <div class="col-10 my-4">
                    <h2 class="text-center mb-4">Editar Documento</h2>
                    <form id="formulario" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" id="fecha_inicio" name="id" value="{{ $documento->id }}">
                        <div class="form-group mb-3">
                            <label for="tipo_id">Tipo de Documento:</label>
                            <select name="tipo_id" class="form-control" id="tipo_id" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="nuevo">Crear Documento</option>
                                @foreach ($tipoDocumentos as $doc)
                                    <option {{ $documento->tipo_documento == $doc->nombre ? 'selected' : '' }} value="{{ $doc->nombre }}">{{ $doc->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">El tipo de documento es obligatorio</div>
                        </div>
                        <div class="form-group mb-3 ocultar" id="div-doc">
                            <label for="nombre_doc">Nombre del Documento:</label>
                            <input type="text" class="form-control" id="nombre_doc"
                                placeholder="Nombre del nuevo proyecto" name="nombre_doc" value="{{ old('nombre_doc') }}">
                            <div class="invalid-feedback">La cantidad de meses es obligatoria</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="proyecto_id">Razón Social:</label>
                            <select name="proyecto_id" class="form-control" id="proyecto_id" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="nuevo">Crear razón social</option>
                                @foreach ($proyectos as $proyecto)
                                    <option {{ $documento->proyecto == $proyecto->nombre ? 'selected' : '' }} value="{{ $proyecto->nombre }}">{{ $proyecto->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">La razón social es obligatorio</div>
                        </div>
                        <div class="form-group mb-3 ocultar" id="div-proyecto">
                            <label for="nombre_proyecto">Nombre de la razón social:</label>
                            <input type="text" class="form-control" id="nombre_proyecto"
                                placeholder="Nombre del nuevo proyecto" name="nombre_proyecto"
                                value="{{ old('nombre_proyecto') }}">
                            <div class="invalid-feedback">La razón social es obligatorio</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_inicio">Fecha Inicio:</label>
                            <input type="date" class="form-control" id="fecha_inicio"
                                placeholder="Ingresa fecha de inicio" name="fecha_inicio" value="{{ $documento->fecha_inicio }}"
                                required>
                            <div class="invalid-feedback">La fecha de inicio es obligatoria</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_fin">Fecha Fin:</label>
                            <input type="date" class="form-control" id="fecha_fin" placeholder="Ingresa fecha fin"
                                name="fecha_fin" value="{{ $documento->fecha_fin }}" required>
                            @error('fecha_inicio')
                                <p class="alerta-validacion">{{ $message }}</p>
                            @enderror
                            <div class="invalid-feedback">La fecha fin es obligatoria</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="meses_notificar">Cantidad de meses a notificar:</label>
                            <input type="number" class="form-control" id="meses_notificar" placeholder="Cantidad de meses"
                                name="meses_notificar" value="{{ $documento->meses_notificar }}" required>
                            <div class="invalid-feedback">La cantidad de meses es obligatoria</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="documento">Subir Documento:</label>
                            <input type="file" class="form-control" id="documento" placeholder="Cantidad de meses"
                                name="documento" value="{{ $documento->documento }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="3">{{ $documento->descripcion }}</textarea>
                        </div>
                        <button type="submit" style="width: 100%;" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>

        </div>

    </div>


@endsection

@section('script')
    <script src="/js/home/editar.js"></script>
@endsection
