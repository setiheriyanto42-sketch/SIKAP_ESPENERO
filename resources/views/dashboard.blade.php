<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            🎓 SIKAP ESPENERO
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-2xl font-bold text-blue-700">
                    Sistem Informasi Kehadiran dan Karakter
                </h2>

                <p class="text-gray-600">
                    SMP Negeri 2 Jatiroto
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-blue-500 text-gray rounded-lg p-5">
                    <h3 class="text-lg font-bold">👨‍🏫 Guru</h3>
                    <p class="text-3xl mt-2">0</p>
                </div>

                <div class="bg-green-500 text-gray rounded-lg p-5">
                    <h3 class="text-lg font-bold">👨‍🎓 Siswa</h3>
                    <p class="text-3xl mt-2">0</p>
                </div>

                <div class="bg-yellow-500 text-gray rounded-lg p-5">
                    <h3 class="text-lg font-bold">🏫 Kelas</h3>
                    <p class="text-3xl mt-2">18</p>
                </div>

                <div class="bg-red-500 text-gray rounded-lg p-5">
                    <h3 class="text-lg font-bold">📚 Mata Pelajaran</h3>
                    <p class="text-3xl mt-2">11</p>
                </div>

            </div>

            <div class="mt-8 bg-white shadow rounded-lg p-6">

                <h3 class="text-xl font-bold mb-4">
                    Menu Utama
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                    <button class="bg-blue-600 hover:bg-blue-700 text-gray p-4 rounded-lg">
                        Data Guru
                    </button>

                    <button class="bg-green-600 hover:bg-green-700 text-gray p-4 rounded-lg">
                        Data Siswa
                    </button>

                    <button class="bg-yellow-600 hover:bg-yellow-700 text-gray p-4 rounded-lg">
                        Kehadiran
                    </button>

                    <button class="bg-red-600 hover:bg-red-700 text-gray p-4 rounded-lg">
                        Pelanggaran
                    </button>

                    <button class="bg-purple-600 hover:bg-purple-700 text-gray p-4 rounded-lg">
                        Disiplin
                    </button>

                    <button class="bg-pink-600 hover:bg-pink-700 text-gray p-4 rounded-lg">
                        Adab
                    </button>

                    <button class="bg-indigo-600 hover:bg-indigo-700 text-gray p-4 rounded-lg">
                        Etika
                    </button>

                    <button class="bg-gray-700 hover:bg-gray-800 text-gray p-4 rounded-lg">
                        Laporan
                    </button>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
