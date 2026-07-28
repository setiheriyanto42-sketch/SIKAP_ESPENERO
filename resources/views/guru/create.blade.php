@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Tambah Guru
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('guru.store') }}" method="POST">
    @csrf

                    <div class="mb-4">

                        <label class="block font-semibold">
                            NIP
                        </label>

                        <input
                        type="text"
                        name="nip"
                        value="{{ old('nip') }}"
                        class="border rounded w-full p-2">

                    @error('nip')
                        <div class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            Nama Guru
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="border rounded w-full p-2">
                            @error('nama')
                                <div class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            Jenis Kelamin
                        </label>

                        <select
                            name="jenis_kelamin"
                            class="border rounded w-full p-2">

                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>

                        </select>
                        @error('jenis_kelamin')
                            <div class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            No HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            class="border rounded w-full p-2">

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="border rounded w-full p-2">

                            @error('email')
                                <div class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            Alamat
                        </label>

                        <textarea
                            name="alamat"
                            class="border rounded w-full p-2"
                            rows="3">{{ old('alamat') }}</textarea>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold">
                            Status
                        </label>

                       <select
                            name="aktif"
                            class="border rounded w-full p-2">

                            <option value="1">Aktif</option>

                            <option value="0">Tidak Aktif</option>

                        </select>

                    </div>

                    <div class="mt-6">

                        <button
                            class="bg-blue-600 text-Grey px-6 py-2 rounded">

                            Simpan

                        </button>

                        <a href="/guru"
                           class="bg-gray-500 text-Grey px-6 py-2 rounded ml-2">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
