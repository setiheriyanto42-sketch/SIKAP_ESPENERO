@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            Manajemen User
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-5">

                <h2 class="text-xl font-bold">

                    Daftar User

                </h2>

                <a href="{{ route('user.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                    + Tambah User

                </a>

            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">

                <table class="w-full">

                    <thead class="bg-slate-800 text-white">

                        <tr>

                            <th class="p-3">No</th>

                            <th>Username</th>

                            <th>Nama Guru</th>

                            <th>Role</th>

                            <th>Email</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $user->name }}

                            </td>

                            <td>

                                {{ optional($user->guru)->nama ?? '-' }}

                            </td>

                            <td>

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                    {{ optional($user->role)->nama_role }}

                                </span>

                            </td>

                            <td>

                                {{ $user->email }}

                            </td>

                            <td>

                                <a href="{{ route('user.edit',$user) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('user.destroy',$user) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus user ini?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-10 text-gray-500">

                                Belum ada user.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
