<x-tomato-admin-container label="{{trans('tomato-admin::global.crud.view')}} {{__('block-metas')}} #{{$model->id}}">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
          <x-tomato-admin-row :label="__('Block')" :value="$model->Block->id" type="text" />

          <x-tomato-admin-row :label="__('Type')" :value="$model->type" type="string" />

          
          <x-tomato-admin-row :label="__('Model type')" :value="$model->model_type" type="string" />

          
          <x-tomato-admin-row :label="__('Html')" :value="$model->html" type="rich" />

          <x-tomato-admin-row :label="__('Css')" :value="$model->css" type="rich" />

          <x-tomato-admin-row :label="__('Ordering')" :value="$model->ordering" type="number" />

    </div>
    <div class="flex justify-start gap-2 pt-3">
        <x-tomato-admin-button warning label="{{__('Edit')}}" :href="route('admin.block-metas.edit', $model->id)"/>
        <x-tomato-admin-button danger :href="route('admin.block-metas.destroy', $model->id)"
                               confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                               confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                               confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                               cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                               method="delete"  label="{{__('Delete')}}" />
        <x-tomato-admin-button secondary :href="route('admin.block-metas.index')" label="{{__('Cancel')}}"/>
    </div>
</x-tomato-admin-container>
