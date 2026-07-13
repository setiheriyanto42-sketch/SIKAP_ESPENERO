<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            🎓 Dashboard SIKAP ESPENERO
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg text-white p-6 mb-6">

                <h1 class="text-3xl font-bold">
                    Selamat Datang,
                    {{ $user->guru->nama ?? $user->name }}
                </h1>

                <p class="mt-2">
                    Sistem Informasi Kehadiran dan Karakter
                </p>

                @if($data['tahunAktif'])

                    <div class="mt-4">

                        <span class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold">

                            Tahun Ajaran :
                            {{ $data['tahunAktif']->tahun_ajaran }}
                            |
                            Semester
                            {{ $data['tahunAktif']->semester }}

                        </span>

                    </div>

                @endif

            </div>

            {{-- DASHBOARD ADMIN --}}
            @if($user->isAdmin())

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div class="bg-blue-600 text-white rounded-xl shadow p-5">

                        <div>Guru</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jumlahGuru'] }}

                        </div>

                    </div>

                    <div class="bg-green-600 text-white rounded-xl shadow p-5">

                        <div>Siswa</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jumlahSiswa'] }}

                        </div>

                    </div>

                    <div class="bg-yellow-500 text-white rounded-xl shadow p-5">

                        <div>Kelas</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jumlahKelas'] }}

                        </div>

                    </div>

                    <div class="bg-red-600 text-white rounded-xl shadow p-5">

                        <div>Mata Pelajaran</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jumlahMapel'] }}

                        </div>

                    </div>

                </div>

            @endif


            {{-- DASHBOARD GURU --}}
            @if($user->guru)

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">

                    <div class="bg-blue-600 text-white rounded-xl shadow p-5">

                        <div>Jam Mengajar</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jamMengajar'] }}

                        </div>

                    </div>

                    <div class="bg-green-600 text-white rounded-xl shadow p-5">

                        <div>Kelas Diampu</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['kelasDiampu'] }}

                        </div>

                    </div>

                    <div class="bg-yellow-500 text-white rounded-xl shadow p-5">

                        <div>Siswa Diampu</div>

                        <div class="text-4xl font-bold mt-2">

                            {{ $data['jumlahSiswaDiampu'] }}

                        </div>

                    </div>

                </div>

            @endif


            {{-- WALI KELAS --}}
            @if($data['isWaliKelas'])

                <div class="bg-green-100 border border-green-400 rounded-xl p-5 mt-6">

                    <h2 class="text-2xl font-bold text-green-700">

                        ⭐ Anda adalah Wali Kelas

                    </h2>

                    <p class="mt-2">

                        {{ $data['kelasPerwalian']->nama_kelas }}

                    </p>

                </div>

            @endif


            {{-- JADWAL HARI INI --}}
            @if($user->guru)

                <div class="bg-white rounded-xl shadow mt-6 p-6">

                    <h2 class="text-2xl font-bold mb-5">

                        📅 Jadwal Mengajar Hari Ini

                    </h2>

                    @forelse($jadwalHariIni as $jadwal)

                        <div class="border rounded-xl p-5 mb-4">

                            <div class="flex justify-between items-center">

                                <div>

                                    <h3 class="text-xl font-bold">

                                        {{ $jadwal->guruMengajar->mataPelajaran->nama_mapel }}

                                    </h3>

                                    <p>

                                        {{ $jadwal->guruMengajar->kelas->nama_kelas }}

                                    </p>

                                    <p class="text-gray-500">

                                        {{ $jadwal->jam_mulai }}

                                        -

                                        {{ $jadwal->jam_selesai }}

                                    </p>

                                </div>

                                <div class="text-right">

                                    @if($jadwal->status_sesi=='Belum')

                                        <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full mb-3">

                                            ⚪ BELUM DIMULAI

                                        </span>

                                        <br>

                                        <a
                                            href="{{ route('sesi.mulai',$jadwal) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                                            🚀 MULAI MENGAJAR

                                        </a>

                                    @elseif($jadwal->status_sesi=='Sedang')

                                        <span class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full mb-3">

                                            🟡 SEDANG MENGAJAR

                                        </span>

                                        <br>

                                        <a
                                            href="{{ route('mengajar.index',$jadwal) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

                                            ▶ LANJUTKAN

                                        </a>

                                    @elseif($jadwal->status_sesi=='Selesai')

                                        <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full mb-3">

                                            ✅ SELESAI

                                        </span>

                                        <br>

                                        <button
                                            class="bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed"
                                            disabled>

                                            ✔ SUDAH SELESAI

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center text-gray-500">

                            Tidak ada jadwal mengajar hari ini.

                        </div>

                    @endforelse

                </div>

            @endif

        </div>
    </div>

</x-app-layout>
