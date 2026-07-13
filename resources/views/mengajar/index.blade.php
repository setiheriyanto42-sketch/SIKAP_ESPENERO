<x-app-layout>

    <x-slot name="header">

        <h2 class="font-bold text-2xl">

            🚀 Absensi Mengajar

        </h2>

    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto">

            <div class="bg-white shadow rounded-xl p-6">

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

                    @csrf

                    <input
                        type="hidden"
                        name="sesi_id"
                        value="{{ $sesi->id }}">

                    <table class="w-full border">

                        <thead>

                            <tr class="bg-slate-100">

                                <th class="border p-3 w-16">

                                    No

                                </th>

                                <th class="border p-3 text-left">

                                    Nama Siswa

                                </th>

                                <th class="border p-3">

                                    Kehadiran

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        @foreach($siswas as $i=>$siswa)

                            <tr>

                                <td class="border p-2 text-center">

                                    {{ $loop->iteration }}

                                </td>

                                <td class="border p-2">

                                    <b>{{ $siswa->nama }}</b>

                                    <br>

                                    <small>{{ $siswa->nis }}</small>

                                </td>

                                <td class="border p-2">

                                    <input
                                        type="hidden"
                                        name="siswa_id[]"
                                        value="{{ $siswa->id }}">

                                    <div class="flex flex-wrap gap-3">

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Hadir"
                                                checked>

                                            Hadir

                                        </label>

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Izin">

                                            Izin

                                        </label>

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Sakit">

                                            Sakit

                                        </label>

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Alfa">

                                            Alfa

                                        </label>

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Terlambat">

                                            Terlambat

                                        </label>

                                        <label>

                                            <input
                                                type="radio"
                                                name="status[{{ $i }}]"
                                                value="Membolos">

                                            Membolos

                                        </label>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

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

                    <div class="flex justify-between">

                        <button

                            type="button"

                            id="btnSemuaHadir"

                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">

                            ✔ Semua Hadir

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

    }

    document.querySelectorAll("input[type=radio]").forEach(r=>{

        r.addEventListener("change",hitung);

    });

    document.getElementById("btnSemuaHadir").addEventListener("click",()=>{

        document.querySelectorAll("input[value='Hadir']").forEach(r=>{

            r.checked=true;

        });

        hitung();

    });

    hitung();

    </script>

</x-app-layout>
