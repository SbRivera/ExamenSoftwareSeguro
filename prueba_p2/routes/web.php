<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyActiveUser;
use App\Http\Middleware\VerifyAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', VerifyActiveUser::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->middleware(VerifyAdmin::class)->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::patch('/users/{user}', [UserController::class, 'updateStatus'])->name('admin.users.update');
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
    });
});

// Endpoint que retorna si el usuario sigue activo
Route::get('/check-active', function () {
    if (Auth::check()) {
        if (!Auth::user()->is_active) {
            return response()->json([
                'is_active' => false,
                'reason' => Auth::user()->deactivation_reason ?: 'Tu cuenta ha sido desactivada.'
            ]);
        }
        return response()->json(['is_active' => true]);
    }
    return response()->json([
        'is_active' => false,
        'reason' => 'Tu cuenta ha sido desactivada.'
    ]);
})->name('check-active');

// Endpoint que cierra sesión y redirige con mensaje
Route::get('/force-logout', function (Request $request) {
    $reason = $request->query('reason', 'Tu cuenta ha sido desactivada.');
    Auth::logout();
    return redirect()
        ->route('login')
        ->withErrors(['email' => $reason]);
})->name('force-logout');

require __DIR__.'/auth.php';
