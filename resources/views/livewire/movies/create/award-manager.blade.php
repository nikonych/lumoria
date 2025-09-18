<div class="mt-16">
    <p class="text-2xl">Auszeichnungen</p>

    @foreach($awardsData as $id => $award)
        <div class="flex space-x-5 mt-5" wire:key="award-row-{{ $id }}">
            <div class="w-1/3">
                <label class="block mb-1.5 text-sm text-slate-50">Verleihung</label>
                <livewire:base.selection class="w-full" wire:model="awardsData.{{$id}}.award_name"/>
            </div>
            <div class="w-1/3">
                <label class="block mb-1.5 text-sm text-slate-50">Kategorie</label>
                <livewire:base.selection class="w-full" wire:model="awardsData.{{$id}}.category"/>
            </div>
            <div class="w-1/3">
                <label class="block mb-1.5 text-sm text-slate-50">Person</label>
                <livewire:base.selection class="w-full" wire:model="awardsData.{{$id}}.person_id"/>
            </div>
            <div class="flex items-end">
                <x-base.button type="button" variant="danger" icon="trash"
                               wire:click.prevent="removeAward('{{ $id }}')"/>
            </div>
        </div>
    @endforeach

    <div class="flex justify-end">
        <x-base.button type="button" icon="plus" class="mt-5" wire:click="addAward">
            Auszeichnung hinzufügen
        </x-base.button>
    </div>
</div>
