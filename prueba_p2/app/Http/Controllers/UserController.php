<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\AuditLog;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);

        $users = $query->orderBy('name')->paginate($perPage)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function updateStatus(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        // Si solo se abrió el modal
        if ($request->has('open_modal')) {
            return back()->with([
                'show_modal' => true,
            ])->withInput([
                'user_id' => $user->id,
                'is_active' => $request->is_active,
            ]);
        }

        // Validar
        $request->validate([
            'is_active' => 'required|boolean',
            'reason' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        // Verificar contraseña
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()
                ->withErrors(['password' => 'La contraseña ingresada no es correcta.'])
                ->withInput([
                    'user_id' => $user->id,
                    'is_active' => $request->is_active,
                    'reason' => $request->reason,
                ])
                ->with(['show_modal' => true]);
        }

        // Actualizar estado
        $user->update([
            'is_active' => $request->is_active,
            'deactivation_reason' => $request->reason,
        ]);

        // Invalidar sesiones
        DB::table('sessions')->where('user_id', $user->id)->delete();

        $user->forceFill([
            'remember_token' => Str::random(60),
        ])->save();

        // Registrar auditoría
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => $request->is_active ? 'activate' : 'deactivate',
            'details' => ['reason' => $request->reason],
        ]);

        return back()->with('status', 'Estado de usuario actualizado correctamente.');
    }
}
