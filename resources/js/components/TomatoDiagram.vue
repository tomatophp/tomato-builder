<script setup>
import { Background, BackgroundVariant } from '@vue-flow/background'
import {Position, Panel, VueFlow, useVueFlow, Handle} from '@vue-flow/core'
import Edge from './Edge.vue'
import CustomConnectionLine from './CustomConnectionLine.vue'
import {computed, onMounted, reactive, ref, watch, inject} from "vue";
import {NodeToolbar} from "@vue-flow/node-toolbar";
import {VueDraggableNext} from 'vue-draggable-next'
import Multiselect from "@suadelabs/vue3-multiselect";
const Splade = inject("$splade");
import { Controls } from '@vue-flow/controls'
import { MiniMap } from '@vue-flow/minimap'
import tippy from 'tippy.js';


const { nodes, addNodes,removeNodes, addEdges, updateEdge,onConnect, dimensions, findEdge, removeEdges } = useVueFlow()

let props = defineProps({
    modelValue: {
        required: true
    },
    strings: {
        type: Object,
        required: true
    }
})

//On Connect Create a Relation
onConnect(function(params) {
    params.type = "custom";
    params.isEdge = true;
    params.data = {};
    params.data.relation = {
        name: 'Has One',
        id: 'hasOne'
    };
    params.updatable = true;
    addEdges(params)
})

//Update Edges
function onEdgeUpdate({ edge, connection }) {
    return updateEdge(edge, connection)
}

let react = reactive({
    selected : false,
    sidebar: true
});

let nodesItems = ref([]);

//Reactive Sidebar To LocalStorage
watch(react,async (newValue, oldValue) => {
    localStorage.setItem('show_builder_sidebar', newValue.sidebar ? "1" : "0");
}, { deep: true })

let tables = ref({})


//Add New Table To Diagram
function onAdd() {
    const nodeId = "table_"+(nodes.value.length + 1).toString()
    let randomColor =  Math.floor(Math.random()*16777215).toString(16);
    //Make Sure that the color is not white
    while(randomColor === 'cd119'){
        randomColor =  Math.floor(Math.random()*16777215).toString(16);
    }

    const newNode = {
        id: nodeId,
        label: `Node: ${nodeId}`,
        type: "custom",
        isEdge: false,
        position: { x: Math.random() * dimensions.value.width, y: Math.random() * dimensions.value.height },
        data: {
            id: nodeId,
            table: nodeId,
            fields: [
                {
                    id: 1,
                    name: "id",
                    type: "bigint",
                    length: null,
                    nullable: false,
                    index_type: "primary_key",
                    auto_increment: true,
                    unsigned: true,
                    default: null,
                    comment: null,
                    linked_to_table: null,
                    linked_to_field: null
                },
                {
                    id: 2,
                    name: "created_at",
                    type: "timestamps",
                    length: null,
                    nullable: false,
                    index_type: null,
                    auto_increment: false,
                    unsigned: false,
                    default: null,
                    comment: null,
                    linked_to_table: null,
                    linked_to_field: null
                },
                {
                    id: 3,
                    name: "updated_at",
                    type: "timestamps",
                    length: null,
                    nullable: false,
                    index_type: null,
                    auto_increment: false,
                    unsigned: false,
                    default: null,
                    comment: null,
                    linked_to_table: null,
                    linked_to_field: null
                },
            ],
            color: "#" + randomColor,
            show: true,
            showTableNameEdit:true,
            order: 0
        },
    }

    addNodes([newNode])

    setTimeout(()=>{
        tables.value[nodeId].focus();
    }, 50);
}

//On Node Click
function onNodeClick(change){
    const index = nodesItems.value.indexOf(change.node);
    react.sidebar = true;
    nodesItems.value[index].data.show = true;
}

//Delete Node
function removeNode(id){
    removeNodes([id])
}

//Add New Field
function addField(id, getType='col'){
    let lastOne = (nodesItems.value[id].data.fields.length-1);

    if(getType === 'col'){
        let fieldItem = {
            id: lastOne+1,
            name: "col_"+(lastOne+1).toString(),
            type: "string",
            length: 255,
            nullable: false,
            index_type: null,
            auto_increment: false,
            unsigned: false,
            default: null,
            comment: null,
            linked_to_table: null,
            linked_to_field: null,
            on_delete: {
                name: 'NULL',
                id: null
            }
        };
        if(nodesItems.value[id].data.fields.length < 3){
            nodesItems.value[id].data.fields.splice(nodesItems.value[id].data.fields.length, 0,fieldItem)
        }
        else {
            nodesItems.value[id].data.fields.splice(nodesItems.value[id].data.fields.length-2, 0,fieldItem)
        }
    }
    else if(getType === 'key'){
        let fieldItem = {
            id: lastOne+1,
            name: "key_"+(lastOne+1).toString(),
            type: "bigint",
            length: 999999,
            nullable: false,
            index_type: 'foreign_key',
            key_type_show: true,
            auto_increment: false,
            unsigned: true,
            default: null,
            comment: null,
            linked_to_table: null,
            linked_to_field: null,
            on_delete: {
                name: 'NULL',
                id: null
            }
        };
        if(nodesItems.value[id].data.fields.length < 3){
            nodesItems.value[id].data.fields.splice(nodesItems.value[id].data.fields.length, 0,fieldItem)
        }
        else {
            nodesItems.value[id].data.fields.splice(nodesItems.value[id].data.fields.length-2, 0,fieldItem)
        }
    }
    else if(getType === 'soft-delete'){
        let softDelete = {
            id: lastOne+1,
            name: "deleted_at",
            type: "timestamps",
            length: null,
            nullable: true,
            index_type: null,
            auto_increment: false,
            unsigned: false,
            default: null,
            comment: null,
            linked_to_table: null,
            linked_to_field: null
        };
        nodesItems.value[id].data.fields.push(softDelete);
    }
    else if(getType === 'timestamps'){
        let createdAt = {
            id: lastOne+1,
            name: "created_at",
            type: "timestamps",
            length: null,
            nullable: false,
            index_type: null,
            auto_increment: false,
            unsigned: false,
            default: null,
            comment: null,
            linked_to_table: null,
            linked_to_field: null
        };
        let updatedAt = {
            id: lastOne+2,
            name: "updated_at",
            type: "timestamps",
            length: null,
            nullable: false,
            index_type: null,
            auto_increment: false,
            unsigned: false,
            default: null,
            comment: null,
            linked_to_table: null,
            linked_to_field: null
        };
        nodesItems.value[id].data.fields.push(createdAt);
        nodesItems.value[id].data.fields.push(updatedAt);
    }
}

//Update v-model value
const emits = defineEmits(['update:modelValue'])

//Watch update on the Nodes
watch(nodesItems, async (newValue, oldValue) => {
    if(oldValue.length > 0){
        for (let i =0; i<nodesItems.value.length; i++){
            if(!nodesItems.value[i].isEdge){
                for(let r=0; r<nodesItems.value[i].data.fields.length; r++){
                    if(nodesItems.value[i].data.fields[r].index_type === 'foreign_key' && nodesItems.value[i].data.fields[r].linked_to_table && nodesItems.value[i].data.fields[r].linked_to_field){
                        let sourceTable = nodesItems.value[i];
                        let field = nodesItems.value[i].data.fields[r];
                        let table= nodesItems.value[i].data.fields[r].linked_to_table;
                        let selected= nodesItems.value[i].data.fields[r].linked_to_field;
                        let checkEdge = findEdge("ueflow__edge-" + sourceTable.id + field.name + '_right_' + sourceTable.data.table+'-'+ table.id +selected.name+ '_left_'+table.data.table);
                        if(!checkEdge){
                            nodesItems.value[i].data.fields[r].linked_to_table = "";
                            nodesItems.value[i].data.fields[r].linked_to_field = "";
                            nodesItems.value[i].data.fields[r].index_type = null;
                        }
                    }

                }
            }
            else {
                if(nodesItems.value[i].sourceHandle){
                    for(let r = 0; r<nodesItems.value[i].sourceNode.data.fields.length; r++){
                        if(
                            nodesItems.value[i].sourceNode.data.fields[r].name === nodesItems.value[i].sourceHandle.split('_right_')[0] &&
                            nodesItems.value[i].sourceNode.data.fields[r].index_type !== 'foreign_key'

                        ){
                            removeEdges([nodesItems.value[i].id]);
                        }
                    }
                }
            }
        }
        localStorage.setItem('builder_tables', JSON.stringify(nodesItems.value));
        emits('update:modelValue', JSON.stringify(nodesItems.value));
    }

}, {deep: true})

//Delete Field
function removeCol(index, key){
    if(nodesItems.value[key].data.fields.length > 1){
        nodesItems.value[key].data.fields.splice(index, 1);
    }
}

//Attach Data from database or localstorage
onMounted(()=>{
    let savedData = localStorage.getItem('builder_tables');
    if(savedData){
        nodesItems.value = JSON.parse(localStorage.getItem('builder_tables'));
        emits('update:modelValue', JSON.stringify(nodesItems.value))
    }
    else {
        nodesItems.value = JSON.parse(props.modelValue);
    }
    let showSidebar = localStorage.getItem('show_builder_sidebar');
    react.sidebar = showSidebar === "1";

    $('.tippy').ready(function (){
       setTimeout(function (){
           let buttons = document.querySelectorAll('.tippy');
              for(let i = 0; i<buttons.length; i++){
                tippy(buttons[i], {
                     content: buttons[i].getAttribute('title'),
                     placement: 'top',
                });
              }
       }, 2000);
    });
});

//Watch Model Value Changes
watch(props, (newValue, oldValue)=>{
    if(typeof newValue.modelValue === 'object'){
        nodesItems.value = [];
    }
})

//Link Table
function linkTable(selected, id){
    let indexIds = id.split('_');
    let sourceTable = nodesItems.value[indexIds[0]];
    let field = nodesItems.value[indexIds[0]].data.fields[indexIds[1]];
    let table= nodesItems.value[indexIds[0]].data.fields[indexIds[1]].linked_to_table;

    let params = {
        type: "custom",
        isEdge: true,
        data: {
            relation: {
                name: 'Has One',
                id: 'hasOne'
            }
        },
        updatable: true,
        source: sourceTable.id,
        target: table.id,
        sourceHandle: field.name+'_right_'+sourceTable.data.table,
        targetHandle: selected.name+'_left_'+table.data.table,
        id: "ueflow__edge-" + sourceTable.id + field.name + '_right_' + sourceTable.data.table+'-'+ table.id +selected.name+ '_left_'+table.data.table
    };

    addEdges([params])
}

//Go to the Form Selected
function goToForm(key){
    Splade.visit('/admin/builder/form/' + key);
}

function __(string){
    return props.strings[string];
}

</script>

<template>
    <div class="grid grid-cols-12 gap-2">
        <div v-show="react.sidebar" class="col-span-4 bg-white border rounded-lg border-gray-200 shadow-sm">
            <div class="flex justify-between gap-4 p-4 oveflow-hidden border-b border-gray-200">
                <div class="flex flex-col justify-center items-center">
                    <span class="font-bold text-md">{{ __('tables') }}</span>
                </div>
                <div>
                    <button @click.prevent="onAdd" class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm shadow-sm focus:ring-white filament-page-button-action bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 text-white border-transparent">
                        {{ __('new_table') }}
                    </button>
                </div>
            </div>
            <div class="overflow-y-scroll h-screen">
                <VueDraggableNext
                    :list="nodesItems"
                    order-by="order"
                    group="drag"
                >
                    <div v-for="(item, key) in nodesItems" >
                        <div v-if="!item.isEdge || item.isEdge === '0'">
                            <div class="flex justify-between gap-4 border-b border-gray-600 bg-gray-700 text-gray-100 py-3 w-full px-4 " :style="'border-left: '+ item.data.color +' 8px solid'">
                                <div class="w-full cursor-move font-bold">
                                    <h1 v-show="!item.data.showTableNameEdit || item.data.showTableNameEdit === '0'">{{ item.data.table }}</h1>
                                    <div v-show="item.data.showTableNameEdit && item.data.showTableNameEdit !== '0'">
                                        <input type="text" :ref="el => { tables[item.data.table] = el }" v-model="nodesItems[key].data.table" @keypress.enter.prevent="item.data.showTableNameEdit = false" placeholder="Table Name" class="block w-full h-10 border border-gray-600 bg-gray-400/10 placeholder-gray-500 transition duration-75 rounded-lg focus:bg-gray-700 focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400" />
                                    </div>
                                </div>
                                <div class="flex justify-start gap-4">
                                    <button @click.prevent="addField(key)" class="tippy  hover:text-success-500 flex flex-col justify-center items-center" :id="item.id+'_add_col'" :title="__('add_col')">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                    <button @click.prevent="removeNode(item.id)" class="tippy hover:text-danger-500 flex flex-col justify-center items-center" :id="item.id+'_delete_table'" :title="__('delete_table')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                    <button @click.prevent="goToForm(item.data.table)" class="tippy hover:text-warning-500 flex flex-col justify-center items-center" :id="item.id+'_edit_from'" :title="__('edit_from')">
                                        <i class="bx bx-building"></i>
                                    </button>
                                    <button class="tippy flex flex-col justify-center items-center hover:text-warning-500" :id="item.id+'_edit_table'" :title="__('edit_table_name')" @click.prevent="item.data.showTableNameEdit = !item.data.showTableNameEdit">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button class="tippy flex flex-col justify-center items-center hover:text-warning-500" :id="item.id+'_timestamps'" title="Add Timestamps" @click.prevent="addField(key, 'timestamps')">
                                        <i class="bx bx-time"></i>
                                    </button>
                                    <button class="tippy flex flex-col justify-center items-center hover:text-warning-500" :id="item.id+'_soft_delete'" title="Add Soft Delete" @click.prevent="addField(key, 'soft-delete')">
                                        <i class="bx bx-check"></i>
                                    </button>
                                    <button class="tippy flex flex-col justify-center items-center hover:text-warning-500" :id="item.id+'_forgin_key'" title="Add Forgin Key" @click.prevent="addField(key, 'key')">
                                        <i class="bx bx-link"></i>
                                    </button>
                                    <div class="flex flex-col justify-center items-center" v-show="!item.data.show || item.data.show === '0'" @click.prevent="nodesItems[key].data.show=!nodesItems[key].data.show">
                                        <i class="bx bx-chevron-up"></i>
                                    </div>
                                    <div class="flex flex-col justify-center items-center" v-show="item.data.show && item.data.show !== '0'" @click.prevent="nodesItems[key].data.show=!nodesItems[key].data.show">
                                        <i class="bx bx-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="border-b border-gray-300 p-2 flex flex-col gap-4 bg-gray-100" v-show="item.data.show && item.data.show !== '0'">
                                <VueDraggableNext
                                    :list="item.data.fields"
                                    order-by="orderBy"
                                    group="drag"
                                    class="flex flex-col gap-4"
                                >
                                    <div class="grid grid-cols-12 gap-2" v-for="(field, index) in item.data.fields">
                                        <div class="flex flex-col justify-center items-center">
                                            <button>
                                                <i class="bx bx-move" style="line-height: 0 !important;"></i>
                                            </button>
                                        </div>
                                        <div class="col-span-4">
                                            <input type="text" :ref="el => { tables[nodesItems[key]?.data.table+'_'+index] = el }" v-model="nodesItems[key].data.fields[index].name" @input="nodesItems[key].data.fields[index].name = nodesItems[key].data.fields[index].name.replaceAll(' ', '_')" @keypress.enter.prevent="addField(key, item.data.fields[item.data.fields.length-1].position, item.data.fields[item.data.fields.length-1].id)" placeholder="Table Name" class="block w-full h-10 border border-gray-200 bg-gray-400/10 placeholder-gray-500  transition duration-75 rounded-lg focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400" />
                                        </div>
                                        <div class="col-span-4">
                                            <select :ref="el => { tables[nodesItems[key]?.data.table+'_type_'+index] = el }" v-model="nodesItems[key].data.fields[index].type" class="block w-full h-10 border border-gray-200 bg-gray-400/10 placeholder-gray-500 transition duration-75 rounded-lg focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400">
                                                <option value="int">int</option>
                                                <option value="string">varchar</option>
                                                <option value="bigint">bigint</option>
                                                <option value="boolean">boolean</option>
                                                <option value="text">text</option>
                                                <option value="longText">longText</option>
                                                <option value="char">char</option>
                                                <option value="flot">flot</option>
                                                <option value="double">double</option>
                                                <option value="json">json</option>
                                                <option value="enum">enum</option>
                                                <option value="jsonb">jsonb</option>
                                                <option value="date">date</option>
                                                <option value="time">time</option>
                                                <option value="datetime">datetime</option>
                                                <option value="timestamps">timestamps</option>
                                            </select>
                                        </div>
                                        <div class="col-span-3 flex flex-col justify-center items-center">
                                            <div class="flex justify-start gap-4">
                                                <button title="NULL" :id="'make_null_'+index" class="tippy font-bold hover:text-primary-500" @click.prevent="nodesItems[key].data.fields[index].nullable = !nodesItems[key].data.fields[index].nullable" :class="{
                                                    'text-primary-500' : nodesItems[key].data.fields[index].nullable
                                                }">N</button>
                                                <button title="Key Type" :id="'key_type_'+index" class="tippy flex flex-col justify-center items-center hover:text-green-500" @click.prevent="nodesItems[key].data.fields[index].key_type_show = !nodesItems[key].data.fields[index].key_type_show; nodesItems[key].data.fields[index].more_option_show = false">
                                                    <i class="bx bx-key text-green-500" v-if="nodesItems[key].data.fields[index].index_type === 'primary_key'"></i>
                                                    <i class="bx bx-link text-green-500" v-else-if="nodesItems[key].data.fields[index].index_type === 'foreign_key'"></i>
                                                    <i class="bx bxs-color text-green-500" v-else-if="nodesItems[key].data.fields[index].index_type === 'unique'"></i>
                                                    <i class="bx bx-circle" v-else></i>
                                                </button>
                                                <button title="Options" :id="'options_'+index" class="tippy hover:text-primary-500" @click.prevent="nodesItems[key].data.fields[index].more_option_show = !nodesItems[key].data.fields[index].more_option_show; nodesItems[key].data.fields[index].key_type_show = false">
                                                    <i class="bx bx-dots-vertical" ></i>
                                                </button>
                                                <button title="Delete Col" :id="'delete_col_'+index" class="tippy hover:text-danger-500" @click.prevent="removeCol(index, key)">
                                                    <i class="bx bx-trash" ></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-span-12" style="margin: 0 -8px 0 -8px !important;">
                                            <div class="p-4 flex flex-col gap-4 bg-gray-300" v-if="nodesItems[key].data.fields[index].key_type_show">
                                                <div>
                                                    <label class="text-sm text-gray-400">
                                                        {{__('key_type')}}
                                                    </label>
                                                </div>
                                                <div class="flex justify-between gap-2 hover:bg-primary-500 hover:text-white px-4 py-1 rounded-lg cursor-pointer" @click.prevent="nodesItems[key].data.fields[index].index_type = 'primary_key'; nodesItems[key].data.fields[index].linked_to_table = ''; nodesItems[key].data.fields[index].linked_to_field = ''">
                                                    <div class="flex justify-start gap-2 w-full">
                                                        <div  class=" w-4 flex flex-col justify-center items-center">
                                                            <i v-if="nodesItems[key].data.fields[index].index_type === 'primary_key'" class="bx bx-check text-green-600" ></i>
                                                        </div>

                                                        <div>
                                                            <h1> {{__('primary_key')}}</h1>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col justify-center items-center text-center w-6">
                                                        <i class="bx bx-key" ></i>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2 hover:bg-primary-500 hover:text-white px-4 py-1 rounded-lg cursor-pointer" @click.prevent="nodesItems[key].data.fields[index].index_type = 'foreign_key';">
                                                    <div class="flex justify-start gap-2 w-full">
                                                        <div  class=" w-4 flex flex-col justify-center items-center">
                                                            <i v-if="nodesItems[key].data.fields[index].index_type === 'foreign_key'" class="bx bx-check text-green-600" ></i>
                                                        </div>

                                                        <div>
                                                            <h1>{{ __('foreign_key') }}</h1>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col justify-center items-center text-center w-6">
                                                        <i class="bx bx-link" ></i>
                                                    </div>
                                                </div>
                                                <div v-if="nodesItems[key].data.fields[index].index_type === 'foreign_key'" class="flex flex-col gap-4">
                                                    <div>
                                                        <label for="" class="text-sm text-gray-400">
                                                            {{ __('linked_to_table') }}
                                                        </label>
                                                        <Multiselect
                                                            v-model="nodesItems[key].data.fields[index].linked_to_table"
                                                            :options="nodes"
                                                            label="data.table"
                                                        >
                                                            <template #singleLabel="props">
                                                                {{props.option.data.table}}
                                                            </template>
                                                            <template #option="props">
                                                                {{props.option.data.table}}
                                                            </template>
                                                        </Multiselect>
                                                    </div>
                                                    <div>
                                                        <label for="" class="text-sm text-gray-400">
                                                            {{ __('linked_to_field') }}
                                                        </label>
                                                        <Multiselect
                                                            :id="key+'_'+index"
                                                            @select="linkTable"
                                                            :disabled="!nodesItems[key].data.fields[index].linked_to_table"
                                                            v-model="nodesItems[key].data.fields[index].linked_to_field"
                                                            :options="nodesItems[key].data?.fields[index].linked_to_table?.data ? nodesItems[key].data.fields[index].linked_to_table.data.fields.filter((item)=>item.type === 'bigint') : []"
                                                            label="name"
                                                            track-by="name"
                                                        />
                                                    </div>
                                                    <div>
                                                        <label for="" class="text-sm text-gray-400">
                                                            {{ __('on_delete') }}
                                                        </label>
                                                        <Multiselect
                                                            :disabled="!nodesItems[key].data.fields[index].linked_to_table"
                                                            v-model="nodesItems[key].data.fields[index].on_delete"
                                                            :options="[
                                                        {
                                                            name: 'Cascade',
                                                            id: 'cascade'
                                                        },
                                                        {
                                                            name: 'Set Null',
                                                            id: 'set null'
                                                        },
                                                        {
                                                            name: 'NULL',
                                                            id: null
                                                        },
                                                    ]"
                                                            label="name"
                                                            track-by="name"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2 bg-gray-300 hover:bg-primary-500 px-4 py-1 hover:text-white rounded-lg cursor-pointer" @click.prevent="nodesItems[key].data.fields[index].index_type = 'unique';  nodesItems[key].data.fields[index].linked_to_table = ''; nodesItems[key].data.fields[index].linked_to_field = ''">
                                                    <div class="flex justify-start gap-2 w-full">
                                                        <div  class="flex flex-col justify-center items-center w-4">
                                                            <i v-if="nodesItems[key].data.fields[index].index_type === 'unique'" class="bx bx-check text-green-600" ></i>
                                                        </div>

                                                        <div>
                                                            <h1>{{__('unique_key') }}</h1>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col justify-center items-center text-center w-6">
                                                        <i class="bx bxs-color" ></i>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between gap-2 bg-gray-300 hover:bg-primary-500 hover:text-white px-4 py-1 rounded-lg cursor-pointer" @click.prevent="nodesItems[key].data.fields[index].index_type = null;  nodesItems[key].data.fields[index].linked_to_table = ''; nodesItems[key].data.fields[index].linked_to_field = ''">
                                                    <div class="flex justify-start gap-2 w-full">
                                                        <div  class="flex flex-col justify-center items-center w-4">
                                                            <i v-if="!nodesItems[key].data.fields[index].index_type" class="bx bx-check text-green-600" ></i>
                                                        </div>

                                                        <div>
                                                            <h1>{{ __('none') }}</h1>
                                                        </div>
                                                    </div>

                                                    <div class="flex flex-col justify-center items-center text-center w-6">
                                                        <i class="bx bx-circle" ></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4 flex flex-col gap-4 bg-gray-200" v-if="nodesItems[key].data.fields[index].more_option_show">
                                                <div>
                                                    <label class="text-gray-400 text-sm">Column Options</label>
                                                    <div class="flex justify-start gap-2">
                                                        <div class="flex flex-col justify-center items-center">
                                                            <input class="dark:bg-gray-700 dark:border-gray-600 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50" type="checkbox" v-model="nodesItems[key].data.fields[index].auto_increment"/>
                                                        </div>
                                                        <label>{{__('auto_increment')}}</label>
                                                    </div>
                                                    <div class="flex justify-start gap-2">
                                                        <div class="flex flex-col justify-center items-center">
                                                            <input class="dark:bg-gray-700 dark:border-gray-600 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50" type="checkbox" v-model="nodesItems[key].data.fields[index].unsigned"/>
                                                        </div>
                                                        <label>{{ __('unsigned') }}</label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="text-gray-400 text-sm">{{__('default')}}</label>
                                                    <input type="text" v-model="nodesItems[key].data.fields[index].default" :placeholder="__('default_value')" class="block w-full focus:text-black border border-gray-200 bg-gray-400/10 placeholder-gray-500 transition duration-75 rounded-lg focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400"/>
                                                </div>
                                                <div>
                                                    <label class="text-gray-400 text-sm">{{__('length')}}</label>
                                                    <input type="number" v-model="nodesItems[key].data.fields[index].length" :placeholder="__('length')" class="block w-full focus:text-black border border-gray-200 bg-gray-400/10 placeholder-gray-500 transition duration-75 rounded-lg focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400"/>
                                                </div>
                                                <div>
                                                    <label class="text-gray-400 text-sm">{{__('comment')}}</label>
                                                    <textarea type="text" v-model="nodesItems[key].data.fields[index].comment" :placeholder="__('comment')" class="block w-full focus:text-black border border-gray-200 bg-gray-400/10 placeholder-gray-500 transition duration-75 rounded-lg focus:bg-white focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </VueDraggableNext>
                            </div>
                        </div>
                    </div>
                </VueDraggableNext>
            </div>
        </div>
        <div class="col-span-8 border bg-white rounded-lg border-gray-200 shadow-sm">
             <div style="height: 100%; width: 100%">
                 <VueFlow
                     v-model="nodesItems"
                     fit-view-on-init
                     @edge-update="onEdgeUpdate"
                     @node-click="onNodeClick"
                     class="basicflow"
                     :default-edge-options="{ type: 'smoothstep' }"
                     :default-viewport="{ zoom: 1.5 }"
                     :min-zoom="0.2"
                     :max-zoom="4"
                 >
                     <Background pattern-color="#aaa" gap="8" />

                     <MiniMap pannable zoomable />

                     <Controls />

                     <template #connection-line="{ sourceX, sourceY, targetX, targetY, sourcePosition, targetPosition }">
                         <CustomConnectionLine :source-x="sourceX" :source-y="sourceY" :target-x="targetX" :target-y="targetY" :sourcePosition="sourcePosition" :targetPosition="targetPosition"  />
                     </template>

                     <template #edge-custom="props">
                         <Edge v-bind="props" />
                     </template>

                     <template #node-custom="{ data }">
                         <NodeToolbar
                             style="display: flex; gap: 0.5rem; align-items: center"
                             :is-visible="data.toolbarVisible"
                             :position="data.toolbarPosition"
                         >
                             <button v-tooltip="__('delete_table')" @click.prevent="removeNode(data.id)">
                                 <i class="bx bx-trash text-red-500"></i>
                             </button>
                             <button v-tooltip="__('edit_from')" @click.prevent="goToForm(data.table)">
                                 <i class="bx bx-building text-primary-500"></i>
                             </button>
                         </NodeToolbar>
                         <div class="min-w-32 h-full bg-white rounded-md overflow-hidden shadow-sm">
                             <div class="h-1" :style="'background-color:'+ data.color "></div>
                             <div class="p-1 text-center border-b text-xs ">
                                 <h1 class="font-bold">{{ data.table }}</h1>
                             </div>
                             <div class="text-xs">
                                 <div class="border-b p-1 flex justify-around hover:text-purple-400 hover:bg-gray-100 gap-6" v-for="(item, key) in data.fields">
                                     <Handle :connectable="true" :id="item.name+'_right_'+data.table" type="source" :position="Position.Right" :style="{
                                         backgroundColor: data.color,
                                         top: (key === 0 ? 40 : key === 1 ? 40+25 : 40+(25*key)).toString()+'px',
                                     }" />
                                     <div class="font-bold w-full">
                                         <div class="flex justify-start gap-2" >
                                             <div class="flex flex-col items-center justify-center text-green-500" @click.prevent="data.fields[key].key_type_show = !data.fields[key].key_type_show">
                                                 <i class="bx bx-key" v-if="item.index_type === 'primary_key'"></i>
                                                 <i class="bx bxs-color" v-if="item.index_type === 'unique'"></i>
                                             </div>
                                             <div @click.prevent="tables[data.table+'_'+key].focus()">
                                                 {{ item.name }}
                                             </div>
                                         </div>
                                     </div>
                                     <div @click.prevent="tables[data.table+'_type_'+key].focus()">
                                         {{ item.type }}{{ item.length ? '(' + item.length + ')' : null }}{{ item.nullable ? '?' : null }}
                                     </div>
                                     <Handle  :connectable="true" :id="item.name+'_left_'+data.table" type="source" :position="Position.Left" :style="{
                                         backgroundColor: data.color,
                                         top: (key === 0 ? 40 : key === 1 ? 40+25 : 40+(25*key)).toString()+'px',
                                     }" />
                                 </div>
                             </div>
                         </div>
                     </template>
                 </VueFlow>
             </div>
        </div>
    </div>
</template>

<style>
@import '@vue-flow/core/dist/style.css';
@import '@vue-flow/core/dist/theme-default.css';
@import '@vue-flow/controls/dist/style.css';
@import '@vue-flow/minimap/dist/style.css';
@import '@vue-flow/node-resizer/dist/style.css';

.vue-flow__minimap {
    transform: scale(75%);
    transform-origin: bottom right;
}

</style>
