<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Data Siswa
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
                        Daftar Siswa
                    </h3>

                    <a href="{{ route('siswa.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                    + Tambah Siswa

                    </a>

                </div>

                <table class="min-w-full border border-gray-300">

                    <thead class="bg-gray-200">

                        <tr>
                            <th class="border px-3 py-2">No</th>
                            <th class="border px-3 py-2">NIS</th>
                            <th class="border px-3 py-2">NISN</th>
                            <th class="border px-3 py-2">Nama</th>
                            <th class="border px-3 py-2">L/P</th>
                            <th class="border px-3 py-2">Kelas</th>
                            <th class="border px-3 py-2">Status</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($siswas as $siswa)

                        <tr>

                            <td class="border px-3 py-2">{{ $loop->iteration }}</td>

                            <td class="border px-3 py-2">{{ $siswa->nis }}</td>

                            <td class="border px-3 py-2">{{ $siswa->nisn }}</td>

                            <td class="border px-3 py-2">{{ $siswa->nama }}</td>

                            <td class="border px-3 py-2">{{ $siswa->jenis_kelamin }}</td>

                            <td class="border px-3 py-2">
                                {{ $siswa->kelas . $siswa->rombel }}
                            </td>

                            <td class="border px-3 py-2">

                                @if($siswa->aktif)

                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">
                                        Aktif
                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="border px-3 py-4 text-center">

                                Belum ada data siswa.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
