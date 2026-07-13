<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                Master Data Kelas
            </h2>

            <a href="{{ route('kelas.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Kelas
            </a>
        </div>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            @if(session('success'))

                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">

                    {{ session('success') }}

                </div>

            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                        <tr>

                            <th class="p-3 border">No</th>

                            <th class="p-3 border">Kelas</th>

                            <th class="p-3 border">Wali Kelas</th>

                            <th class="p-3 border">Status</th>

                            <th class="p-3 border">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($kelas as $item)

                        <tr>

                            <td class="border p-3 text-center">

                                {{ $loop->iteration }}

                            </td>

                            <td class="border p-3">

                                {{ $item->nama_kelas }}

                            </td>

                            <td class="border p-3">

                                {{ $item->guru?->nama ?? '-' }}

                            </td>

                            <td class="border p-3 text-center">

                                @if($item->aktif)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded">

                                        Aktif

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded">

                                        Non Aktif

                                    </span>

                                @endif

                            </td>

                            <td class="border p-3 text-center">

                                <a href="{{ route('kelas.edit',$item->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                                    Edit

                                </a>

                                <form action="{{ route('kelas.destroy',$item->id) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Hapus kelas ini?')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center p-5 text-gray-500">

                                Belum ada data kelas.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
