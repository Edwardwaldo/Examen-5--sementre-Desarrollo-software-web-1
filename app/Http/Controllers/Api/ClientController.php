<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * GET /api/clients — Listar todos los clientes.
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->get();

        return response()->json([
            'message' => 'Listado de clientes.',
            'data'    => $clients,
            'total'   => $clients->count(),
        ], 200);
    }

    /**
     * GET /api/clients/{id} — Obtener cliente por ID.
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (! $client) {
            return response()->json([
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Cliente encontrado.',
            'data'    => $client,
        ], 200);
    }

    /**
     * POST /api/clients — Crear nuevo cliente.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rut_empresa'     => ['required', 'string', 'max:12', 'unique:clients,rut_empresa'],
                'rubro'           => ['required', 'string', 'max:100'],
                'razon_social'    => ['required', 'string', 'max:150'],
                'telefono'        => ['required', 'string', 'max:20'],
                'direccion'       => ['required', 'string', 'max:255'],
                'nombre_contacto' => ['required', 'string', 'max:150'],
                'email_contacto'  => ['required', 'email', 'max:150'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Cliente creado correctamente.',
            'data'    => $client,
        ], 201);
    }

    /**
     * PUT /api/clients/{id} — Actualizar cliente.
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (! $client) {
            return response()->json([
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'rut_empresa'     => ['required', 'string', 'max:12', Rule::unique('clients', 'rut_empresa')->ignore($id)],
                'rubro'           => ['required', 'string', 'max:100'],
                'razon_social'    => ['required', 'string', 'max:150'],
                'telefono'        => ['required', 'string', 'max:20'],
                'direccion'       => ['required', 'string', 'max:255'],
                'nombre_contacto' => ['required', 'string', 'max:150'],
                'email_contacto'  => ['required', 'email', 'max:150'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $client->update($validated);

        return response()->json([
            'message' => 'Cliente actualizado correctamente.',
            'data'    => $client,
        ], 200);
    }

    /**
     * DELETE /api/clients/{id} — Eliminar cliente.
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (! $client) {
            return response()->json([
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        $client->delete();

        return response()->json([
            'message' => 'Cliente eliminado correctamente.',
        ], 200);
    }
}
