<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('auth.complete-register', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) ) }}">
            @csrf

            <div>
                <x-jet-label for="nama_lengkap" value="{{ __('Nama Lengkap') }}" />
                <x-jet-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus autocomplete="nama" />
            </div>

            <div class="mt-4">
                <x-jet-label for="tempat_lahir" value="{{ __('Tempat Lahir') }}" />
                <x-jet-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir')" required autofocus autocomplete="tempat_lahir" />
            </div>

            <div class="mt-4">
                <x-jet-label for="tanggal_lahir" value="{{ __('Tanggal Lahir') }}" />
                <x-jet-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required autofocus autocomplete="tanggal_lahir" />
            </div>

            <div class="mt-4">
                <x-jet-label for="agama" value="{{ __('Agama') }}" /> 
                <select name="agama" class="block mt-1 w-full" id="agama">
                    <option value=""></option>
                    <option value="Katolik" @if (old('agama') == "Katolik") {{ 'selected' }} @endif>Katolik</option>
                    <option value="Kristen" @if (old('agama') == "Kristen") {{ 'selected' }} @endif>Kristen</option>
                    <option value="Islam" @if (old('agama') == "Islam") {{ 'selected' }} @endif>Islam</option>
                    <option value="Hindu" @if (old('agama') == "Hindu") {{ 'selected' }} @endif>Hindu</option>
                    <option value="Buddha" @if (old('agama') == "Buddha") {{ 'selected' }} @endif>Buddha</option>
                    <option value="Khonghucu" @if (old('agama') == "Khonghucu") {{ 'selected' }} @endif>Khonghucu</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" /> 
                <select name="jenis_kelamin" class="block mt-1 w-full" id="jenis_kelamin">
                    <option value=""></option>
                    <option value="Laki-Laki" @if (old('jenis_kelamin') == "Laki-Laki") {{ 'selected' }} @endif>Laki-Laki</option>
                    <option value="Perempuan" @if (old('jenis_kelamin') == "Perempuan") {{ 'selected' }} @endif>Perempuan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="telepon" value="{{ __('Telepon') }}" />
                <x-jet-input id="telepon" class="block mt-1 w-full" type="text" name="telepon" :value="old('telepon')" required autofocus autocomplete="telepon" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
