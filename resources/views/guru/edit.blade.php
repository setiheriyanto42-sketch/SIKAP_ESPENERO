@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Edit Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('guru.update', $guru->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-semibold">NIP</label>
                        <input
                            type="text"
                            name="nip"
                            value="{{ old('nip', $guru->nip) }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nama Guru</label>
                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama', $guru->nama) }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Jenis Kelamin</label>

                        <select
                            name="jenis_kelamin"
                            class="border rounded w-full p-2">

                            <option value="L" {{ $guru->jenis_kelamin=='L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="P" {{ $guru->jenis_kelamin=='P' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">No HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp', $guru->no_hp) }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Email</label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $guru->email) }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Alamat</label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="border rounded w-full p-2">{{ old('alamat',$guru->alamat) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Status</label>

                        <select
                            name="aktif"
                            class="border rounded w-full p-2">

                            <option value="1" {{ $guru->aktif ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="0" {{ !$guru->aktif ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>

                        </select>

                    </div>

                    <button
                        class="bg-blue-600 text-Grey px-6 py-2 rounded">
                        Update
                    </button>

                    <a href="{{ route('guru.index') }}"
                       class="bg-gray-500 text-white px-6 py-2 rounded ml-2">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

@endsection
