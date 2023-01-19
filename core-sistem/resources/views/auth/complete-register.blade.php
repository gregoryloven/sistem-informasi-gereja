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
                <x-jet-label for="hubungan" value="{{ __('Hubungan') }}" /> 
                <select name="hubungan" class="block mt-1 w-full" id="hubungan" required>
                    <option value="" disabled selected></option>
                    <option value="Kepala Keluarga" @if (old('hubungan') == "Kepala Keluarga") {{ 'selected' }} @endif>Kepala Keluarga</option>
                    <option value="Istri" @if (old('hubungan') == "Istri") {{ 'selected' }} @endif>Istri</option>
                    <option value="Anak" @if (old('hubungan') == "Anak") {{ 'selected' }} @endif>Anak</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="no_kk" value="{{ __('No KK') }}" />
                <x-jet-input id="no_kk" class="block mt-1 w-full" type="number" name="no_kk" :value="old('no_kk')" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" required autofocus autocomplete="no_kk" />
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
                <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" /> 
                <select name="jenis_kelamin" class="block mt-1 w-full" id="jenis_kelamin" required>
                    <option value="" disabled selected></option>
                    <option value="Laki-Laki" @if (old('jenis_kelamin') == "Laki-Laki") {{ 'selected' }} @endif>Laki-Laki</option>
                    <option value="Perempuan" @if (old('jenis_kelamin') == "Perempuan") {{ 'selected' }} @endif>Perempuan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="alamat" value="{{ __('Alamat') }}" />
                <x-jet-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required autofocus autocomplete="alamat" />
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
                    {{ __('Sudah Punya Akun?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
