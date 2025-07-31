<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Listagem de usuários
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Formulário de cadastro
    public function create()
    {
        return view('admin.users.create');
    }

    // Armazena novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser um texto.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    // Formulário de edição
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Atualiza usuário
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    // Formulário de exclusão
    public function delete(User $user)
    {
        return view('admin.users.delete', compact('user'));
    }

    // Exclui usuário
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário excluído!');
    }
}
