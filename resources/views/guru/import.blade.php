<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            Import Data Guru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <h3 class="text-xl font-bold mb-4">
                    Upload File Excel Guru
                </h3>

                <form action="{{ route('guru.import') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="block font-semibold mb-2">
                            Pilih File Excel
                        </label>

                        <input
                            type="file"
                            name="file"
                            accept=".xlsx,.xls"
                            class="border rounded w-full p-2">

                    </div>

                    <div class="flex gap-2">

                        <button
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">

                            Import

                        </button>

                        <a href="{{ route('guru.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
