<x-jet-action-section>
    <x-slot name="title">
        {{ __('Çift Faktör Doğrulama') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Çift faktörlü kimlik doğrulama kullanarak hesabınıza ek güvenlik ekleyin.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                {{ __('Çift faktörlü kimlik doğrulamayı etkinleştirdiniz.') }}
            @else
                {{ __('Çift faktörlü kimlik doğrulamayı devre dışı.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Çift faktörlü kimlik doğrulama etkinleştirildiğinde, kimlik doğrulama sırasında güvenli bir kod girmeniz istenir. Bu kodu telefonunuzun Google Authenticator uygulamasından alabilirsiniz.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Çift faktörlü kimlik doğrulama artık etkinleştirilmiştir. Telefonunuzun kimlik doğrulama uygulamasını kullanarak aşağıdaki QR kodunu tarayın.') }}
                    </p>
                </div>

                <div class="mt-4 dark:p-4 dark:w-56 dark:bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Bu kurtarma kodlarını güvenli bir şifre yöneticisinde saklayın. İki faktörlü kimlik doğrulama cihazınız kaybolursa hesabınıza erişimi kurtarmak için kullanılabilirler.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-jet-button type="button" wire:loading.attr="disabled">
                        {{ __('AKTİFLEŞTİR') }}
                    </x-jet-button>
                </x-jet-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-jet-secondary-button class="mr-3">
                            {{ __('Kurtarma Kodlarını YENİDEN Oluştur') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @else
                    <x-jet-confirms-password wire:then="showRecoveryCodes">
                        <x-jet-secondary-button class="mr-3">
                            {{ __('Kurtarma Kodlarını Göster') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @endif

                <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                    <x-jet-danger-button wire:loading.attr="disabled">
                        {{ __('DEAKTİFLEŞTİR') }}
                    </x-jet-danger-button>
                </x-jet-confirms-password>
            @endif
        </div>
    </x-slot>
</x-jet-action-section>
