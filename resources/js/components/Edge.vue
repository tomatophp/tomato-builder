<script setup>
import {BaseEdge, EdgeLabelRenderer, getBezierPath, getSmoothStepPath, SmoothStepEdge, useVueFlow} from '@vue-flow/core'
import {computed, onMounted, ref, watch} from 'vue'
import Multiselect from "@suadelabs/vue3-multiselect";

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    sourceX: {
        type: Number,
        required: true,
    },
    sourceY: {
        type: Number,
        required: true,
    },
    targetX: {
        type: Number,
        required: true,
    },
    targetY: {
        type: Number,
        required: true,
    },
    sourcePosition: {
        type: String,
        required: true,
    },
    targetPosition: {
        type: String,
        required: true,
    },
    data: {
        type: Object,
        required: false,
    },
    markerEnd: {
        type: String,
        required: false,
    },
    style: {
        type: Object,
        required: false,
    },
})

const { removeEdges } = useVueFlow()

const path = computed(() => getSmoothStepPath(props))


let selected = ref("");

watch(selected, (newValue, oldValue)=>{
    let getNodes = localStorage.getItem('builder_tables');
    if(getNodes){
        let getNodeParse = JSON.parse(getNodes);
        for(let i=0; i<getNodeParse.length; i++){
            if(getNodeParse[i].id === props.id){
                getNodeParse[i].data.relation = selected.value;
                localStorage.setItem('builder_tables', JSON.stringify(getNodeParse));
            }
        }
    }
})
onMounted(() => {
    let getNodes = localStorage.getItem('builder_tables');
    if(getNodes){
        let getNodeParse = JSON.parse(getNodes);
        for(let i=0; i<getNodeParse.length; i++){
            if(getNodeParse[i].id === props.id){
                selected.value = getNodeParse[i].data.relation;
            }
        }
    }

});

</script>

<script>
export default {
    inheritAttrs: false,
}
</script>

<template>
    <!-- You can use the `BaseEdge` component to create your own custom edge more easily -->
    <SmoothStepEdge :id="id" :style="style" :path="path[0]" :marker-end="markerEnd" />

    <!-- Use the `EdgeLabelRenderer` to escape the SVG world of edges and render your own custom label in a `<div>` ctx -->
    <EdgeLabelRenderer>
        <div
            :style="{
                pointerEvents: 'all',
                position: 'absolute',
                transform: `translate(-50%, -50%) translate(${path[1]}px,${path[2]}px)`,
              }"
            class="nodrag nopan"
        >
            <div class="bg-gray-100 p-2 rounded-lg border shadow-sm text-xs">
<!--                <Multiselect v-model="selected" label="name" class="w-full rounded-lg border border-gray-200" :options="[-->
<!--                    {-->
<!--                        name: 'Has One',-->
<!--                        id: 'hasOne'-->
<!--                    },-->
<!--                    {-->
<!--                        name: 'Has Many',-->
<!--                        id: 'hasMany'-->
<!--                    },-->
<!--                    {-->
<!--                        name: 'Many To Many',-->
<!--                        id: 'ManyToMany'-->
<!--                    },-->
<!--                    {-->
<!--                        name: 'Many To One',-->
<!--                        id: 'ManyToOne'-->
<!--                    }-->
<!--                ]" />-->
                <div class="flex justify-center gap-2">
                    <div class="flex flex-col items-center justify-center">
                        <i class="bx bx-link" ></i>
                    </div>
                    <div>
                        Linked
                    </div>
                </div>
            </div>
<!--            <button class="edgebutton" @click="removeEdges(id)">×</button>-->
        </div>
    </EdgeLabelRenderer>
</template>
