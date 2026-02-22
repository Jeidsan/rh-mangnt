<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RhManagementController extends Controller
{
    public function home() : View
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $colaborators = User::withTrashed()
            ->with('detail', 'department')
            ->where('role', 'colaborator')
            ->get();

        return view('colaborators.colaborators', compact('colaborators'));
    }

    public function newColaborator() : View
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $departments = Department::where('id', '>', 2)->get();

        if ( $departments->count() === 0 ) {
            abort('403', 'Não existem departamentos cadastrados. Por favor, contacte o administrador para cadastrar um departamento antes de criar um colaborador.');
        }

        return view('colaborators.add-colaborator', compact('departments'));
    }

    public function createColaborator(Request $request)
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'select_department' => 'required|exists:departments,id',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.max' => 'O campo email deve ter no máximo 255 caracteres.',
            'email.unique' => 'O email já está em uso.',
            'select_department.required' => 'O campo departamento é obrigatório.',
            'select_department.exists' => 'O departamento selecionado é inválido.',
            'address.required' => 'O campo endereço é obrigatório.',
            'address.string' => 'O campo endereço deve ser uma string.',
            'address.max' => 'O campo endereço deve ter no máximo 255 caracteres.',
            'zip_code.required' => 'O campo CEP é obrigatório.',
            'zip_code.string' => 'O campo CEP deve ser uma string.',
            'zip_code.max' => 'O campo CEP deve ter no máximo 10 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'O campo cidade deve ser uma string.',
            'city.max' => 'O campo cidade deve ter no máximo 50 caracteres.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.string' => 'O campo telefone deve ser uma string.',
            'phone.max' => 'O campo telefone deve ter no máximo 20 caracteres.',
            'salary.required' => 'O campo salário é obrigatório.',
            'salary.decimal' => 'O campo salário deve ser um número decimal com até 2 casas decimais.',
            'admission_date.required' => 'O campo data de admissão é obrigatório.',
            'admission_date.date_format' => 'O campo data de admissão deve estar no formato AAAA-MM-DD.',
        ]);

        if( $request->select_department <= 2 ) {
            return redirect()->route('home');
        }

        $token = Str::random(60);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'colaborator';
        $user->department_id = $request->select_department;
        $user->permissions = json_encode(['colaborator']);
        $user->save();

        $user->detail()->create([
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'admission_date' => $request->admission_date,
        ]);

        Mail::to($request->email)
            ->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('rh-users.management.home')->with('success', "Colaborador {$user->name} criado com sucesso.");
    }

    public function editColaborator($id)
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $colaborator = User::with('detail')->findOrFail($id);
        $departments = Department::where('id', '>', 2)->get();

        return view('colaborators.edit-colaborator', compact('colaborator', 'departments'));
    }

    public function updateColaborator(Request $request) : RedirectResponse
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'select_department' => 'required|exists:departments,id',
            'salary' => 'required|decimal:2',
            'admission_date' => 'required|date_format:Y-m-d',
        ], [
            'select_department.required' => 'O campo departamento é obrigatório.',
            'select_department.exists' => 'O departamento selecionado é inválido.',
            'salary.required' => 'O campo salário é obrigatório.',
            'salary.decimal' => 'O campo salário deve ser um número decimal com até 2 casas decimais.',
            'admission_date.required' => 'O campo data de admissão é obrigatório.',
            'admission_date.date_format' => 'O campo data de admissão deve estar no formato AAAA-MM-DD.',
        ]);

        if( $request->select_department <= 2 ) {
            return redirect()->route('home');
        }

        $user = User::findOrFail($request->user_id);
        $user->detail->salary = $request->salary;
        $user->detail->admission_date = $request->admission_date;
        $user->department_id = $request->select_department;
        $user->save();
        $user->detail->save();

        return redirect()->route('rh-users.management.home')->with('success', "Colaborador {$user->name} atualizado com sucesso.");
    }

    public function showDetails($id) : View
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $colaborator = User::withTrashed()
            ->with('detail', 'department')
            ->findOrFail($id);

        return view('colaborators.show-details', compact('colaborator'));
    }

    public function deleteColaborator($id) : View
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-colaborator', compact('colaborator'));
    }

    public function deleteColaboratorConfirm($id) : RedirectResponse
    {
        Auth::user()->can('rh') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('rh-users.management.home')->with('success', "Colaborador {$colaborator->name} excluído com sucesso.");
    }
}
