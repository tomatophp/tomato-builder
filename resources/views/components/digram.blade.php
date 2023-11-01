<div class="overflow-hidden flex" style="height: 100vw; width: 91vw ;margin-left: -32px; margin-top: -72px;">
    <TomatoDiagram v-model="{{ $vueModel() }}" {{ $attributes->only(['v-if', 'v-show', 'v-for', 'class'])->class(['hidden' => $isHidden()]) }}>
        <template #remove_icon>
            <x-heroicon-s-x-circle class="w-6 h-6 text-red-500" />
        </template>
        <template #dropdown_icon>
            <x-heroicon-s-chevron-down class="w-4 h-4" />
        </template>
        <template #dropup_icon>
            <x-heroicon-s-chevron-up class="w-4 h-4" />
        </template>
        <template #key_icon>
            <x-heroicon-s-key class="w-4 h-4" />
        </template>
        <template #dots_icon>
            <x-heroicon-s-adjustments-horizontal class="w-4 h-4" />
        </template>
        <template #buttons="{ react, newTable }">
            <div class="flex flex-col items-center justify-center">
                <button @click="react.sidebar = !react.sidebar">
                    <x-heroicon-s-bars-3 class="w-6 h-6" />
                </button>
            </div>
            <x-tomato-admin-button @click.prevent="newTable.active++" label="New Table" type="button" />
        </template>
    </TomatoDiagram>
</div>
