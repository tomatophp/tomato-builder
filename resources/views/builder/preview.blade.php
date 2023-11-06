<x-tomato-admin-container :label="$model->title">
    <x-slot:buttons>
        <x-tomato-admin-button type="link" href="{{route('admin.builder.form', $model->key)}}">
            <x-heroicon-s-arrow-left class="w-4 h-4" />
            {{__('Back')}}
        </x-tomato-admin-button>
    </x-slot:buttons>
    <x-tomato-form :form="$model" :action="route('admin.form-requests.store')"></x-tomato-form>
</x-tomato-admin-container>
