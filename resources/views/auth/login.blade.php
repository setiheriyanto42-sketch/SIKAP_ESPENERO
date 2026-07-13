<x-guest-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">

        @csrf

        <div>

            <x-input-label
                for="login"
                value="Username / Email" />

            <x-text-input
                id="login"
                class="block mt-1 w-full"
                type="text"
                name="login"
                :value="old('login')"
                required
                autofocus />

            <x-input-error
                :messages="$errors->get('login')"
                class="mt-2"/>

        </div>

        <div class="mt-4">

            <x-input-label
                for="password"
                value="Password" />

            <div class="relative">

                <input

                    id="password"

                    name="password"

                    type="password"

                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full pr-12"

                    required>

                <button

                    type="button"

                    onclick="togglePassword()"

                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">

                    👁

                </button>

            </div>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"/>

        </div>

        <div class="block mt-4">

            <label class="inline-flex items-center">

                <input
                    type="checkbox"
                    name="remember">

                <span class="ml-2">

                    Remember Me

                </span>

            </label>

        </div>

        <div class="flex justify-end mt-5">

            <x-primary-button>

                Login

            </x-primary-button>

        </div>

    </form>

    <script>

        function togglePassword(){

            let p=document.getElementById('password');

            p.type=p.type==='password'?'text':'password';

        }

    </script>

</x-guest-layout>
