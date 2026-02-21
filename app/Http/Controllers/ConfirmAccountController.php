<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($token) : View
    {
        $user = User::where('confirmation_token', $token)->first();

        if( !$user ) {
            abort(403, 'Token de confirmação inválido.');
        }

        return view('auth.confirm-account', compact('user'));
    }

    public function confirmAccountSubmit(Request $request) : RedirectResponse
    {
        $request->validate([
            'token' => 'required|string|size:60|exists:users,confirmation_token',
            'password' => 'required|min:8|max:16|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password'
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve conter no mínimo :min caracteres.',
            'password.max' => 'A senha deve conter no máximo :max caracteres.',
            'password.confirmed' => 'A confirmação de senha deve ser igual à senha.',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número.'
        ]);

        $user = User::where('confirmation_token', $request->token)->first();

        if( !$user ) {
            abort(403, 'Usuário não encontrado.');
        }

        $user->password = bcrypt($request->input('password'));
        $user->email_verified_at = now();
        $user->confirmation_token = null;
        $user->save();

        return redirect()->route('login', ['success' => 'Conta confirmada com sucesso! Você já pode fazer login.']);
    }
}
