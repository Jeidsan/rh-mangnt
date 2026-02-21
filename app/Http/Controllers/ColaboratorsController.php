<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ColaboratorsController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        $colaborators = User::with('detail', 'department')->where('role', '<>', 'admin')->get();

        return view('colaborators.admin-all-colaborators', compact('colaborators'));
    }

    public function showDetails($id)
    {
        Auth::user()->can('admin', 'rh') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( Auth::user()->id == $id ) {
            abort(403, 'Você não está autorizado a acessar esta página.');
        }

        $colaborator = User::with('detail', 'department')->findOrFail($id);

        return view('colaborators.show-details', compact('colaborator'));
    }

    public function deleteColaborator($id) : View
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( Auth::user()->id == $id ) {
            abort(403, 'Você não está autorizado a acessar esta página.');
        }

        $colaborator = User::findOrFail($id);

        return view('colaborators.delete-colaborator-confirm', compact('colaborator'));
    }

    public function deleteColaboratorConfirm($id) : RedirectResponse
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( Auth::user()->id == $id ) {
            abort(403, 'Você não está autorizado a acessar esta página.');
        }

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators')->with('success', 'Colaborador eliminado com sucesso!');
    }
}
