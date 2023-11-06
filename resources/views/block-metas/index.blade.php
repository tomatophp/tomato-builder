<x-splade-table :for="$query" striped v-if="data.meta">
    <x-splade-cell html>
        <x-tomato-admin-row table :value="$item->html" />
    </x-splade-cell>
    <x-splade-cell css>
        <x-tomato-admin-row table :value="$item->css" />
    </x-splade-cell>
    <x-splade-cell ordering>
        <x-tomato-admin-row table type="number" :value="$item->ordering" />
    </x-splade-cell>

    <x-splade-cell actions>
        <div class="flex justify-start">
            <x-tomato-admin-button success type="icon" title="{{trans('tomato-admin::global.crud.view')}}" modal :href="route('admin.block-metas.show', $item->id)">
                <x-heroicon-s-eye class="h-6 w-6"/>
            </x-tomato-admin-button>
            <x-tomato-admin-button warning type="icon" title="{{trans('tomato-admin::global.crud.edit')}}" modal :href="route('admin.block-metas.edit', $item->id)">
                <x-heroicon-s-pencil class="h-6 w-6"/>
            </x-tomato-admin-button>
            <x-tomato-admin-button danger type="icon" title="{{trans('tomato-admin::global.crud.delete')}}" :href="route('admin.block-metas.destroy', $item->id)"
                                   confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                                   confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                                   confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                                   cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                                   method="delete"
            >
                <x-heroicon-s-trash class="h-6 w-6"/>
            </x-tomato-admin-button>
        </div>
    </x-splade-cell>
</x-splade-table>
