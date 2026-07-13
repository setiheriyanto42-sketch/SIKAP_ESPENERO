<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guru;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Daftar User
     */
    public function index()
    {
        $users = User::with(['guru', 'role'])
            ->orderBy('name')
            ->get();

        return view('user.index', compact('users'));
    }

    /**
     * Form Tambah User
     */
    public function create()
    {
        $gurus = Guru::where('aktif', 1)
            ->orderBy('nama')
            ->get();

        $roles = Role::orderBy('nama_role')->get();

        return view('user.create', compact('gurus', 'roles'));
    }

    /**
     * Simpan User
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'nullable|exists:gurus,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'guru_id' => $request->guru_id,
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form Edit User
     */
    public function edit(User $user)
    {
        $gurus = Guru::where('aktif', 1)
            ->orderBy('nama')
            ->get();

        $roles = Role::orderBy('nama_role')->get();

        return view('user.edit', compact(
            'user',
            'gurus',
            'roles'
        ));
    }

    /**
     * Update User
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'guru_id' => 'nullable|exists:gurus,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = [
            'guru_id' => $request->guru_id,
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus User
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with(
            'success',
            'User berhasil dihapus.'
        );
    }
}
