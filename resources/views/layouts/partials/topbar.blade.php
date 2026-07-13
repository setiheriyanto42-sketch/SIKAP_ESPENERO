<header class="bg-white shadow h-16 flex items-center justify-between px-6">

    <div>

        <h2 class="text-xl font-bold text-slate-800">
            SIKAP ESPENERO
        </h2>

    </div>

    <div class="flex items-center gap-5">

        <div class="text-right">

            <div class="font-bold text-slate-800">

                {{ Auth::user()->guru->nama ?? Auth::user()->name }}

            </div>

            <div class="text-sm text-gray-500">

                {{ Auth::user()->role->nama_role ?? '-' }}

                @if(isset($data['isWaliKelas']) && $data['isWaliKelas'])

                    • Wali Kelas {{ $data['kelasPerwalian']->nama_kelas }}

                @endif

            </div>

        </div>

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->guru->nama ?? Auth::user()->name) }}&background=2563eb&color=fff"
            class="w-10 h-10 rounded-full">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">

                🚪 Logout

            </button>

        </form>

    </div>

</header>
