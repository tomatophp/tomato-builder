<x-tomato-admin-layout>
    <x-slot:header>
        {{__('Schema Builder')}}
    </x-slot:header>
    <x-splade-data :default="['tables' => setting('builder_json')]">
        <div class="overflow-hidden">
            <TomatoDiagram v-model="data.tables" :strings="{
            tables: '{{__('Tables')}}',
            new_table: '{{__('New Table')}}',
            edit_table_name: '{{__('Edit Table Name')}}',
            key_type: '{{__('Key Type')}}',
            primary_key: '{{__('Primary Key')}}',
            foreign_key: '{{__('Foreign Key')}}',
            linked_to_table: '{{__('Linked To Table')}}',
            linked_to_field: '{{__('Linked To Field')}}',
            on_delete: '{{__('On Delete')}}',
            unique_key: '{{__('Unique Key')}}',
            none: '{{__('None')}}',
            auto_increment: '{{__('Auto increment')}}',
            unsigned: '{{__('Unsigned')}}',
            default: '{{__('Default')}}',
            length: '{{__('Length')}}',
            comment: '{{__('Comment')}}',
            actions: '{{__('Actions')}}',
            delete_column: '{{__('Delete column')}}',
            add_col: '{{__('Add Field')}}',
            delete_table: '{{__('Delete Table')}}',
            edit_from: '{{__('Edit From')}}',
            default_value: '{{__('Default Value')}}',
        }">
            </TomatoDiagram>
        </div>
        <x-splade-form method="POST" action="{{route('admin.builder.store')}}" default="{tables: []}" confirm>
            <div class="group fixed bottom-4 right-4 p-2  flex items-end justify-end w-24 h-24">
                <!-- main -->
                <div  class="text-white shadow-xl flex items-center justify-center p-3 rounded-full bg-primary-500  z-50 absolute ">
                    <i class="bx bx-save" > </i>
                </div>
                <!-- sub left -->
                <button @click.prevent="form.tables = data.tables; form.submit()" type="submit" title="{{__('Save')}}" class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-y-0 group-hover:scale-y-100 group-hover:-translate-x-16   flex  p-2 hover:p-3 bg-green-300 scale-100 hover:bg-green-400 text-white">
                    <i class="bx bx-check-circle"> </i>
                </button>

                <!-- sub top -->
                <button type="button" title="{{__('Clear')}}"  @click.prevent="form.tables=[]; $splade.visit('{{route('admin.builder.clear')}}')" class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-x-0 group-hover:scale-x-100 group-hover:-translate-y-16  flex  p-2 hover:p-3 bg-danger-500 hover:bg-danger-400  text-white">
                    <i class="bx bx-x-circle"> </i>
                </button>

                <x-splade-link modal href="{{route('admin.builder.confirm')}}" title="{{__('Generate')}}" class="absolute rounded-full transition-all duration-[0.2s] ease-out scale-x-0 group-hover:scale-x-100 group-hover:-translate-y-14 group-hover:-translate-x-14   flex  p-2 hover:p-3 bg-yellow-300 hover:bg-yellow-400 text-white">
                    <i class="bx bx-rocket" ></i>
                </x-splade-link>
            </div>
        </x-splade-form>
    </x-splade-data>
</x-tomato-admin-layout>
