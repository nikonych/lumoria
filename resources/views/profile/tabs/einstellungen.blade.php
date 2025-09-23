<div class="space-y-12 mr-24 mb-24">
    <!-- Konto Informationen -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl text-white">Konto Informationen</h2>
            @if(!$isEditingProfile)
                <x-base.button variant="primary" wire:click="editProfile">
                    Bearbeiten
                </x-base.button>
            @else
                <div class="flex space-x-3">
                    <x-base.button variant="success" wire:click="updateProfile">
                        Speichern
                    </x-base.button>
                    <x-base.button variant="secondary" wire:click="cancelEditProfile">
                        Abbrechen
                    </x-base.button>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-slate-300 mb-2">Benutzername</label>
                <x-base.input
                    type="text"
                    wire:model="profileForm.name"
                    value="{{ !$isEditingProfile ? (auth()->user()->name ?? 'Maxi123') : '' }}"
                    :disabled="!$isEditingProfile"
                />
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-2">E-Mail</label>
                <x-base.input
                    type="email"
                    wire:model="profileForm.email"
                    value="{{ !$isEditingProfile ? (auth()->user()->email ?? 'maxim@gmail.com') : '' }}"
                    :disabled="!$isEditingProfile"
                />
            </div>
        </div>


        <div>
            <label class="block text-sm text-slate-300 mb-2">Über mich (max. 300 Zeichen)</label>
            <x-base.textarea
                rows="4"
                maxlength="300"
                wire:model="profileForm.biography"
                value="{{ auth()->user()->biography ?? '' }}"
                :disabled="!$isEditingProfile"
            />
        </div>

        <!-- Passwort -->
        <div class="flex items-center space-x-4">
            <span class="text-sm text-slate-300">Passwort</span>
            <x-base.button variant="primary" size="sm" wire:click="openPasswordModal">
                Passwort ändern
            </x-base.button>
        </div>

        <!-- Profilbild -->
        <div class="flex items-center space-x-4">
            <span class="text-sm text-slate-300">Profilbild</span>
            <x-base.button variant="secondary" size="sm">
                Datei hochladen
            </x-base.button>
            <span class="text-xs text-gray-400">jpg, png, im Format 400x400px</span>
        </div>
    </div>

    <!-- Benachrichtigungen -->
    <div class="space-y-6">
        <h2 class="text-3xl text-white">Benachrichtigungen</h2>

        <div class="space-y-4 flex flex-col">
            <!-- E-Mail Benachrichtigungen zu Filmnews -->
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    wire:model="profileForm.notifications.email_new_movies"
                    class="sr-only peer"
                    :disabled="!$isEditingProfile"
                >
                <div class="relative w-11 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
                <span class="ml-3.5 text-sm font-extralight text-indigo-50">E-Mail Benachrichtigungen zu den neuesten Filmnews und Empfehlungen aktivieren?</span>
            </label>

            <!-- E-Mail Benachrichtigungen zu Empfehlungen -->
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    wire:model="profileForm.notifications.email_new_recommendations"
                    class="sr-only peer"
                    :disabled="!$isEditingProfile"
                >
                <div class="relative w-11 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
                <span class="ml-3.5 text-sm font-extralight text-indigo-50">E-Mail Benachrichtigungen zu neuen Empfehlungen?</span>
            </label>

            <!-- E-Mail Benachrichtigungen zu Freundschaftsanfragen -->
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    wire:model="profileForm.notifications.email_friend_requests"
                    class="sr-only peer"
                    :disabled="!$isEditingProfile"
                >
                <div class="relative w-11 h-6 bg-input-dark/85 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-700"></div>
                <span class="ml-3.5 text-sm font-extralight text-indigo-50">E-Mail Benachrichtigungen zu neuen Freundschaftsanfragen?</span>
            </label>
        </div>
    </div>

    <!-- Lieblingsgenre -->
    <div class="space-y-6">
        <h2 class="text-3xl text-white">Lieblingsgenre</h2>


        <div class="grid grid-cols-2 gap-3">
            @foreach($this->genres as $genre)
                <div class="flex items-center" wire:key="genre-{{ $genre->id }}">
                    <x-base.checkbox-profile
                        wire:model.live="profileForm.selectedGenres"
                        value="{{ $genre->id }}"
                        label="{{ $genre->name }}"
                        id="genre-{{ $genre->id }}"
                        :checked="in_array($genre->id, $this->profileForm['selectedGenres'] ?? [])"
                        :disabled="!$isEditingProfile"
                    />
                </div>
            @endforeach
        </div>
    </div>

    <!-- Konto löschen -->
    <div class="pt-8 border-t border-gray-700">
        <div class="flex items-center justify-start space-x-8">
            <div>
                <h3 class="text-lg text-white mb-2">Konto löschen</h3>
            </div>
            <x-base.button
                variant="danger"
                wire:confirm="Sind Sie sicher, dass Sie Ihr Konto löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden."
            >
                Konto löschen
            </x-base.button>
        </div>
    </div>

    @if($showPasswordModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closePasswordModal">
            <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl text-white">Passwort ändern</h2>
                    <button wire:click="closePasswordModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-2">Neues Passwort</label>
                        <x-base.input
                            type="password"
                            wire:model="passwordForm.password"
                            placeholder="Mindestens 8 Zeichen"
                            wire:key="new-password-input"
                        />
                        @error('passwordForm.password')
                        <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-slate-300 mb-2">Passwort bestätigen</label>
                        <x-base.input
                            type="password"
                            wire:model="passwordForm.password_confirmation"
                            placeholder="Passwort wiederholen"
                            wire:key="confirm-password-input"
                        />
                        @error('passwordForm.password_confirmation')
                        <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <x-base.button
                        type="button"
                        variant="secondary"
                        wire:click="closePasswordModal"
                    >
                        Abbrechen
                    </x-base.button>
                    <x-base.button
                        type="submit"
                        variant="success"
                        wire:click="updatePassword"
                    >
                        Ändern
                    </x-base.button>
                </div>
            </div>
        </div>
    @endif
</div>
