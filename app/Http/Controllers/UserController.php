<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Formulario para crear usuario.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut'      => ['required', 'string', 'max:12', 'unique:users,rut'],
            'nombre'   => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email', 'ends_with:@ventasfix.cl'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.ends_with' => 'El correo debe pertenecer al dominio @ventasfix.cl.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'rut'      => $request->rut,
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Formulario para editar usuario.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Actualizar usuario existente.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'rut'      => ['required', 'string', 'max:12', Rule::unique('users', 'rut')->ignore($user->id)],
            'nombre'   => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id), 'ends_with:@ventasfix.cl'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'email.ends_with' => 'El correo debe pertenecer al dominio @ventasfix.cl.',
        ]);

        $data = [
            'rut'      => $request->rut,
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
