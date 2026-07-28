@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">
        Tambah Template Jam Pelajaran
    </h2>

    <form action="{{ route('template-jam.store') }}" method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>Nama Template</label>

                <input type="text"
                    name="nama_template"
                    class="w-full border rounded p-2"
                    placeholder="Contoh : Reguler">
            </div>

            <div>
                <label>JP</label>

                <input type="number"
                    name="jp"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label>Jam Mulai</label>

                <input type="time"
                    name="jam_mulai"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label>Jam Selesai</label>

                <input type="time"
                    name="jam_selesai"
                    class="w-full border rounded p-2">
            </div>

            <div>

                <label>Jenis</label>

                <select
                    name="jenis"
                    class="w-full border rounded p-2">

                    <option value="sambut_pagi">Sambut Pagi</option>
                    <option value="pembiasaan_pagi">Pembiasaan Pagi</option>
                    <option value="belajar">Belajar</option>
                    <option value="istirahat_1">Istirahat 1</option>
                    <option value="istirahat_2">Istirahat 2</option>
                    <option value="ishoma">Ishoma</option>
                    <option value="upacara">Upacara</option>
                    <option value="senam">Senam</option>
                    <option value="kegiatan">Kegiatan Khusus</option>
                    <option value="pulang">Pulang</option>

                </select>

            </div>

            <div>

                <label>Urutan</label>

                <input type="number"
                    name="urutan"
                    value="1"
                    class="w-full border rounded p-2">

            </div>

        </div>

        <div class="mt-6">

            <button
                class="bg-blue-600 text-white px-6 py-2 rounded">

                Simpan

            </button>

        </div>

    </form>

</div>

@endsection