<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold">
        Jadwal Mengajar
    </h2>
</x-slot>

<div class="py-6">

    <div class="max-w-7xl mx-auto">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">

            <h3 class="text-xl font-bold">
                Daftar Jadwal Mengajar
            </h3>

            <a href="{{ route('jadwal-mengajar.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

                + Tambah Jadwal

            </a>

        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">

            <table class="min-w-full">

                <thead class="bg-slate-800 text-white">

                    <tr>

                        <th class="p-3 text-left">Hari</th>

                        <th class="p-3 text-left">Jam</th>

                        <th class="p-3 text-left">Guru</th>

                        <th class="p-3 text-left">Mapel</th>

                        <th class="p-3 text-left">Kelas</th>

                        <th class="p-3 text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($jadwal as $item)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">

                            {{ $item->hari }}

                        </td>

                        <td class="p-3">

                            {{ $item->jam_mulai }}

                            -

                            {{ $item->jam_selesai }}

                        </td>

                        <td class="p-3">

                            {{ $item->guruMengajar->guru->nama }}

                        </td>

                        <td class="p-3">

                            {{ $item->guruMengajar->mataPelajaran->nama_mapel }}

                        </td>

                        <td class="p-3">

                            {{ $item->guruMengajar->kelas->nama_kelas }}

                        </td>

                        <td class="p-3 text-center">

                            <div class="flex justify-center gap-2 flex-wrap">

                                <a
                                    href="{{ route('mengajar.index',$item) }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded">

                                    🚀 Mulai Mengajar

                                </a>

                                <a
                                    href="{{ route('jadwal-mengajar.edit',$item) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded">

                                    ✏ Edit

                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('jadwal-mengajar.destroy',$item) }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">

                                        🗑 Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-10 text-gray-500">

                            Belum ada jadwal mengajar.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>
