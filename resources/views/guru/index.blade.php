<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Data Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">

                    <h3 class="text-2xl font-bold text-gray-800">
                        Daftar Guru
                    </h3>

                    <div class="flex gap-2">

                        <a href="{{ route('guru.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                            + Tambah Guru

                        </a>

                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">

                            <a href="{{ route('guru.import.form') }}"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">

                                Import Excel

                            </a>

                        </button>

                        <button
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">

                            Export Excel

                        </button>

                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">

                            PDF

                        </button>

                    </div>

                </div>

                <div class="mb-5">

                    <input
                        type="text"
                        placeholder="Cari Guru..."
                        class="border rounded-lg w-72 px-4 py-2">

                </div>

                <table class="min-w-full border border-gray-300">

                    <thead class="bg-gray-200">

                        <tr>

                            <th class="border px-3 py-2">No</th>
                            <th class="border px-3 py-2">NIP</th>
                            <th class="border px-3 py-2">Nama Guru</th>
                            <th class="border px-3 py-2">L/P</th>
                            <th class="border px-3 py-2">No HP</th>
                            <th class="border px-3 py-2">Status</th>
                            <th class="border px-3 py-2">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($gurus as $guru)

                        <tr class="hover:bg-gray-50">

                            <td class="border px-3 py-2">{{ $loop->iteration }}</td>

                            <td class="border px-3 py-2">{{ $guru->nip }}</td>

                            <td class="border px-3 py-2">{{ $guru->nama }}</td>

                            <td class="border px-3 py-2">{{ $guru->jenis_kelamin }}</td>

                            <td class="border px-3 py-2">{{ $guru->no_hp }}</td>

                            <td class="border px-3 py-2">

                                @if($guru->aktif)

                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                        Aktif
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                            <td class="border px-3 py-2">

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('guru.show',$guru) }}"
                                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-3 py-2 rounded-lg shadow"
                                        title="Detail">

                                        👁

                                    </a>

                                    <a href="{{ route('guru.edit',$guru->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                                        Edit

                                    </a>

                                    <form action="{{ route('guru.destroy',$guru->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus guru ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="border px-3 py-4 text-center">

                                Belum ada data guru.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
