@extends('layouts.app')

@section('content')

<div class="py-6">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                📦 Import Data Siswa
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Import data siswa dari file Excel ke database SIKAP ESPENERO.
            </p>
        </div>


        {{-- PESAN SUKSES --}}
        @if(session('success'))

            <div class="mb-6 bg-green-50 border border-green-200
                        text-green-700 px-5 py-4 rounded-xl">

                <div class="font-semibold">
                    ✅ Berhasil
                </div>

                <div class="text-sm mt-1">
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- PESAN ERROR --}}
        @if($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200
                        text-red-700 px-5 py-4 rounded-xl">

                <div class="font-semibold mb-2">
                    ❌ Terjadi Kesalahan
                </div>

                <ul class="list-disc ml-5 text-sm">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif



        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- =====================================================
                 PANEL UPLOAD
            ====================================================== --}}

            <div class="lg:col-span-2">

                <div class="bg-white rounded-2xl shadow-sm
                            border border-gray-200 overflow-hidden">

                    {{-- JUDUL --}}
                    <div class="px-6 py-5 border-b border-gray-200">

                        <h3 class="text-xl font-bold text-gray-800">
                            📊 Upload File Excel Siswa
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Pilih file Excel yang berisi data siswa.
                        </p>

                    </div>


                    {{-- FORM --}}
                    <form
                        id="importForm"
                        action="{{ route('siswa.import') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="p-6">


                            {{-- AREA FILE --}}
                            <div>

                                <label class="block text-sm font-semibold
                                              text-gray-700 mb-3">

                                    📁 Pilih File Excel

                                </label>


                                <label
                                    for="fileInput"
                                    id="dropZone"
                                    class="relative flex flex-col items-center
                                           justify-center w-full min-h-[190px]
                                           border-2 border-dashed
                                           border-gray-300 rounded-2xl
                                           bg-gray-50
                                           hover:bg-blue-50
                                           hover:border-blue-400
                                           cursor-pointer
                                           transition duration-200">

                                    {{-- ICON --}}
                                    <div class="text-5xl mb-3">
                                        📁
                                    </div>


                                    {{-- TEXT --}}
                                    <div
                                        id="uploadText"
                                        class="text-center">

                                        <p class="font-semibold text-gray-700">
                                            Klik untuk memilih file Excel
                                        </p>

                                        <p class="text-sm text-gray-500 mt-1">
                                            atau tarik file Excel ke area ini
                                        </p>

                                        <p class="text-xs text-gray-400 mt-2">
                                            Format: .xlsx atau .xls
                                        </p>

                                    </div>


                                    {{-- NAMA FILE --}}
                                    <div
                                        id="fileName"
                                        class="hidden mt-3
                                               text-sm font-semibold
                                               text-blue-600 text-center">
                                    </div>


                                    {{-- INPUT FILE --}}
                                    <input
                                        id="fileInput"
                                        type="file"
                                        name="file"
                                        accept=".xlsx,.xls"
                                        required
                                        class="hidden">

                                </label>

                            </div>



                            {{-- TOMBOL --}}
                            <div class="flex flex-wrap gap-3 mt-6">


                                {{-- PREVIEW --}}
                                <button
                                    type="button"
                                    id="btnPreview"
                                    class="inline-flex items-center
                                           justify-center gap-2
                                           bg-blue-600 hover:bg-blue-700
                                           text-white font-semibold
                                           px-6 py-3 rounded-lg
                                           transition">

                                    👁️ Preview

                                </button>


                                {{-- IMPORT --}}
                                <button
                                    type="submit"
                                    id="btnImport"
                                    class="inline-flex items-center
                                           justify-center gap-2
                                           bg-green-600 hover:bg-green-700
                                           text-white font-semibold
                                           px-6 py-3 rounded-lg
                                           transition">

                                    📥 Import Data

                                </button>


                                {{-- KEMBALI --}}
                                <a
                                    href="{{ route('siswa.index') }}"
                                    class="inline-flex items-center
                                           justify-center gap-2
                                           bg-gray-500 hover:bg-gray-600
                                           text-white font-semibold
                                           px-6 py-3 rounded-lg
                                           transition">

                                    ↩️ Kembali

                                </a>

                            </div>


                            {{-- PREVIEW --}}
                            <div
                                id="preview-area"
                                class="mt-8">
                            </div>


                        </div>

                    </form>

                </div>

            </div>



            {{-- =====================================================
                 PANEL FORMAT EXCEL
            ====================================================== --}}

            <div>

                <div class="bg-blue-50 border border-blue-200
                            rounded-2xl overflow-hidden">


                    {{-- HEADER --}}
                    <div class="px-6 py-5">

                        <h3 class="text-lg font-bold text-gray-800">
                            📄 Format Excel
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">
                            Gunakan kolom berikut pada file Excel:
                        </p>

                    </div>


                    {{-- KOLOM --}}
                    <div class="px-6 pb-5">

                        <div class="bg-white rounded-xl
                                    border border-gray-200
                                    overflow-hidden">

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    NIS
                                </span>
                            </div>

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    NISN
                                </span>
                            </div>

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    Nama
                                </span>
                            </div>

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    Jenis Kelamin
                                </span>
                            </div>

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    Kelas
                                </span>
                            </div>

                            <div class="px-4 py-3 border-b">
                                <span class="font-semibold text-sm">
                                    No HP
                                </span>
                            </div>

                            <div class="px-4 py-3">
                                <span class="font-semibold text-sm">
                                    Alamat
                                </span>
                            </div>

                        </div>


                        {{-- DOWNLOAD --}}
                        <a
                            href="{{ route('siswa.template') }}"
                            class="mt-5 flex items-center
                                   justify-center gap-2
                                   w-full bg-blue-600
                                   hover:bg-blue-700
                                   text-white font-semibold
                                   py-3 px-4 rounded-lg
                                   transition">

                            ⬇️ Download Template Excel

                        </a>


                        {{-- PETUNJUK --}}
                        <div class="mt-5 bg-white
                                    border border-gray-200
                                    rounded-xl p-4">

                            <h4 class="font-semibold text-gray-800 mb-3">
                                💡 Petunjuk
                            </h4>

                            <ol class="text-sm text-gray-600
                                       space-y-2 list-decimal ml-5">

                                <li>
                                    Download template Excel.
                                </li>

                                <li>
                                    Isi data siswa sesuai kolom.
                                </li>

                                <li>
                                    Simpan file dalam format
                                    <b>.xlsx</b> atau <b>.xls</b>.
                                </li>

                                <li>
                                    Pilih file Excel pada kotak upload.
                                </li>

                                <li>
                                    Klik <b>Preview</b> untuk memeriksa data.
                                </li>

                                <li>
                                    Jika sudah benar, klik
                                    <b>Import Data</b>.
                                </li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileName = document.getElementById('fileName');
    const uploadText = document.getElementById('uploadText');
    const btnPreview = document.getElementById('btnPreview');
    const importForm = document.getElementById('importForm');
    const btnImport = document.getElementById('btnImport');
    const previewArea = document.getElementById('preview-area');


    // =========================================================
    // TAMPILKAN NAMA FILE
    // =========================================================

    fileInput.addEventListener('change', function () {

        if (this.files.length > 0) {

            const file = this.files[0];

            uploadText.classList.add('hidden');

            fileName.classList.remove('hidden');

            fileName.innerHTML =
                '📄 ' + file.name;

        }

    });


    // =========================================================
    // DRAG & DROP
    // =========================================================

    dropZone.addEventListener('dragover', function (e) {

        e.preventDefault();

        dropZone.classList.add(
            'border-blue-500',
            'bg-blue-50'
        );

    });


    dropZone.addEventListener('dragleave', function () {

        dropZone.classList.remove(
            'border-blue-500',
            'bg-blue-50'
        );

    });


    dropZone.addEventListener('drop', function (e) {

        e.preventDefault();

        dropZone.classList.remove(
            'border-blue-500',
            'bg-blue-50'
        );


        if (e.dataTransfer.files.length > 0) {

            fileInput.files = e.dataTransfer.files;

            const file = e.dataTransfer.files[0];

            uploadText.classList.add('hidden');

            fileName.classList.remove('hidden');

            fileName.innerHTML =
                '📄 ' + file.name;

        }

    });


    // =========================================================
    // PREVIEW
    // =========================================================

    btnPreview.addEventListener('click', async function () {

        if (!fileInput.files.length) {

            alert('⚠️ Pilih file Excel terlebih dahulu.');

            return;

        }


        const formData = new FormData();

        formData.append(
            'file',
            fileInput.files[0]
        );

        formData.append(
            '_token',
            '{{ csrf_token() }}'
        );


        btnPreview.disabled = true;

        btnPreview.innerHTML =
            '⏳ Memproses...';


        try {

            const response = await fetch(
                "{{ route('siswa.preview') }}",
                {
                    method: 'POST',

                    body: formData,

                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );


            if (!response.ok) {

                throw new Error(
                    'Preview gagal diproses.'
                );

            }


            const data = await response.json();


            let html = `

                <div class="border border-gray-200
                            rounded-xl overflow-hidden">

                    <div class="bg-gray-50
                                px-5 py-4
                                flex justify-between
                                items-center">

                        <div>

                            <h3 class="font-bold text-lg
                                       text-gray-800">

                                📋 Preview Data Siswa

                            </h3>

                            <p class="text-sm text-gray-500">

                                Periksa data sebelum melakukan import.

                            </p>

                        </div>

                        <span class="bg-blue-600
                                     text-white
                                     px-3 py-1
                                     rounded-lg
                                     text-sm
                                     font-semibold">

                            ${data.length} Data

                        </span>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="min-w-full
                                      text-sm">

                            <thead>

                                <tr class="bg-blue-600
                                           text-white">

                                    <th class="px-4 py-3 text-center">
                                        No
                                    </th>

                                    <th class="px-4 py-3">
                                        NIS
                                    </th>

                                    <th class="px-4 py-3">
                                        NISN
                                    </th>

                                    <th class="px-4 py-3">
                                        Nama
                                    </th>

                                    <th class="px-4 py-3">
                                        JK
                                    </th>

                                    <th class="px-4 py-3">
                                        Kelas
                                    </th>

                                    <th class="px-4 py-3">
                                        No HP
                                    </th>

                                    <th class="px-4 py-3">
                                        Alamat
                                    </th>

                                </tr>

                            </thead>

                            <tbody>
            `;


            data.forEach(function (row, index) {

                html += `

                    <tr class="border-b
                               hover:bg-gray-50">

                        <td class="px-4 py-3 text-center">
                            ${index + 1}
                        </td>

                        <td class="px-4 py-3">
                            ${row[0] ?? ''}
                        </td>

                        <td class="px-4 py-3">
                            ${row[1] ?? ''}
                        </td>

                        <td class="px-4 py-3 font-medium">
                            ${row[2] ?? ''}
                        </td>

                        <td class="px-4 py-3 text-center">
                            ${row[3] ?? ''}
                        </td>

                        <td class="px-4 py-3 text-center">
                            ${row[4] ?? ''}
                        </td>

                        <td class="px-4 py-3">
                            ${row[5] ?? ''}
                        </td>

                        <td class="px-4 py-3">
                            ${row[6] ?? ''}
                        </td>

                    </tr>

                `;

            });


            html += `

                            </tbody>

                        </table>

                    </div>

                </div>

            `;


            previewArea.innerHTML = html;


            // Scroll ke preview
            previewArea.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });


        } catch (error) {

            alert(
                '❌ ' + error.message
            );

            console.error(error);

        } finally {

            btnPreview.disabled = false;

            btnPreview.innerHTML =
                '👁️ Preview';

        }

    });


    // =========================================================
    // PROTEKSI SAAT IMPORT
    // =========================================================

    importForm.addEventListener('submit', function () {

        if (!fileInput.files.length) {

            alert(
                '⚠️ Pilih file Excel terlebih dahulu.'
            );

            return;

        }


        btnImport.disabled = true;

        btnImport.innerHTML =
            '⏳ Mengimport Data...';

    });

});

</script>

@endsection