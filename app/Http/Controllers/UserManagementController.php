<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Tampilkan daftar admin
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('users'));
    }
    
    /**
     * Form tambah admin
     */
    public function create()
    {
        return view('admin.create');
    }
    
    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil ditambahkan!');
    }
    
    /**
     * Form edit admin
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }
    
    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil diupdate!');
    }
    
    /**
     * Hapus admin
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Proteksi: tidak bisa hapus diri sendiri
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        
        // Proteksi: minimal 1 superadmin harus ada
        if ($user->isSuperAdmin() && User::where('role', 'superadmin')->count() <= 1) {
            return redirect()->route('admin.index')
                ->with('error', 'Tidak bisa menghapus Super Admin terakhir!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil dihapus!');
    }
}