<div class="overflow-hidden flex" style="height: 100vw; width: 91vw ;margin-left: -32px; margin-top: -72px;">
    <TomatoDiagram v-model="{{ $vueModel() }}" {{ $attributes }} :strings="{
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
