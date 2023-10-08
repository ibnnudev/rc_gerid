<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-input id="email" label="Email" name="email" type="email" required autofocus :value="old('email', $request->email)" />

        <x-input id="password" type="password" label="New Password" name="password" required
            autocomplete="new-password" />

        <x-input id="password_confirmation" label="Password Confirmation" type="password" name="password_confirmation"
            required autocomplete="new-password" />

        <div class="flex items-center justify-end mt-4">\
            <x-button>
                {{ __('Reset Password') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
