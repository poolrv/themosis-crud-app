<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonaController extends Controller
{
    public function __construct()
    {
        // Verificar que el usuario sea administrador
        $this->middleware(function ($request, $next) {
            if (!current_user_can('manage_options')) {
                wp_die('No tienes permisos para acceder a esta página.');
            }
            return $next($request);
        });
    }

    // Mostrar lista de personas
    public function index()
    {
        $personas = Persona::orderBy('created_at', 'desc')->get();
        return view('admin.personas.index', compact('personas'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.personas.create');
    }

    // Guardar nueva persona
    public function store(Request $request)
    {
        $validator = $this->validatePersona($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['rut'] = $this->limpiarRut($data['rut']);

        Persona::create($data);

        return redirect()->route('personas.index')
            ->with('success', 'Persona creada exitosamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        return view('admin.personas.edit', compact('persona'));
    }

    // Actualizar persona
    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);
        
        $validator = $this->validatePersona($request->all(), $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['rut'] = $this->limpiarRut($data['rut']);

        $persona->update($data);

        return redirect()->route('personas.index')
            ->with('success', 'Persona actualizada exitosamente.');
    }

    // Eliminar persona
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return redirect()->route('personas.index')
            ->with('success', 'Persona eliminada exitosamente.');
    }

    // Validaciones
    private function validatePersona($data, $id = null)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string',
            'fecha_nacimiento' => 'required|date|before:today'
        ];

        // Si es actualización, ignorar el RUT actual
        if ($id) {
            $rules['rut'] .= '|unique:personas,rut,' . $id;
        } else {
            $rules['rut'] .= '|unique:personas,rut';
        }

        $validator = Validator::make($data, $rules);

        // Validar formato de RUT
        $validator->after(function ($validator) use ($data) {
            $rutLimpio = $this->limpiarRut($data['rut']);
            if (!Persona::validarRut($rutLimpio)) {
                $validator->errors()->add('rut', 'El RUT ingresado no es válido.');
            }
        });

        return $validator;
    }

    // Limpiar RUT (quitar puntos y guiones)
    private function limpiarRut($rut)
    {
        return preg_replace('/[^k0-9]/i', '', $rut);
    }
}