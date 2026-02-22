<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user.
     */
    public function index(Request $request)
    {
        $query = User::withCount('carts')->latest();

        // Filter by role
        if ($request->filled('role') && in_array($request->role, ['admin', 'customer'])) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => User::count(),
            'admins'    => User::where('role', 'admin')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'verified'  => User::whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Toggle role user antara 'admin' dan 'customer'.
     */
    public function toggleRole(User $user)
    {
        // Jangan bisa ubah role diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->role = $user->role === 'admin' ? 'customer' : 'admin';
        $user->save();

        return back()->with('success', "User {$user->name}'s role updated to {$user->role}.");
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account here.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User {$name} has been deleted.");
    }
}
