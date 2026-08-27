@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            📚 {{ $modulAjar->mata_pelajaran }}
        </h1>

        <p class="text-gray-500 mt-2">
            Modul Ajar hasil analisis RPP / AI
        </p>

    </div>


    {{-- IDENTITAS --}}

    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <h2 class="text-xl font-bold mb-5">
            📋 Identitas Modul
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>
                <div class="text-sm text-gray-500">
                    Mata Pelajaran
                </div>

                <div class="font-semibold">
                    {{ $modulAjar->mata_pelajaran ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">
                    Kelas
                </div>

                <div class="font-semibold">
                    Kelas {{ $modulAjar->kelas ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">
                    Fase
                </div>

                <div class="font-semibold">
                    {{ $modulAjar->fase ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">
                    Semester
                </div>

                <div class="font-semibold">
                    {{ $modulAjar->semester ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">
                    Tahun Ajaran
                </div>

                <div class="font-semibold">
                    {{ $modulAjar->tahun_ajaran ?? '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">
                    Alokasi Waktu
                </div>

                <div class="font-semibold">
                    {{ is_array($modulAjar->alokasi_waktu)
                        ? json_encode($modulAjar->alokasi_waktu)
                        : ($modulAjar->alokasi_waktu ?? '-') }}
                </div>
            </div>

        </div>

    </div>


    {{-- BAB --}}

    @forelse($modulAjar->bab as $bab)

        <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">

            <div class="bg-indigo-600 text-white p-5">

                <div class="text-sm opacity-80">
                    BAB {{ $bab->nomor }}
                </div>

                <h2 class="text-2xl font-bold">
                    {{ $bab->judul }}
                </h2>

            </div>


            @if($bab->isi)

                <div class="p-6 border-b">

                    <h3 class="font-bold text-lg mb-3">
                        📖 Isi BAB
                    </h3>

                    <div class="whitespace-pre-line text-gray-700">
                        {{ $bab->isi }}
                    </div>

                </div>

            @endif


            <div class="p-6">

                <h3 class="font-bold text-lg mb-4">
                    🧑‍🏫 Pertemuan
                </h3>

                @forelse($bab->pertemuans as $pertemuan)

                    <div class="border rounded-xl p-5 mb-4">

                        <h4 class="font-bold text-lg mb-4">
                            Pertemuan {{ $pertemuan->nomor }}
                        </h4>

                        <div class="space-y-4">

                            <div>
                                <strong>🎯 Tujuan</strong>

                                <div class="whitespace-pre-line mt-1">
                                    {{ $pertemuan->tujuan ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <strong>📚 Materi</strong>

                                <div class="whitespace-pre-line mt-1">
                                    {{ $pertemuan->materi ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <strong>⚙️ Aktivitas</strong>

                                <div class="whitespace-pre-line mt-1">
                                    {{ $pertemuan->aktivitas ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <strong>📝 Asesmen</strong>

                                <div class="whitespace-pre-line mt-1">
                                    {{ $pertemuan->asesmen ?? '-' }}
                                </div>
                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-yellow-50 p-4 rounded-lg">
                        ⚠️ Belum ada data pertemuan.
                    </div>

                @endforelse

            </div>

        </div>

    @empty

        <div class="bg-yellow-50 p-6 rounded-xl">
            ⚠️ Belum ada BAB.
        </div>

    @endforelse


    <a
        href="{{ route('modul-ajar.index') }}"
        class="inline-block mt-4 bg-gray-600
               hover:bg-gray-700 text-white
               px-5 py-3 rounded-lg">

        ← Kembali

    </a>

</div>

@endsection