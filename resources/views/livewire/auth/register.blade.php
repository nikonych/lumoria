<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="gap-6 mx-12 mt-12 min-h-full">
    <x-auth-header title="Registrieren"/>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6 mt-8 text-slate-50">
        <!-- Name -->
        <div>
            <label for="username" class="block mb-2 text-sm font-medium">Benutzername</label>
            <input type="text" id="username" class="focus:outline-none accent-slate-50 font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-full p-2.5" placeholder="John" required />
        </div>

        <div>
            <label for="email" class="block mb-2 text-sm font-medium">E-Mail</label>

            <div class="relative group">

                <div class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none">
                    <svg width="12" height="10" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.5C0 0.679688 0.65625 0 1.5 0H10.5C11.3203 0 12 0.679688 12 1.5V7.5C12 8.34375 11.3203 9 10.5 9H1.5C0.65625 9 0 8.34375 0 7.5V1.5ZM1.125 1.5V2.03906L5.15625 5.34375C5.64844 5.74219 6.32812 5.74219 6.82031 5.34375L10.875 2.03906V1.5C10.875 1.3125 10.6875 1.125 10.5 1.125H1.5C1.28906 1.125 1.125 1.3125 1.125 1.5ZM1.125 3.49219V7.5C1.125 7.71094 1.28906 7.875 1.5 7.875H10.5C10.6875 7.875 10.875 7.71094 10.875 7.5V3.49219L7.54688 6.21094C6.63281 6.96094 5.34375 6.96094 4.42969 6.21094L1.125 3.49219Z"
                              class="fill-gray-400 group-focus-within:fill-indigo-400"
                        />
                    </svg>
                </div>

                <input type="email" id="email" class="pl-7 focus:outline-none font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-full p-2.5" placeholder="E-Mail" required />

            </div>
        </div>

        <div>
            <label for="password" class="block mb-2 text-sm font-medium">Passwort</label>
            <input type="password" id="password" class="focus:outline-none accent-slate-50 font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-full p-2.5" placeholder="*******" required />
        </div>

        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-medium">Passwort wiederholen</label>
            <input type="password" id="password_confirmation" class="focus:outline-none accent-slate-50 font-light text-xs bg-input-dark/85 focus:border rounded-sm focus:ring-indigo-500 focus:border-indigo-500 w-full p-2.5" placeholder="*******" required />
        </div>


        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" value="" class="sr-only peer">
            <div class="relative w-11 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">E-Mail Benachrichtigungen zu den neuesten Filmnews und Empfehlungen aktivieren?</span>
        </label>


        <div class="flex items-center justify-end">
            <button type="submit" class="w-full cursor-pointer rounded-lg h-9 bg-indigo-700 text-white font-light text-sm">
                Registrieren
            </button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-sm text-slate-50 mt-5">
        <span>Du hast schon einen Account?</span>
        <flux:link :href="route('login')" wire:navigate class="text-indigo-400">Jetzt anmelden.</flux:link>
    </div>
</div>
