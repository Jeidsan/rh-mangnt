<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function home()
    {
        Auth::user()->can('admin') ?: abort(403, 'Você não tem permissão para acessar esta página.');

        $data = [];

        $data['total_colaborators'] = User::whereNull('deleted_at')->count();
        $data['total_colaborators_deleted'] = User::onlyTrashed()->count();
        $data['total_salary'] = User::withoutTrashed()
            ->with('detail')
            ->get()
            ->sum(function($colaborator) {
                return $colaborator->detail->salary;
            });

        $data['total_salary'] = 'R$ ' . number_format($data['total_salary'], 2, ',', '.');

        $data['total_colaborators_per_department'] = User::withoutTrashed()
            ->with('department')
            ->get()
            ->groupBy('department_id')
            ->map(function($group) {
                return [
                    'department' => $group->first()->department->name ?? '-',
                    'total' => $group->count()
                ];
            });

        $data['total_salary_per_department'] = User::withoutTrashed()
            ->with(['detail', 'department'])
            ->get()
            ->groupBy('department_id')
            ->map(function($group) {
                return [
                    'department' => $group->first()->department->name ?? '-',
                    'total' => $group->sum(function($colaborator) {
                        return $colaborator->detail->salary ?? 0;
                    })
                ];
            });

        $data['total_salary_per_department'] = $data['total_salary_per_department']->map(function($item) {
            return [
                'department' => $item['department'],
                'total' => 'R$ ' . number_format($item['total'], 2, ',', '.')
            ];
        });

        return view('home', compact('data'));
    }
}
