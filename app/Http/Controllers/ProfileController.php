<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index() : View
    {
        return view('user.profile');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8|max:16',
            'new_password' => 'required|min:8|max:16|confirmed|different:current_password',
            'new_password_confirmation' => 'required|same:new_password',
        ],[
            'current_password.required' => 'A senha atual é obrigatória.',
            'current_password.min' => 'A senha atual deve conter no mínimo :min caracteres.',
            'current_password.max' => 'A senha atual deve conter no máximo :max caracteres.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.min' => 'A nova senha deve conter no mínimo :min caracteres.',
            'new_password.max' => 'A nova senha deve conter no máximo :max caracteres.',
            'new_password.confirmed' => 'A confirmação da nova senha não corresponde.',
            'new_password.different' => 'A nova senha deve ser diferente da senha atual.',
            'new_password_confirmation.required' => 'A confirmação da nova senha é obrigatória.',
            'new_password_confirmation.same' => 'A confirmação da nova senha deve ser igual à nova senha.',
        ]);

        $user = auth()->user();

        if (!password_verify($request->current_password, $user->password)) {
            return back()->with('error', 'A senha atual está incorreta.');
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('success', 'Senha atualizada com sucesso.');
    }

    public function updateUserData(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ],[
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.min' => 'O nome deve conter no mínimo :min caracteres.',
            'name.max' => 'O nome deve conter no máximo :max caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.max' => 'O email deve conter no máximo :max caracteres.',
            'email.unique' => 'O email já está em uso por outro usuário.',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success_change_data', 'Dados do usuário atualizados com sucesso.');
    }
}
