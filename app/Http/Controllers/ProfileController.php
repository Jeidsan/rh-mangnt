<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function updateUserAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|min:3|max:100',
            'zip_code' => 'required|min:3|max:10',
            'city' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:20',
        ],[
            'address.required' => 'O endereço é obrigatório.',
            'address.min' => 'O endereço deve conter no mínimo :min caracteres.',
            'address.max' => 'O endereço deve conter no máximo :max caracteres.',
            'zip_code.required' => 'O código postal é obrigatório.',
            'zip_code.min' => 'O código postal deve conter no mínimo :min caracteres.',
            'zip_code.max' => 'O código postal deve conter no máximo :max caracteres.',
            'city.required' => 'A cidade é obrigatória.',
            'city.min' => 'A cidade deve conter no mínimo :min caracteres.',
            'city.max' => 'A cidade deve conter no máximo :max caracteres.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.min' => 'O telefone deve conter no mínimo :min caracteres.',
            'phone.max' => 'O telefone deve conter no máximo :max caracteres.',
        ]);

        $user = User::with('detail')->findOrFail(auth()->id());
        $user->address = $request->address;
        $user->zip_code = $request->zip_code;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->detail->save();

        return back()->with('success_change_address', 'Endereço do usuário atualizado com sucesso.');
    }
}
