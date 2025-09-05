<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')]
class extends Component {
    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    #[On('input-value-updated')]
    public function updatePasswordValue(string $name, string $value): void
    {
        $this->{$name} = $value;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['name' => $this->name, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'name' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'name' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->name) . '|' . request()->ip());
    }
}; ?>

<div class="gap-6 mx-12 mt-12 min-h-full">
    <x-auth-header title="Login"/>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')"/>

    <form method="POST" wire:submit="login" class="flex flex-col gap-6 mt-8 text-slate-50">

        <div>
            <label for="username" class="block mb-2 text-sm font-medium">Benutzername</label>
            <input type="text" id="username" wire:model="name"
                   class="focus:outline-none accent-slate-50 font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-full p-2.5"
                   placeholder="John" required/>

            @error('name')
            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="relative">
            @livewire('password-input', [
                       'name' => 'password',
                       'label' => 'Passwort'
                   ], key('password'))

            <a href="{{ route('register') }}"
               class="absolute right-0 mt-2 text-sm text-indigo-400 font-light hover:text-indigo-300">Passwort
                vergessen?</a>

            @error('password')
            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex items-center justify-end mt-8">
            <button type="submit"
                    class="w-full cursor-pointer rounded-lg h-9 bg-indigo-700 hover:bg-indigo-600 text-white font-light text-sm">
                Anmelden
            </button>
        </div>

    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-sm text-slate-50 mt-5">
            <span>Du hast noch keinen Account?</span>
            <a href="{{ route('register') }}" wire:navigate class="text-indigo-400 hover:text-indigo-300">Jetzt
                registrieren.</a>
        </div>
    @endif
</div>
