<header class="bg-blue-700 text-white shadow">

    <div class="max-w-full px-6 py-4 flex justify-between items-center">

        <div>

            <h1 class="text-2xl font-bold">
                SIKAP ESPENERO
            </h1>

            <p class="text-sm">
                Sistem Informasi Kehadiran dan Karakter
                <br>
                SMP Negeri 2 Jatiroto
            </p>

        </div>

        <div class="text-right">

            <div class="font-semibold">

                {{ Auth::user()->name }}

            </div>

            <div class="text-sm">

                {{ Auth::user()->email }}

            </div>

        </div>

    </div>

</header>
