<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index() : View
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        $departments = Department::all();

        return view('department.departments', compact('departments'));
    }

    public function newDepartment() : View
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        return view('department.add-department');
    }

    public function createDepartment(Request $request) : RedirectResponse
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        $request->validate([
            'name' => 'required|string|min:3|max:255|unique:departments,name',
        ],[
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome deve ter no máximo :max caracteres.',
            'name.unique' => 'Já existe um departamento com este nome.',
        ]);

        Department::create([ 'name' => $request->name ]);

        return redirect()->route('departments');
    }
}
