<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            ⭐ Penilaian Sikap Siswa
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white rounded-xl shadow p-6">

                <div class="mb-6">

                    <h3 class="text-xl font-bold">
                        {{ $sesiMengajar->jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}
                    </h3>

                    <p>
                        Kelas :
                        {{ $sesiMengajar->jadwalMengajar->guruMengajar->kelas->nama_kelas }}
                    </p>

                    <p>
                        Tanggal :
                        {{ $sesiMengajar->tanggal->format('d-m-Y') }}
                    </p>

                </div>

                <form
                    action="{{ route('penilaian.store',$sesiMengajar) }}"
                    method="POST">

                    @csrf

                    <table class="min-w-full border">

                        <thead class="bg-blue-600 text-white">

                            <tr>

                                <th class="border px-3 py-2">No</th>

                                <th class="border px-3 py-2">Nama Siswa</th>

                                <th class="border px-3 py-2">Predikat</th>

                                <th class="border px-3 py-2">Catatan</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($kehadirans as $no => $hadir)

                                <tr>

                                    <td class="border px-3 py-2 text-center">

                                        {{ $no+1 }}

                                    </td>

                                    <td class="border px-3 py-2">

                                        {{ $hadir->siswa->nama }}

                                    </td>

                                    <td class="border px-3 py-2">

                                        <select
                                            name="predikat[{{ $hadir->siswa_id }}]"
                                            class="border rounded w-full">

                                            <option value="Sangat Baik">
                                                Sangat Baik
                                            </option>

                                            <option value="Baik" selected>
                                                Baik
                                            </option>

                                            <option value="Cukup">
                                                Cukup
                                            </option>

                                            <option value="Perlu Pembinaan">
                                                Perlu Pembinaan
                                            </option>

                                        </select>

                                    </td>

                                    <td class="border px-3 py-2">

                                        <input
                                            type="text"
                                            name="catatan[{{ $hadir->siswa_id }}]"
                                            class="border rounded w-full"
                                            placeholder="Catatan Guru">

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <div class="mt-6 text-right">

                        <button
                            type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                            💾 Simpan Penilaian

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
