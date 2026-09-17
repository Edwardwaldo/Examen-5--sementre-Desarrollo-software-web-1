<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Listar todos los clientes.
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Formulario para crear cliente.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Guardar nuevo cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut_empresa'     => ['required', 'string', 'max:12', 'unique:clients,rut_empresa'],
            'rubro'           => ['required', 'string', 'max:100'],
            'razon_social'    => ['required', 'string', 'max:150'],
            'telefono'        => ['required', 'string', 'max:20'],
            'direccion'       => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'max:150'],
            'email_contacto'  => ['required', 'email', 'max:150'],
        ]);

        Client::create($request->only([
            'rut_empresa',
            'rubro',
            'razon_social',
            'telefono',
            'direccion',
            'nombre_contacto',
            'email_contacto',
        ]));

        return redirect()->route('clients.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Formulario para editar cliente.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Actualizar cliente existente.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'rut_empresa'     => ['required', 'string', 'max:12', Rule::unique('clients', 'rut_empresa')->ignore($client->id)],
            'rubro'           => ['required', 'string', 'max:100'],
            'razon_social'    => ['required', 'string', 'max:150'],
            'telefono'        => ['required', 'string', 'max:20'],
            'direccion'       => ['required', 'string', 'max:255'],
            'nombre_contacto' => ['required', 'string', 'max:150'],
            'email_contacto'  => ['required', 'email', 'max:150'],
        ]);

        $client->update($request->only([
            'rut_empresa',
            'rubro',
            'razon_social',
            'telefono',
            'direccion',
            'nombre_contacto',
            'email_contacto',
        ]));

        return redirect()->route('clients.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
