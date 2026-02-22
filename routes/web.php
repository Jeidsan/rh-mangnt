<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhManagementController;
use App\Http\Controllers\RhUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/home');

    Route::get('/home', function(){
        if( auth()->user()->role === 'admin' ) {
            return redirect()->route('admin.home');
        } elseif( auth()->user()->role ==='rh' ) {
            return redirect()->route('rh-users.management.home');
        } else {
            return redirect()->route('colaborator');
        }
    })->name('home');

    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update-password');
    Route::post('/user/profile/update-user-data', [ProfileController::class, 'updateUserData'])->name('user.profile.update-user-data');
    Route::post('/user/profile/update-user-address', [ProfileController::class, 'updateUserAddress'])->name('user.profile.update-user-address');

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new-department', [DepartmentController::class, 'newDepartment'])->name('departments.new-department');
    Route::post('/departments/create-department', [DepartmentController::class, 'createDepartment'])->name('departments.create-department');
    Route::get('/departments/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit-department');
    Route::post('/departments/update-department', [DepartmentController::class, 'updateDepartment'])->name('departments.update-department');
    Route::get('/departments/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete-department');
    Route::get('/departments/delete-department-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-department-confirm');

    Route::get('/rh-users', [RhUserController::class, 'index'])->name('rh-users');
    Route::get('/rh-users/new-colaborator', [RhUserController::class, 'newRhColaborator'])->name('rh-users.new-colaborator');
    Route::post('/rh-users/create-colaborator', [RhUserController::class, 'createRhColaborator'])->name('rh-users.create-colaborator');
    Route::get('/rh-users/edit-colaborator/{id}', [RhUserController::class, 'editRhColaborator'])->name('rh-users.edit-colaborator');
    Route::post('/rh-users/update-colaborator', [RhUserController::class, 'updateRhColaborator'])->name('rh-users.update-colaborator');
    Route::get('/rh-users/delete-colaborator/{id}', [RhUserController::class, 'deleteRhColaborator'])->name('rh-users.delete-colaborator');
    Route::get('/rh-users/delete-colaborator-confirm/{id}', [RhUserController::class, 'deleteRhColaboratorConfirm'])->name('rh-users.delete-colaborator-confirm');
    Route::get('/rh-users/restore-colaborator/{id}', [RhUserController::class, 'restoreRhColaborator'])->name('rh-users.restore-colaborator');
    Route::get('/rh-users/management/home', [RhManagementController::class, 'home'])->name('rh-users.management.home');
    Route::get('/rh-users/management/new-colaborator', [RhManagementController::class, 'newColaborator'])->name('rh-users.management.new-colaborator');
    Route::post('/rh-users/management/create-colaborator', [RhManagementController::class, 'createColaborator'])->name('rh-users.management.create-colaborator');
    Route::get('/rh-users/management/edit-colaborator/{id}', [RhManagementController::class, 'editColaborator'])->name('rh-users.management.edit-colaborator');
    Route::post('/rh-users/management/update-colaborator', [RhManagementController::class, 'updateColaborator'])->name('rh-users.management.update-colaborator');
    Route::get('/rh-users/management/details/{id}', [RhManagementController::class, 'showDetails'])->name('rh-users.management.details-colaborator');
    Route::get('/rh-users/management/delete-colaborator/{id}', [RhManagementController::class, 'deleteColaborator'])->name('rh-users.management.delete-colaborator');
    Route::get('/rh-users/management/delete-colaborator-confirm/{id}', [RhManagementController::class, 'deleteColaboratorConfirm'])->name('rh-users.management.delete-colaborator-confirm');
    Route::get('/rh-users/management/restore-colaborator/{id}', [RhManagementController::class, 'restoreColaborator'])->name('rh-users.management.restore-colaborator');

    Route::get('/colaborators', [ColaboratorsController::class, 'index'])->name('colaborators');
    Route::get('/colaborators/details/{id}', [ColaboratorsController::class, 'showDetails'])->name('colaborators.details');
    Route::get('/colaborators/delete/{id}', [ColaboratorsController::class, 'deleteColaborator'])->name('colaborators.delete');
    Route::get('/colaborators/delete-confirm/{id}', [ColaboratorsController::class, 'deleteColaboratorConfirm'])->name('colaborators.delete-confirm');
    Route::get('/colaborators/restore/{id}', [ColaboratorsController::class, 'restoreColaborator'])->name('colaborators.restore');

    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

    Route::get('/colaborator', [ColaboratorsController::class, 'home'])->name('colaborator');
});
