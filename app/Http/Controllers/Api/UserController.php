<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * GET /api/users — Listar todos los usuarios.
     */
    public function index()
    {
        $users = User::select('id', 'rut', 'nombre', 'apellido', 'email', 'created_at')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'message' => 'Listado de usuarios.',
            'data'    => $users,
            'total'   => $users->count(),
        ], 200);
    }

    /**
     * GET /api/users/{id} — Obtener usuario por ID.
     */
    public function show($id)
    {
        $user = User::select('id', 'rut', 'nombre', 'apellido', 'email', 'created_at')
            ->find($id);

        if (! $user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Usuario encontrado.',
            'data'    => $user,
        ], 200);
    }

    /**
     * POST /api/users — Crear nuevo usuario.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'rut'      => ['required', 'string', 'max:12', 'unique:users,rut'],
                'nombre'   => ['required', 'string', 'max:100'],
                'apellido' => ['required', 'string', 'max:100'],
                'email'    => ['required', 'email', 'unique:users,email', 'ends_with:@ventasfix.cl'],
                'password' => ['required', 'string', 'min:6'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $user = User::create([
            'rut'      => $validated['rut'],
            'nombre'   => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'data'    => $user->only(['id', 'rut', 'nombre', 'apellido', 'email', 'created_at']),
        ], 201);
    }

    /**
     * PUT /api/users/{id} — Actualizar usuario.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'rut'      => ['required', 'string', 'max:12', Rule::unique('users', 'rut')->ignore($id)],
                'nombre'   => ['required', 'string', 'max:100'],
                'apellido' => ['required', 'string', 'max:100'],
                'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($id), 'ends_with:@ventasfix.cl'],
                'password' => ['nullable', 'string', 'min:6'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $data = [
            'rut'      => $validated['rut'],
            'nombre'   => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email'    => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado correctamente.',
            'data'    => $user->only(['id', 'rut', 'nombre', 'apellido', 'email', 'updated_at']),
        ], 200);
    }

    /**
     * DELETE /api/users/{id} — Eliminar usuario.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente.',
        ], 200);
    }
}
