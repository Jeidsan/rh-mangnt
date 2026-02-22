<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
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

    public function editDepartment($id) : View
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( $this->isDepartmentBlocked($id) ) {
            abort(403, 'Você não está autorizado a editar este departamento.');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', compact('department'));
    }

    public function updateDepartment(Request $request) : RedirectResponse
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( $this->isDepartmentBlocked($id) ) {
            abort(403, 'Você não está autorizado a editar este departamento.');
        }

        $request->validate([
            'id' => 'required|integer|exists:departments,id',
            'name' => 'required|string|min:3|max:255|unique:departments,name,' . $request->id,
        ],[
            'id.integer' => 'O ID deve ser um número inteiro.',
            'id.exists' => 'O departamento selecionado não existe.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome deve ter no máximo :max caracteres.',
            'name.unique' => 'Já existe um departamento com este nome.',
        ]);

        $department = Department::findOrFail($request->id);
        $department->update([ 'name' => $request->name ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id) : View
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( $this->isDepartmentBlocked($id) ) {
            abort(403, 'Você não está autorizado a eliminar este departamento.');
        }

        $department = Department::findOrFail($id);

        return view('department.delete-department-confirm', compact('department'));
    }

    public function deleteDepartmentConfirm($id) : RedirectResponse
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não está autorizado a acessar esta página.');

        if ( $this->isDepartmentBlocked($id) ) {
            abort(403, 'Você não está autorizado a eliminar este departamento.');
        }

        $department = Department::findOrFail($id);
        $department->delete();

        User::withTrashed()->where('department_id', $id)->update(['department_id' => null]);

        return redirect()->route('departments');
    }

    private function isDepartmentBlocked($id) : bool
    {
        return in_array(intval($id), [1,2]);
    }
}
