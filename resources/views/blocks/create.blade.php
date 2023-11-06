<x-tomato-admin-container label="{{trans('tomato-admin::global.crud.create')}} {{__('Block')}}">
    <x-splade-form class="flex flex-col space-y-4" action="{{route('admin.blocks.store')}}" method="post">
        
          <x-splade-input :label="__('Type')" name="type" type="text"  :placeholder="__('Type')" />
          <x-splade-input :label="__('Group')" name="group" type="text"  :placeholder="__('Group')" />
          <x-splade-input :label="__('Key')" name="key" type="text"  :placeholder="__('Key')" />
          <x-splade-input :label="__('Place')" name="place" type="text"  :placeholder="__('Place')" />
          <x-splade-input :label="__('Ordering')" :placeholder="__('Ordering')" type='number' name="ordering" />
          <x-splade-checkbox :label="__('Activated')" name="activated" label="Activated" />

        <div class="flex justify-start gap-2 pt-3">
            <x-tomato-admin-submit  label="{{__('Save')}}" :spinner="true" />
            <x-tomato-admin-button secondary :href="route('admin.blocks.index')" label="{{__('Cancel')}}"/>
        </div>
    </x-splade-form>
</x-tomato-admin-container>
