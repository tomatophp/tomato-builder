<x-tomato-admin-container label="{{trans('tomato-admin::global.crud.edit')}} {{__('Block')}} #{{$model->id}}">
    <x-splade-form class="flex flex-col space-y-4" action="{{route('admin.blocks.update', $model->id)}}" method="post" :default="$model">
        
          <x-splade-input :label="__('Type')" name="type" type="text"  :placeholder="__('Type')" />
          <x-splade-input :label="__('Group')" name="group" type="text"  :placeholder="__('Group')" />
          <x-splade-input :label="__('Key')" name="key" type="text"  :placeholder="__('Key')" />
          <x-splade-input :label="__('Place')" name="place" type="text"  :placeholder="__('Place')" />
          <x-splade-input :label="__('Ordering')" :placeholder="__('Ordering')" type='number' name="ordering" />
          <x-splade-checkbox :label="__('Activated')" name="activated" label="Activated" />

        <div class="flex justify-start gap-2 pt-3">
            <x-tomato-admin-submit  label="{{__('Save')}}" :spinner="true" />
            <x-tomato-admin-button danger :href="route('admin.blocks.destroy', $model->id)"
                                   confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                                   confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                                   confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                                   cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                                   method="delete"  label="{{__('Delete')}}" />
            <x-tomato-admin-button secondary :href="route('admin.blocks.index')" label="{{__('Cancel')}}"/>
        </div>
    </x-splade-form>
</x-tomato-admin-container>
