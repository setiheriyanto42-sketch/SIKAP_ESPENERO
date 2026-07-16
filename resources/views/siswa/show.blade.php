<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold text-gray-900">
        👨‍🎓 Detail Siswa
    </h2>
</x-slot>

<div class="py-6">

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<div class="bg-sky-600 text-white px-8 py-5">

<h3 class="text-3xl font-bold">

👨‍🎓 Profil Siswa

</h3>

<p class="text-sky-100">

Informasi lengkap data siswa

</p>

</div>

<div class="p-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- =========================
             DATA SISWA
        ========================== --}}
        <div class="lg:col-span-2">

            <div class="grid grid-cols-2 gap-5">

                <div>
                    <label class="font-semibold text-gray-500">NIS</label>
                    <div class="text-lg">{{ $siswa->nis }}</div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">NISN</label>
                    <div class="text-lg">{{ $siswa->nisn }}</div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Nama</label>
                    <div class="text-lg font-bold text-sky-700">
                        {{ $siswa->nama }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Jenis Kelamin</label>
                    <div class="text-lg">
                        {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Tempat Lahir</label>
                    <div class="text-lg">
                        {{ $siswa->tempat_lahir ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Tanggal Lahir</label>
                    <div class="text-lg">
                        {{ $siswa->tanggal_lahir ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Agama</label>
                    <div class="text-lg">
                        {{ $siswa->agama ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Kelas</label>
                    <div class="text-lg">
                        {{ $siswa->kelas }}{{ $siswa->rombel }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Nama Ayah</label>
                    <div class="text-lg">
                        {{ $siswa->nama_ayah ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Nama Ibu</label>
                    <div class="text-lg">
                        {{ $siswa->nama_ibu ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">No HP</label>
                    <div class="text-lg">
                        {{ $siswa->no_hp ?? '-' }}
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500">Status</label>

                    <div class="mt-1">

                        @if($siswa->aktif)

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                Aktif
                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                Non Aktif
                            </span>

                        @endif

                    </div>

                </div>

                <div class="col-span-2">

                    <label class="font-semibold text-gray-500">
                        Alamat
                    </label>

                    <div class="text-lg">
                        {{ $siswa->alamat ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        {{-- =========================
             FOTO SISWA
        ========================== --}}
        <div class="flex flex-col items-center">

            @if($siswa->foto)

                <img
                    src="{{ asset('storage/'.$siswa->foto) }}"
                    class="w-56 h-72 object-cover rounded-xl shadow-xl border-4 border-sky-500">

            @else

                <img
                    src="https://placehold.co/220x300/e2e8f0/64748b?text=Belum+Ada+Foto"
                    class="w-56 h-72 object-cover rounded-xl shadow-xl">

            @endif

            <div class="mt-4 text-center">

                <h3 class="text-xl font-bold text-sky-700">
                    {{ $siswa->nama }}
                </h3>

                <p class="text-gray-500">
                    {{ $siswa->kelas }}{{ $siswa->rombel }}
                </p>

            </div>

        </div>

    </div>

    <hr class="my-8">

    <div class="flex gap-3">

        <a
            href="{{ route('siswa.edit',$siswa) }}"
            class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg shadow">

            ✏ Edit

        </a>

        <a
            href="{{ route('siswa.index') }}"
            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg shadow">

            ⬅ Kembali

        </a>

    </div>

</div>

</div>

</div>

</div>

</x-app-layout>
