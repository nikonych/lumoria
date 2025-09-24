<div>
    <!-- Проверяем, находимся ли мы на странице поиска друзей -->
    @if($showAddFriendsPage ?? false)
        <!-- Страница поиска друзей -->
        <div>
            <div class="flex items-center gap-4 mb-8">
                <x-base.button
                    wire:click="$set('showAddFriendsPage', false)"
                    icon="exit"
                    icon-position="left"
                    variant="secondary"
                >
                    Zurück
                </x-base.button>
                <p class="text-3xl font-family-helvetica">Freunde hinzufügen</p>
            </div>

            <!-- Поисковое поле -->
            <div class="mb-8">
                <x-base.input :has-icon="true" wire:model.live="friendSearchQuery" wire:key="friendSearchQuery"/>
            </div>

            <div class="grid grid-cols-2 gap-5">
                @foreach($this->searchedUsers as $index => $user)
                    <x-profile.searchedUser-card :user="$user" :index="$index"/>
                @endforeach
            </div>
            <div class="flex justify-center">
                <x-pagination :paginator="$this->searchedUsers"/>
            </div>
        </div>
    @else
        <!-- Основная страница друзей -->
        <div>
            <!-- Header с заголовком и кнопкой добавления друзей -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-family-helvetica text-slate-50">Deine Freunde</h2>
                <x-base.button
                    wire:click="$set('showAddFriendsPage', true)"
                    icon="plus"
                >
                    Freunde hinzufügen
                </x-base.button>
            </div>

            <!-- Уведомление о заявке -->
            <div class="mb-6 grid grid-cols-2 gap-5">
                @if($this->sentRequests->count() > 0)
                    @foreach($this->sentRequests as $request)
                        <x-profile.sentRequest-card :request="$request"/>
                    @endforeach
                @endif

                @if($this->friendRequests->count() > 0)
                    @foreach($this->friendRequests as $request)
                        <x-profile.friendRequest-card :request="$request"/>
                    @endforeach
                @endif

                <!-- Список друзей -->
                @foreach($this->friends as $friend)
                    <x-profile.friend-card :friend="$friend"/>
                @endforeach

            </div>
        </div>
    @endif
</div>
