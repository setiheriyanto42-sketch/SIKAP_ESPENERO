@extends('layouts.app')
@section('content')

    <div class="py-6">
    <div class="w-full px-6">

            {{-- HEADER --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 rounded-2xl shadow-xl p-8 mb-8 text-white">

                <h1 class="text-4xl font-extrabold tracking-wide">
                    Selamat Datang,
                    {{ $user->guru->nama ?? $user->name }}
                </h1>

                <div class="mt-3 flex flex-wrap gap-3">

                    <span class="bg-white/20 px-4 py-2 rounded-full">

                        👨‍🏫
                        {{ $user->guru->jabatan ?? 'Guru' }}

                    </span>

                    <span class="bg-white/20 px-4 py-2 rounded-full">

                        📅
                        {{ now()->translatedFormat('l, d F Y') }}

                    </span>

                </div>

                <p class="mt-3 text-blue-100 text-lg">
                    Sistem Informasi Kehadiran dan Karakter
                </p>

                <div class="mt-4">
                    <span class="inline-flex items-center gap-2 bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold shadow">

                        <span class="text-green-500 text-xl">🟢</span>

                        Tahun Pelajaran
                        <strong>{{ $data['tahunAjaran'] }}</strong>

                        |

                        Semester
                        <strong>{{ $data['semester'] }}</strong>

                        |

                        <span class="text-green-600 font-bold">
                            {{ $data['statusTA'] }}
                        </span>

                    </span>
                </div>

            </div>

            {{-- DASHBOARD ADMIN --}}
            @if($user->isAdmin())

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    <!-- Tahun Pelajaran -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl shadow-lg p-5">

                        <div class="text-sm opacity-90">
                            📚 Tahun Pelajaran Aktif
                        </div>

                        <div class="text-2xl font-bold mt-2">
                            {{ $data['tahunAjaran'] }}
                        </div>

                        <div class="mt-2">
                            Semester {{ $data['semester'] }}
                        </div>

                        <div class="mt-3 text-green-200 font-semibold">
                            🟢 {{ $data['statusTA'] }}
                        </div>

                    </div>

                    <!-- Guru -->
                    <div class="bg-blue-600 text-white rounded-xl shadow-lg p-5">

                        <div class="text-sm">
                            👨‍🏫 Guru
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['jumlahGuru'] }}
                        </div>

                    </div>

                    <!-- Siswa -->
                    <div class="bg-green-600 text-white rounded-xl shadow-lg p-5">

                        <div class="text-sm">
                            👨‍🎓 Siswa
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['jumlahSiswa'] }}
                        </div>

                    </div>

                    <!-- Kelas -->
                    <div class="bg-yellow-500 text-white rounded-xl shadow-lg p-5">

                        <div class="text-sm">
                            🏫 Kelas
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['jumlahKelas'] }}
                        </div>

                    </div>

                </div>

            @endif


            {{-- DASHBOARD GURU --}}
            @if($user->guru)

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">

                    <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl shadow-lg text-white p-6">

                        <div class="text-sm opacity-90">
                            📚 Jadwal Mengajar
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['jamMengajar'] }}
                        </div>

                        <div class="text-sm mt-2">
                            JP Terjadwal
                        </div>

                    </div>

                    <div class="bg-gradient-to-r from-green-500 to-green-700 rounded-2xl shadow-lg text-white p-6">

                        <div class="text-sm opacity-90">
                            🏫 Kelas Diampu
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['kelasDiampu'] }}
                        </div>

                        <div class="text-sm mt-2">
                            Kelas Aktif
                        </div>

                    </div>

                    <div class="bg-gradient-to-r from-orange-500 to-orange-700 rounded-2xl shadow-lg text-white p-6">

                        <div class="text-sm opacity-90">
                            👨‍🎓 Siswa Diampu
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $data['jumlahSiswaDiampu'] }}
                        </div>

                        <div class="text-sm mt-2">
                            Total Siswa
                        </div>

                    </div>

                    <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-2xl shadow-lg text-white p-6">

                        <div class="text-sm opacity-90">
                            📝 Jurnal Belum Diisi
                        </div>

                        <div class="text-4xl font-bold mt-3">
                            {{ $jurnalBelum }}
                        </div>

                        <div class="text-sm mt-2">
                            Hari Ini
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

                    <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 mb-5">

                        <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">

                            <div class="flex items-start gap-5">

                                <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-3xl shadow-lg">
                                    📚
                                </div>

                                <div>

                                    <h3 class="text-2xl font-bold text-gray-800">
                                        {{ $jadwal->guruMengajar->mataPelajaran->nama_mapel }}
                                    </h3>

                                    <p class="text-gray-600 mt-1">
                                        🏫 {{ $jadwal->guruMengajar->kelas->nama_kelas }}
                                    </p>

                                    <p class="text-gray-500">
                                        🕒 {{ substr($jadwal->jam_mulai,0,5) }}
                                        -
                                        {{ substr($jadwal->jam_selesai,0,5) }}
                                    </p>

                                </div>

                            </div>

                            <div class="text-center lg:text-right">

                                @if($jadwal->status_sesi=='Belum')

                                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                        ⚪ Belum Dimulai
                                    </span>

                                    <div class="mt-4">

                                        <a href="{{ route('sesi.mulai',$jadwal) }}"
                                        class="inline-block bg-green-600 hover:bg-green-700 transition text-white px-6 py-3 rounded-xl shadow-lg">

                                            🚀 MULAI MENGAJAR

                                        </a>

                                    </div>

                                @elseif($jadwal->status_sesi=='Sedang')

                                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                        🟡 Sedang Mengajar
                                    </span>

                                    <div class="mt-4">

                                        <a href="{{ route('mengajar.index',$jadwal) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 transition text-white px-6 py-3 rounded-xl shadow-lg">

                                            ▶ LANJUTKAN

                                        </a>

                                    </div>

                                @elseif($jadwal->status_sesi=='Selesai')

                                    <span class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold">
                                        ✅ Selesai
                                    </span>

                                    <div class="mt-4">

                                        <button
                                            class="bg-gray-400 text-white px-6 py-3 rounded-xl cursor-not-allowed"
                                            disabled>

                                            ✔ SUDAH SELESAI

                                        </button>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">

                        <div class="text-6xl mb-4">
                            📅
                        </div>

                        <h2 class="text-2xl font-bold text-gray-700">
                            Tidak Ada Jadwal Mengajar Hari Ini
                        </h2>

                        <p class="text-gray-500 mt-3">
                            Selamat menikmati waktu luang atau persiapkan materi untuk pertemuan berikutnya.
                        </p>

                    </div>

                    @endforelse

                </div>

            @endif

        </div>
    </div>

@endsection
