@extends('layouts.app')

@section('title', 'Home')

@section('style')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/globales.css">
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>

    <div class="contenedor">
        <!-- Modal Nuevo Documento -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Crear Documento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="form-group mb-3">
                                <label for="tipo_id">Tipo de Documento:</label>
                                <select name="tipo_id" class="form-control" id="tipo_id" required>
                                    <option value="">-- Seleccionar --</option>
                                    <option value="nuevo">Crear Documento</option>
                                    @foreach($tipoDocumentos as $doc)
                                        <option value="{{ $doc->nombre }}">{{ $doc->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">El tipo de documento es obligatorio</div>
                            </div>
                            <div class="form-group mb-3 ocultar" id="div-doc">
                                <label for="nombre_doc">Nombre del Documento:</label>
                                <input type="text" class="form-control" id="nombre_doc" placeholder="Nombre del nuevo proyecto"
                                    name="nombre_doc" value="{{ old('nombre_doc') }}">
                                <div class="invalid-feedback">La cantidad de meses es obligatoria</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="proyecto_id">Razón Social:</label>
                                <select name="proyecto_id" class="form-control" id="proyecto_id" required>
                                    <option value="">-- Seleccionar --</option>
                                    <option value="nuevo">Crear razón social</option>
                                    @foreach($proyectos as $proyecto)
                                        <option value="{{ $proyecto->nombre }}">{{ $proyecto->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">La Razón social es obligatorio</div>
                            </div>
                            <div class="form-group mb-3 ocultar" id="div-proyecto">
                                <label for="nombre_proyecto">Nombre de la razón social:</label>
                                <input type="text" class="form-control" id="nombre_proyecto" placeholder="Nombre del nuevo proyecto"
                                    name="nombre_proyecto" value="{{ old('nombre_proyecto') }}">
                                <div class="invalid-feedback">La razón social es obligatoria</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fecha_inicio">Fecha Inicio:</label>
                                <input type="date" class="form-control" id="fecha_inicio" placeholder="Ingresa fecha de inicio"
                                    name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                <div class="invalid-feedback">La fecha de inicio es obligatoria</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="fecha_fin">Fecha Fin:</label>
                                <input type="date" class="form-control" id="fecha_fin" placeholder="Ingresa fecha fin"
                                    name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                                @error('fecha_inicio')
                                    <p class="alerta-validacion">{{ $message }}</p>
                                @enderror
                                <div class="invalid-feedback">La fecha fin es obligatoria</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="meses_notificar">Cantidad de meses a notificar:</label>
                                <input type="number" class="form-control" id="meses_notificar" placeholder="Cantidad de meses"
                                    name="meses_notificar" value="{{ old('meses_notificar') }}" required>
                                <div class="invalid-feedback">La cantidad de meses es obligatoria</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="documento">Subir Documento:</label>
                                <input type="file" class="form-control" id="documento" placeholder="Cantidad de meses"
                                    name="documento" value="{{ old('documento') }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="descripcion">Descripción:</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="3"></textarea>
                            </div>
                            <button type="submit" style="width: 100%;" class="btn btn-primary">Guardar cambios</button>
                            
                        </form>     
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Mostrar Documento --}}
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfViewer" src="" frameborder="0" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-center my-4">Todos los Documentos</h2>
        <div class="d-flex justify-content-end align-items-center mb-4" >
            <div class="open-modal div-add w-100px d-flex flex-column justify-content-end align-items-center" id="open-modal">
                <img src="/images/add.png" alt="" class="w-50px">
                <p class="fs-18px text-white">Nuevo</p>
            </div>
        </div>
        <table class="Tabla" id="documentosTable">
            <thead>
                <tr>
                    <th class="text-center">Tipo Documento</th>
                    <th class="text-center">Razón Social</th>
                    <th class="text-center">Fehca Inicio</th>
                    <th class="text-center">Fecha Fin</th>
                    <th class="text-center">descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($documentos as $doc)
                <tr>
                    <td class="text-center">{{ $doc->tipo_documento }}</td>
                    <td class="text-center">{{ $doc->proyecto }}</td>
                    <td class="text-center">{{ $doc->fecha_inicio }}</td>
                    <td class="text-center">{{ $doc->fecha_fin }}</td>
                    <td class="text-center">{{ $doc->descripcion }}</td>
                    <td class="acciones d-flex justify-content-evenly">
                        {{-- <a class="accion-registro" href="{{ Storage::url($doc->documento) }}" target="_blank">
                            <img src="/images/ojo.png" alt="">
                        </a> --}}
                        <a class="accion-registro" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#pdfModal" data-url="{{ Storage::url($doc->documento) }}">
                            <img src="/images/ojo.png" alt="">
                        </a>
                        <a class="accion-registro" href="/editarDocumento?id={{ $doc->id }}">
                            <img src="/images/ver.png" alt="">
                        </a>
                        <a class="accion-registro" href="" onclick="deleteDoc(event, {{$doc->id}})">
                            <img src="/images/delete.png" alt="">
                        </a>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script src="https://cdn.datatables.net/v/bs5/dt-2.1.6/datatables.min.js"></script>
    <script src="/js/home/home.js"></script>
@endsection
