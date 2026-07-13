<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Master Mata Pelajaran
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-5 bg-green-100 border border-green-400 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">

                <a href="{{ route('mata-pelajaran.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

                    + Tambah Mata Pelajaran

                </a>

            </div>

            <div class="bg-white shadow rounded">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-3">No</th>
                            <th>Kode</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelompok</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($mapel as $item)

                        <tr class="border-t">

                            <td class="p-3">{{ $loop->iteration }}</td>

                            <td>{{ $item->kode_mapel }}</td>

                            <td>{{ $item->nama_mapel }}</td>

                            <td>{{ $item->kelompok }}</td>

                            <td>

                                @if($item->aktif)

                                    <span class="bg-green-200 px-2 rounded">

                                        Aktif

                                    </span>

                                @else

                                    <span class="bg-red-200 px-2 rounded">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('mata-pelajaran.edit',$item) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('mata-pelajaran.destroy',$item) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus data?')"
                                        class="bg-red-600 text-white px-3 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center p-5">

                                Belum ada data.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
