<x-tomato-admin-container label="{{trans('tomato-admin::global.crud.view')}} {{__('blocks')}} #{{$model->id}}">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
          <x-tomato-admin-row :label="__('Type')" :value="$model->type" type="string" />

          <x-tomato-admin-row :label="__('Group')" :value="$model->group" type="string" />

          <x-tomato-admin-row :label="__('Key')" :value="$model->key" type="string" />

          <x-tomato-admin-row :label="__('Place')" :value="$model->place" type="string" />

          <x-tomato-admin-row :label="__('Ordering')" :value="$model->ordering" type="number" />

          <x-tomato-admin-row :label="__('Activated')" :value="$model->activated" type="bool" />

    </div>
    <div class="flex justify-start gap-2 pt-3">
        <x-tomato-admin-button warning label="{{__('Edit')}}" :href="route('admin.blocks.edit', $model->id)"/>
        <x-tomato-admin-button danger :href="route('admin.blocks.destroy', $model->id)"
                               confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                               confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                               confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                               cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                               method="delete"  label="{{__('Delete')}}" />
        <x-tomato-admin-button secondary :href="route('admin.blocks.index')" label="{{__('Cancel')}}"/>
    </div>
</x-tomato-admin-container>
