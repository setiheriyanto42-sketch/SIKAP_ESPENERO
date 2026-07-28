@extends('layouts.app')

@section('content')

    

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow rounded-xl p-6">

            <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-2xl p-6 text-white mb-6 shadow-xl">

                <div class="flex justify-between items-center flex-wrap gap-4">

                    <div>

                        <h1 class="text-3xl font-bold">

                            📚 {{ $jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}

                        </h1>

                        <p class="mt-2 text-blue-100">

                            👨‍🏫 {{ auth()->user()->guru->nama }}

                        </p>

                        <p class="text-blue-100">

                            🏫 {{ $kelas->nama_kelas }}

                        </p>

                        <p class="text-blue-100">

                            🗓️ {{ now()->translatedFormat('l, d F Y') }}

                        </p>

                    </div>

                    <div class="text-center">

                        <div class="text-sm">

                            Status

                        </div>

                        <div class="text-2xl font-bold">

                            🟢 Sedang Mengajar

                        </div>

                    </div>

                </div>

            </div>

                <div class="mb-6">

                    <h2 class="text-2xl font-bold">

                        {{ $jadwalMengajar->guruMengajar->mataPelajaran->nama_mapel }}

                    </h2>

                    <p class="text-gray-500">

                        {{ $kelas->nama_kelas }}

                        |

                        {{ $jadwalMengajar->jam_mulai }}

                        -

                        {{ $jadwalMengajar->jam_selesai }}

                    </p>

                </div>

                <form method="POST"
                      action="{{ route('mengajar.store',$jadwalMengajar) }}">

                <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

                 <div class="xl:col-span-3">

                    @csrf

                    <input
                        type="hidden"
                        name="sesi_id"
                        value="{{ $sesi->id }}">

                    <div class="mb-6">

                        <input
                            id="cariSiswa"
                            type="text"
                            placeholder="🔍 Cari nama atau NIS siswa..."
                            class="w-full border-2 border-blue-200 rounded-xl px-5 py-4 text-lg focus:ring-4 focus:ring-blue-300 focus:border-blue-500">

                    </div>

                    <div class="space-y-5">

                    @foreach($siswas as $i => $siswa)

                    <div class="card-siswa bg-white border rounded-2xl shadow transition-all duration-300

                        <input type="hidden"
                            name="siswa_id[]"
                            value="{{ $siswa->id }}">

                        <div class="flex justify-between items-start mb-4">

                            <div>

                                <h3 class="text-xl font-bold">

                                    👨‍🎓 {{ $siswa->nama }}

                                </h3>

                                <p class="text-gray-500">

                                    NIS : {{ $siswa->nis }}

                                </p>

                            </div>

                            <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                No {{ $loop->iteration }}

                            </div>

                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                            @php

                            $statusList = [

                                ['Hadir','🟢'],

                                ['Izin','🟡'],

                                ['Sakit','🔵'],

                                ['Alfa','🔴'],

                                ['Terlambat','🟠'],

                                ['Membolos','⚫']

                            ];

                            @endphp

                            @foreach($statusList as $status)

                            <label class="status-item border rounded-xl p-3 cursor-pointer hover:bg-blue-50 transition-all duration-200">

                                <input
                                class="hidden"
                                type="radio"
                                name="status[{{ $i }}]"
                                value="{{ $status[0] }}"
                                {{ $status[0]=='Hadir'?'checked':'' }}>

                                <span>

                                {{ $status[1] }}

                                {{ $status[0] }}

                                </span>

                            </label>

                            @endforeach

                        </div>

                    </div>

                    @endforeach

                    </div>

                        </div>

                        <div>

                            <div class="sticky top-6">

                                <div class="bg-white rounded-2xl shadow-lg border p-6">

                                    <h2 class="text-xl font-bold mb-5">

                                        📊 Ringkasan Absensi

                                    </h2>

                                    <div class="mt-5">

                                        <div class="flex justify-between text-sm">

                                            <span>Progress</span>

                                            <span id="progressPersen">

                                                100%

                                            </span>

                                        </div>

                                        <div class="w-full bg-gray-200 rounded-full h-3 mt-2">

                                            <div

                                                id="progressBar"

                                                class="bg-green-600 h-3 rounded-full"

                                                style="width:100%">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="space-y-4">

                                        <div class="flex justify-between">

                                            <span>🟢 Hadir</span>

                                            <span id="jmlHadir2">0</span>

                                        </div>

                                        <div class="flex justify-between">

                                            <span>🟡 Izin</span>

                                            <span id="jmlIzin2">0</span>

                                        </div>

                                        <div class="flex justify-between">

                                            <span>🔵 Sakit</span>

                                            <span id="jmlSakit2">0</span>

                                        </div>

                                        <div class="flex justify-between">

                                            <span>🔴 Alfa</span>

                                            <span id="jmlAlfa2">0</span>

                                        </div>

                                        <div class="flex justify-between">

                                            <span>🟠 Terlambat</span>

                                            <span id="jmlTerlambat2">0</span>

                                        </div>

                                        <div class="flex justify-between">

                                            <span>⚫ Membolos</span>

                                            <span id="jmlMembolos2">0</span>

                                        </div>

                                    </div>

                                    <hr class="my-5">

                                    <button
                                        class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-bold text-lg">

                                        💾 SIMPAN ABSENSI

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                    <hr class="my-6">

                    <div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-6 text-center">

                        <div class="bg-green-100 rounded-lg p-3">

                            <div class="font-bold text-green-700">

                                Hadir

                            </div>

                            <div id="jmlHadir" class="text-2xl font-bold">

                                {{ count($siswas) }}

                            </div>

                        </div>

                        <div class="bg-yellow-100 rounded-lg p-3">

                            <div class="font-bold text-yellow-700">

                                Izin

                            </div>

                            <div id="jmlIzin" class="text-2xl font-bold">

                                0

                            </div>

                        </div>

                        <div class="bg-blue-100 rounded-lg p-3">

                            <div class="font-bold text-blue-700">

                                Sakit

                            </div>

                            <div id="jmlSakit" class="text-2xl font-bold">

                                0

                            </div>

                        </div>

                        <div class="bg-red-100 rounded-lg p-3">

                            <div class="font-bold text-red-700">

                                Alfa

                            </div>

                            <div id="jmlAlfa" class="text-2xl font-bold">

                                0

                            </div>

                        </div>

                        <div class="bg-orange-100 rounded-lg p-3">

                            <div class="font-bold text-orange-700">

                                Terlambat

                            </div>

                            <div id="jmlTerlambat" class="text-2xl font-bold">

                                0

                            </div>

                        </div>

                        <div class="bg-gray-200 rounded-lg p-3">

                            <div class="font-bold">

                                Membolos

                            </div>

                            <div id="jmlMembolos" class="text-2xl font-bold">

                                0

                            </div>

                        </div>

                    </div>

                    <div class="flex flex-wrap gap-3 justify-between items-center">

                        <button

                            type="button"

                            id="btnSemuaHadir"

                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">

                            ✔ Semua Hadir

                        </button>

                        <button
                        type="button"
                        id="btnSemuaIzin"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-lg">

                        🟡 Semua Izin

                        </button>

                        <button
                        type="button"
                        id="btnSemuaSakit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg">

                        🔵 Semua Sakit

                        </button>

                        <button
                        type="button"
                        id="btnSemuaAlfa"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg">

                        🔴 Semua Alfa

                        </button>

                        <button

                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded">

                            💾 Simpan Absensi

                        </button>

                        

                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>

    .status-item{

        user-select:none;

    }

    .status-item input:checked + span{

        font-weight:bold;

    }

    </style>

    <script>

    function hitung(){

        let hadir=0;
        let izin=0;
        let sakit=0;
        let alfa=0;
        let terlambat=0;
        let membolos=0;

        document.querySelectorAll("input[type=radio]:checked").forEach(r=>{

            switch(r.value){

                case "Hadir":
                    hadir++;
                break;

                case "Izin":
                    izin++;
                break;

                case "Sakit":
                    sakit++;
                break;

                case "Alfa":
                    alfa++;
                break;

                case "Terlambat":
                    terlambat++;
                break;

                case "Membolos":
                    membolos++;
                break;

            }

        });

        document.getElementById("jmlHadir").innerHTML=hadir;
        document.getElementById("jmlIzin").innerHTML=izin;
        document.getElementById("jmlSakit").innerHTML=sakit;
        document.getElementById("jmlAlfa").innerHTML=alfa;
        document.getElementById("jmlTerlambat").innerHTML=terlambat;
        document.getElementById("jmlMembolos").innerHTML=membolos;

    const total = hadir + izin + sakit + alfa + terlambat + membolos;

    const persen = Math.round((total / {{ count($siswas) }}) * 100);

    document.getElementById("progressBar").style.width = persen + "%";

    document.getElementById("progressPersen").innerHTML = persen + "%";

    }

    document.querySelectorAll("input[type=radio]").forEach(r=>{

        r.addEventListener("change",hitung);

    });

        document.getElementById("btnSemuaHadir").onclick=function(){

        pilihSemua("Hadir");

    };

        hitung();

        
            const cari = document.getElementById('cariSiswa');

        cari.addEventListener('keyup', function(){

            let keyword = this.value.toLowerCase();

            document.querySelectorAll('.card-siswa').forEach(card=>{

                let teks = card.innerText.toLowerCase();

                if(teks.includes(keyword)){

                    card.style.display='block';

                }else{

                    card.style.display='none';

                }

            });

        });

    document.querySelectorAll("input[type=radio]").forEach(radio=>{

    radio.addEventListener("change",function(){

            const card = this.closest(".card-siswa");

            card.classList.remove(
                "bg-green-50",
                "bg-yellow-50",
                "bg-blue-50",
                "bg-red-50",
                "bg-orange-50",
                "bg-gray-100"
            );

            switch(this.value){

                case "Hadir":
                    card.classList.add("bg-green-50");
                break;

                case "Izin":
                    card.classList.add("bg-yellow-50");
                break;

                case "Sakit":
                    card.classList.add("bg-blue-50");
                break;

                case "Alfa":
                    card.classList.add("bg-red-50");
                break;

                case "Terlambat":
                    card.classList.add("bg-orange-50");
                break;

                case "Membolos":
                    card.classList.add("bg-gray-100");
                break;

            }

        });

    });

    function pilihSemua(status){

        document.querySelectorAll("input[value='"+status+"']").forEach(r=>{

            r.checked=true;

            r.dispatchEvent(new Event('change'));

        });

        hitung();

    }

    document.getElementById("btnSemuaIzin").onclick=function(){

        pilihSemua("Izin");

    };

    document.getElementById("btnSemuaSakit").onclick=function(){

        pilihSemua("Sakit");

    };

    document.getElementById("btnSemuaAlfa").onclick=function(){

        pilihSemua("Alfa");

    };

    </script>

@endsection
