@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            Tambah User
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-xl shadow p-6">

                <form action="{{ route('user.store') }}" method="POST">

                    @csrf

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Hubungkan ke Guru
                        </label>

                        <select
                            name="guru_id"
                            class="border rounded w-full p-2">

                            <option value="">
                                -- Pilih Guru --
                            </option>

                            @foreach($gurus as $guru)

                                <option value="{{ $guru->id }}">

                                    {{ $guru->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Role
                        </label>

                        <select
                            name="role_id"
                            class="border rounded w-full p-2">

                            @foreach($roles as $role)

                                <option value="{{ $role->id }}">

                                    {{ $role->nama_role }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Username
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="border rounded w-full p-2"
                            required>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="border rounded w-full p-2"
                            required>

                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <label class="block font-semibold mb-2">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="border rounded w-full p-2"
                                required>

                        </div>

                        <div>

                            <label class="block font-semibold mb-2">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="border rounded w-full p-2"
                                required>

                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">

                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">

                            💾 Simpan

                        </button>

                        <a
                            href="{{ route('user.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
