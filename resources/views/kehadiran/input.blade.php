<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Input Kehadiran Harian
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <h3 class="text-xl font-bold mb-6">
                    Input Kehadiran Siswa
                </h3>

                {{-- FORM PILIH KELAS --}}
                <form method="GET" action="{{ route('kehadiran.input') }}">

                    <div class="grid md:grid-cols-3 gap-4">

                        <div>
                            <label class="font-semibold">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                value="{{ request('tanggal', date('Y-m-d')) }}"
                                class="border rounded w-full p-2">
                        </div>

                        <div>
                            <label class="font-semibold">
                                Kelas
                            </label>

                            <select
                                name="kelas_id"
                                onchange="this.form.submit()"
                                class="border rounded w-full p-2">

                                <option value="">
                                    -- Pilih Kelas --
                                </option>

                                @foreach($kelas as $k)

                                    <option
                                        value="{{ $k->id }}"
                                        {{ request('kelas_id')==$k->id ? 'selected' : '' }}>

                                        {{ $k->nama_kelas }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="font-semibold">

                                Mata Pelajaran

                            </label>

                            <select
                            name="mapel_id"
                            class="border rounded w-full p-2"
                            onchange="this.form.submit()">

                            <option value="">-- Pilih Mata Pelajaran --</option>

                            @foreach($mapel as $m)

                            <option
                            value="{{ $m->id }}"
                            {{ request('mapel_id')==$m->id?'selected':'' }}>

                            {{ $m->nama_mapel }}

                            </option>

                            @endforeach

                            </select>

                        </div>

                    </div>

                </form>

                <hr class="my-6">

                @if(count($siswas))

                    <form method="POST"
                          action="{{ route('kehadiran.simpan') }}">

                        @csrf

                        <input
                            type="hidden"
                            name="tanggal"
                            value="{{ request('tanggal', date('Y-m-d')) }}">

                        <input
                            type="hidden"
                            name="kelas_id"
                            value="{{ request('kelas_id') }}">

                        <input
                            type="hidden"
                            name="mapel_id"
                            value="{{ request('mapel_id') }}">

                        @foreach($siswas as $siswa)

                            <div class="flex justify-between items-center border rounded-lg p-3 mb-2">

                                <div>

                                    <strong>

                                        {{ $siswa->nama }}

                                    </strong>

                                    <br>

                                    <small>

                                        NIS {{ $siswa->nis }}

                                    </small>

                                </div>

                                <div class="flex items-center gap-3">

                                    <input
                                        type="hidden"
                                        name="siswa_id[]"
                                        value="{{ $siswa->id }}">

                                    <select
                                        name="status[]"
                                        class="border rounded p-2">

                                        <option value="Hadir" selected>Hadir</option>

                                        <option value="Izin">Izin</option>

                                        <option value="Sakit">Sakit</option>

                                        <option value="Alfa">Alfa</option>

                                        <option value="Membolos">Membolos</option>

                                    </select>

                                </div>

                            </div>

                        @endforeach

                        <button
                            type="submit"
                            class="mt-5 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded">

                            💾 Simpan Kehadiran

                        </button>

                    </form>

                @else

                    <div class="bg-yellow-100 border border-yellow-400 p-4 rounded">

                        Silakan pilih kelas terlebih dahulu.

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
