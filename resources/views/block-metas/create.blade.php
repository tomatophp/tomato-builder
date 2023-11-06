<x-tomato-admin-container label="{{trans('tomato-admin::global.crud.create')}} {{__('BlockMeta')}}">
    <x-splade-form class="flex flex-col space-y-4" action="{{route('admin.block-metas.store')}}" method="post">
        
          <x-splade-select :label="__('Block id')" :placeholder="__('Block id')" name="block_id" remote-url="/admin/blocks/api" remote-root="model.data" option-label=name option-value="id" choices/>
          <x-splade-input :label="__('Type')" name="type" type="text"  :placeholder="__('Type')" />
          
          <x-splade-input :label="__('Model type')" name="model_type" type="text"  :placeholder="__('Model type')" />
          
          <x-tomato-admin-rich :label="__('Html')" name="html" :placeholder="__('Html')" autosize />
          <x-tomato-admin-rich :label="__('Css')" name="css" :placeholder="__('Css')" autosize />
          <x-splade-input :label="__('Ordering')" :placeholder="__('Ordering')" type='number' name="ordering" />

        <div class="flex justify-start gap-2 pt-3">
            <x-tomato-admin-submit  label="{{__('Save')}}" :spinner="true" />
            <x-tomato-admin-button secondary :href="route('admin.block-metas.index')" label="{{__('Cancel')}}"/>
        </div>
    </x-splade-form>
</x-tomato-admin-container>
