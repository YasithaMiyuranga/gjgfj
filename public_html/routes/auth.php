<?php

use App\Http\Controllers\AdminCmsController;
use App\Http\Controllers\auth\AuthenticatedSessonController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\PasswordResetLinkController;
use App\Http\Controllers\auth\NewPasswordController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ManagerController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;



// Admin login
Route::get('admin/login', [AdminCmsController::class, 'setLogin'])->name('admin.login')->middleware(['guest:admin', 'setlocate']);
Route::post('admin/login', [AuthenticatedSessonController::class, 'store'])->middleware(['guest:admin', 'setlocate']); //BackEnd

Route::middleware('auth:admin')->group(function () {
    Route::post('logout', [AuthenticatedSessonController::class, 'destroy'])
        ->name('logout');

    Route::post('admin/logout', [AdminCmsController::class, 'destroy'])
        ->name('useradmin.logout');
});

// Forgot Password view
Route::get('/forgot-password', [PasswordResetLinkController::class, 'index'])->name('password.request');
// Forgot Password Backend
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
// Password Reset Form Route
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Password Update Route
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');



// Manage employee authentication

// Employee register
Route::get('emp/register', [EmployeeController::class, 'empregister'])->middleware(['setlocate']);
Route::post('emp/register', [EmployeeController::class, 'store'])->name('emp.registerstore')->middleware(['guest:employee', 'setlocate']);


// Employee login
Route::get('emp/login', [EmployeeController::class, 'emplogin'])->name('emp.emplogin')->middleware(['setlocate']);
Route::post('emp/login', [AuthenticatedSessonController::class, 'loginemp'])->name('emp.loginemp')->middleware(['guest:employee', 'setlocate']);
// Route::post('emp/login',[AuthenticatedSessonController::class, 'loginemp'])->name('emp.loginemp')->middleware(['setlocate']);

Route::middleware('auth:employee')->group(function () {
    Route::post('emp/logout', [AuthenticatedSessonController::class, 'destroyemp'])
        ->name('logout');

    Route::post('emp/logout', [EmployeeController::class, 'destroy'])
        ->name('emp.logout');
});


// Manager login
Route::get('manager/login', [ManagerController::class, 'managerlogin'])->name('manager.login')->middleware(['setlocate']);
Route::post('man/login', [AuthenticatedSessonController::class, 'loginman'])->name('man.loginman')->middleware(['guest:manager', 'setlocate']);


Route::middleware('auth:manager')->group(function () {
    Route::post('man/logout', [AuthenticatedSessonController::class, 'destroyman'])
        ->name('logout');

    Route::post('man/logout', [ManagerController::class, 'destroy'])
        ->name('man.logout');
});




// Manage user authentication

//user register
Route::post('user/register', [UserController::class, 'store'])->name('user.register.store');
//user login
Route::post('user/login', [AuthenticatedSessonController::class, 'loginuser'])->name('user.loginuser');

//  Route::middleware('auth:user')->group(function () {
//     Route::post('user/logout', [AuthenticatedSessonController::class, 'destroyuser'])
//         ->name('user.logout');

//     Route::post('user/logout', [UserController::class, 'destroy'])
//         ->name('user.logout');

// });

Route::post('user/logout', [UserController::class, 'userLogout'])
    ->name('user.logout');
// Password Reset Form Route
Route::get('/reset-user-password/{token}/{email?}', function (Request $request, $token, $email = null) {
    return view('layouts.userapp', [
        'token' => $token,
        'email' => $email
    ]);
})->name('password.reset.user');

// Route to display email verification notice
Route::get('/email/verify', function () {
    // Return the view for email verification notice
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


// Route to verify user's email
Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verify'])
    ->middleware(['signed']) // Ensure the request is signed
    ->name('verification.verify');



// Manage Agent authentication

// Agent login
Route::get('agent/login', [AgentController::class, 'agentLogin'])->middleware(['setlocate']);
Route::post('agent/login', [AuthenticatedSessonController::class, 'loginAgent'])->name('agent.login')->middleware(['guest:agent', 'setlocate']);


Route::middleware('auth:agent')->group(function () {
    Route::post('agent/logout', [AuthenticatedSessonController::class, 'destroyAgent'])
        ->name('agent.logout');

    Route::post('agent/logout', [AgentController::class, 'destroy'])
        ->name('agent.logout');
});
