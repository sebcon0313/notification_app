<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function viewHome()
    {
        $proyectos = Proyecto::all();
        $tipoDocumentos = TipoDocumento::all();

        //Consulta para mostrar todos los documentos
        $documentos = DB::table('documento as d')
            ->join('tipo_documento as td', 'td.tipo_id', '=', 'd.tipo_id')
            ->join('proyecto as p', 'p.proyecto_id', '=', 'd.proyecto_id')
            ->select('d.documento_id as id', 'td.nombre as tipo_documento', 'p.nombre as proyecto', 'd.fecha_inicio', 'd.fecha_fin', 'd.documento', 'd.descripcion')
            ->get();

        // Pasar los proyectos a la vista 'home'
        return view(
            'home',
            compact('proyectos', 'tipoDocumentos', 'documentos')
        );
    }

    public function storeDocumento(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'descripcion' => 'nullable|string|max:500',
            'meses_notificar' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'tipo_id' => 'required',
            'proyecto_id' => 'required',
            'nombre_doc' => 'nullable|string|max:100',
            'nombre_proyecto' => 'nullable|string|max:100',
            'documento' => 'nullable|file|mimes:pdf,doc,docx' // Archivos PDF o Word,
        ]);

        // Verificar si la fecha de inicio es mayor que la fecha de fin
        if (strtotime($validated['fecha_inicio']) > strtotime($validated['fecha_fin'])) {
            return redirect()->back()->withErrors(['fecha_inicio' => 'La fecha de inicio no puede ser mayor que la fecha de fin.'])->with('error', 'La fecha de inicio no puede ser mayor que la fecha de fin.');
        }

        if ($request->proyecto_id == 'nuevo') {
            $proyecto = Proyecto::firstOrCreate(
                ['nombre' => $validated['nombre_proyecto']],
                ['nombre' => $validated['nombre_proyecto']]
            );
        } else {
            $proyecto = Proyecto::firstOrCreate(
                ['nombre' => $validated['proyecto_id']],
                ['nombre' => $validated['proyecto_id']]
            );
        }

        if ($request->tipo_id == 'nuevo') {
            $tipoDocumento = TipoDocumento::firstOrCreate(
                ['nombre' => $validated['nombre_doc']],
                ['nombre' => $validated['nombre_doc']]
            );
        } else {
            $tipoDocumento = TipoDocumento::firstOrCreate(
                ['nombre' => $validated['tipo_id']],
                ['nombre' => $validated['tipo_id']]
            );
        }

        // Guardar el archivo en el sistema de archivos local
        if ($request->hasFile('documento')) {
            // Obtener la extensión del archivo (por ejemplo, 'pdf', 'docx')
            $extension = $request->file('documento')->getClientOriginalExtension();

            // Generar un nombre único para el archivo utilizando el nombre original y un sufijo único
            $nombreArchivo = pathinfo($request->file('documento')->getClientOriginalName(), PATHINFO_FILENAME);
            $nombreArchivoUnico = $nombreArchivo . '_' . time() . '.' . $extension;

            // Guardar el archivo con el nuevo nombre en el sistema de archivos
            $rutaArchivo = $request->file('documento')->storeAs('', $nombreArchivoUnico, 'public');
        }

        $documento = Documento::create([
            'descripcion' => $validated['descripcion'],
            'meses_notificar' => $validated['meses_notificar'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'documento' => $rutaArchivo,
            'proyecto_id' => $proyecto->proyecto_id, // Usar el ID del proyecto recién creado o existente
            'tipo_id' => $tipoDocumento->tipo_id, // Usar el ID del tipo de documento recién creado o existente
            'fecha_creacion' => now(),
            'user_id' => auth()->user()->id, // Obtener el ID del usuario autenticado
        ]);

        // Redirigir con éxito
        return redirect()->back()->with('success', 'Documento creado con éxito');
    }

    public function editDocumento(Request $request)
    {

        $id = $request->get('id');
        // Consulta para buscar por id el documento
        $documento = DB::table('documento as d')
            ->join('tipo_documento as td', 'td.tipo_id', '=', 'd.tipo_id')
            ->join('proyecto as p', 'p.proyecto_id', '=', 'd.proyecto_id')
            ->select(
                'd.documento_id as id',
                'td.nombre as tipo_documento',
                'p.nombre as proyecto',
                'd.fecha_inicio',
                'd.fecha_fin',
                'd.documento',
                'd.descripcion',
                'd.meses_notificar'
            )
            ->where('d.documento_id', '=', $id)
            ->first();

        $proyectos = Proyecto::all();
        $tipoDocumentos = TipoDocumento::all();
        /* echo($documento);
        exit(); */
        return view('editarDocumento', compact('proyectos', 'documento', 'tipoDocumentos'));
    }

    public function updateDocumento(Request $request)
    {
        $rutaArchivo = '';

        $validated = $request->validate([
            'id' => 'nullable',
            'descripcion' => 'nullable|string|max:500',
            'meses_notificar' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'tipo_id' => 'required',
            'proyecto_id' => 'required',
            'nombre_doc' => 'nullable|string|max:100',
            'nombre_proyecto' => 'nullable|string|max:100',
            'documento' => 'nullable|file|mimes:pdf,doc,docx' // Archivos PDF o Word,
        ]);

        // Verificar si la fecha de inicio es mayor que la fecha de fin
        if (strtotime($validated['fecha_inicio']) > strtotime($validated['fecha_fin'])) {
            return redirect()->back()->withErrors(['fecha_inicio' => 'La fecha de inicio no puede ser mayor que la fecha de fin.'])->with('error', 'La fecha de inicio no puede ser mayor que la fecha de fin.');
        }

        if ($request->proyecto_id == 'nuevo') {
            $proyecto = Proyecto::firstOrCreate(
                ['nombre' => $validated['nombre_proyecto']],
                ['nombre' => $validated['nombre_proyecto']]
            );
        } else {
            $proyecto = Proyecto::firstOrCreate(
                ['nombre' => $validated['proyecto_id']],
                ['nombre' => $validated['proyecto_id']]
            );
        }

        if ($request->tipo_id == 'nuevo') {
            $tipoDocumento = TipoDocumento::firstOrCreate(
                ['nombre' => $validated['nombre_doc']],
                ['nombre' => $validated['nombre_doc']]
            );
        } else {
            $tipoDocumento = TipoDocumento::firstOrCreate(
                ['nombre' => $validated['tipo_id']],
                ['nombre' => $validated['tipo_id']]
            );
        }

        // Encontrar el documento por su ID
        $documento = Documento::findOrFail($request->id);

        // validar si el archivo cambio para eliminar en anterior
        empty($request->documento) ? $rutaArchivo = $documento->documento : $rutaArchivo = $request->documento;

        // Guardar el archivo en el sistema de archivos local
        if ($rutaArchivo != $documento->documento) {

            // Verificar si el archivo existe y eliminarlo
            if (Storage::disk('public')->exists($documento->documento)) {
                Storage::disk('public')->delete($documento->documento);
            }

            // Guarda nuevo archivo
            if ($request->hasFile('documento')) {
                // Obtener la extensión del archivo (por ejemplo, 'pdf', 'docx')
                $extension = $request->file('documento')->getClientOriginalExtension();

                // Generar un nombre único para el archivo utilizando el nombre original y un sufijo único
                $nombreArchivo = pathinfo($request->file('documento')->getClientOriginalName(), PATHINFO_FILENAME);
                $nombreArchivoUnico = $nombreArchivo . '_' . time() . '.' . $extension;

                // Guardar el archivo con el nuevo nombre en el sistema de archivos
                $rutaArchivo = $request->file('documento')->storeAs('', $nombreArchivoUnico, 'public');
            }
        }

        // Actualizar los datos del documento
        $documento->update([
            'descripcion' => $validated['descripcion'],
            'meses_notificar' => $validated['meses_notificar'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'documento' => $rutaArchivo,
            'proyecto_id' => $proyecto->proyecto_id, // Usar el ID del proyecto recién creado o existente
            'tipo_id' => $tipoDocumento->tipo_id, // Usar el ID del tipo de documento recién creado o existente
        ]);

        // Redirigir a una ruta o vista con un mensaje de éxito
        return redirect()->route('home.index')->with('success', 'Documento actualizado con éxito');
    }

    public function destroyDocumento(Request $request)
    {
        $id = $request->get('id');

        // Buscar el registro por ID
        $documento = Documento::findOrFail($id);

        // Obtener la ruta del archivo desde la columna 'documento'
        $rutaArchivo = $documento->documento;

        // Verificar si el archivo existe y eliminarlo
        if (Storage::disk('public')->exists($rutaArchivo)) {
            Storage::disk('public')->delete($rutaArchivo);
        }

        // Eliminar el registro
        $documento->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('home.index')->with('success', 'Documento eliminado con éxito');
    }
}
