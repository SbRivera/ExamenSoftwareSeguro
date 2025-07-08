<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with(['user', 'admin']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', fn($sub) => $sub->where('email', 'like', "%{$search}%"))
                  ->orWhereHas('admin', fn($sub) => $sub->where('email', 'like', "%{$search}%"))
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 20);

        $logs = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.audit-logs.index', compact('logs'));
    }
}
