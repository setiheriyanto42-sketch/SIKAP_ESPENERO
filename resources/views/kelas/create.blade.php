<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Tambah Kelas
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-4 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('kelas.store') }}">

                    @csrf

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Tingkat
                        </label>

                        <select name="tingkat"
                                class="border rounded w-full p-2"
                                required>

                            <option value="">-- Pilih Tingkat --</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Rombel
                        </label>

                        <select name="rombel"
                                class="border rounded w-full p-2"
                                required>

                            <option value="">-- Pilih Rombel --</option>

                            @foreach(range('A','F') as $rombel)

                                <option value="{{ $rombel }}">

                                    {{ $rombel }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Wali Kelas
                        </label>

                        <select name="guru_id"
                                class="border rounded w-full p-2">

                            <option value="">
                                -- Belum Ditentukan --
                            </option>

                            @foreach($gurus as $guru)

                                <option value="{{ $guru->id }}">

                                    {{ $guru->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

                            💾 Simpan

                        </button>

                        <a href="{{ route('kelas.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
